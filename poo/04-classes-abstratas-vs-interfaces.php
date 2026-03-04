<?php

/**
 * ==========================================================
 * CLASSES ABSTRATAS vs INTERFACES
 * ==========================================================
 * 
 * Quando usar cada uma?
 * 
 * CLASSE ABSTRATA:
 * - Quando há código comum a ser compartilhado
 * - Quando as classes filhas têm relacionamento "é um"
 * - Só pode herdar de UMA classe abstrata
 * - Pode ter métodos com implementação
 * - Pode ter atributos
 * 
 * INTERFACE:
 * - Quando diferentes classes precisam do mesmo comportamento
 * - Quando as classes não têm relacionamento hierárquico
 * - Uma classe pode implementar MÚLTIPLAS interfaces
 * - Todos os métodos são abstratos (até PHP 8.0)
 * - Não pode ter atributos (apenas constantes)
 */

// ============================================
// EXEMPLO PRÁTICO: SISTEMA DE E-COMMERCE
// ============================================

// Interface para produtos que podem ser vendidos
interface Vendavel
{
    public function getPreco(): float;
    public function getDescricao(): string;
    public function temEstoque(): bool;
}

// Interface para itens que podem ser enviados
interface Enviavel
{
    public function getPeso(): float;
    public function getDimensoes(): array;
    public function calcularFrete(string $cep): float;
}

// Interface para produtos digitais
interface Downloadavel
{
    public function getUrlDownload(): string;
    public function getTamanhoArquivo(): int; // em bytes
}

// Classe abstrata base para todos os produtos
abstract class Produto implements Vendavel
{
    protected string $nome;
    protected float $preco;
    protected int $quantidade;

    public function __construct(string $nome, float $preco, int $quantidade)
    {
        $this->nome = $nome;
        $this->preco = $preco;
        $this->quantidade = $quantidade;
    }

    public function getPreco(): float
    {
        return $this->preco;
    }

    public function getDescricao(): string
    {
        return $this->nome;
    }

    public function temEstoque(): bool
    {
        return $this->quantidade > 0;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    // Método abstrato - cada produto calcula seu desconto
    abstract public function calcularDesconto(float $percentual): float;
}

// ============================================
// PRODUTOS FÍSICOS
// ============================================

class ProdutoFisico extends Produto implements Enviavel
{
    private float $peso;
    private float $largura;
    private float $altura;
    private float $profundidade;

    public function __construct(
        string $nome,
        float $preco,
        int $quantidade,
        float $peso,
        float $largura,
        float $altura,
        float $profundidade
    ) {
        parent::__construct($nome, $preco, $quantidade);
        $this->peso = $peso;
        $this->largura = $largura;
        $this->altura = $altura;
        $this->profundidade = $profundidade;
    }

    public function getPeso(): float
    {
        return $this->peso;
    }

    public function getDimensoes(): array
    {
        return [
            'largura' => $this->largura,
            'altura' => $this->altura,
            'profundidade' => $this->profundidade
        ];
    }

    public function calcularFrete(string $cep): float
    {
        // Simulação: R$ 5 por kg + R$ 0,01 por cm³
        $volume = $this->largura * $this->altura * $this->profundidade;
        return ($this->peso * 5) + ($volume * 0.01);
    }

    public function calcularDesconto(float $percentual): float
    {
        // Produtos físicos têm desconto máximo de 30%
        $percentualReal = min($percentual, 30);
        return $this->preco * ($percentualReal / 100);
    }
}

// ============================================
// PRODUTOS DIGITAIS
// ============================================

class ProdutoDigital extends Produto implements Downloadavel
{
    private string $urlDownload;
    private int $tamanhoArquivo;
    private string $formato;

    public function __construct(
        string $nome,
        float $preco,
        int $quantidade,
        string $urlDownload,
        int $tamanhoArquivo,
        string $formato
    ) {
        parent::__construct($nome, $preco, $quantidade);
        $this->urlDownload = $urlDownload;
        $this->tamanhoArquivo = $tamanhoArquivo;
        $this->formato = $formato;
    }

    public function getUrlDownload(): string
    {
        return $this->urlDownload;
    }

    public function getTamanhoArquivo(): int
    {
        return $this->tamanhoArquivo;
    }

    public function getFormato(): string
    {
        return $this->formato;
    }

    public function calcularDesconto(float $percentual): float
    {
        // Produtos digitais podem ter até 50% de desconto
        $percentualReal = min($percentual, 50);
        return $this->preco * ($percentualReal / 100);
    }

    public function getDescricao(): string
    {
        $tamanhoMB = number_format($this->tamanhoArquivo / (1024 * 1024), 2);
        return "{$this->nome} ({$this->formato}, {$tamanhoMB}MB)";
    }
}

// ============================================
// CARRINHO DE COMPRAS POLIMÓRFICO
// ============================================

class CarrinhoCompras
{
    /** @var Vendavel[] */
    private array $itens = [];

    public function adicionar(Vendavel $produto): void
    {
        if ($produto->temEstoque()) {
            $this->itens[] = $produto;
            echo "✅ Adicionado: " . $produto->getDescricao() . "\n";
        } else {
            echo "❌ Produto sem estoque: " . $produto->getDescricao() . "\n";
        }
    }

    public function calcularTotal(): float
    {
        $total = 0;
        foreach ($this->itens as $item) {
            $total += $item->getPreco();
        }
        return $total;
    }

    public function calcularFreteTotal(string $cep): float
    {
        $frete = 0;
        foreach ($this->itens as $item) {
            // Apenas produtos Enviavel têm frete
            if ($item instanceof Enviavel) {
                $frete += $item->calcularFrete($cep);
            }
        }
        return $frete;
    }

    public function listarItens(): void
    {
        echo "\n🛒 CARRINHO DE COMPRAS\n";
        echo "================================\n";
        
        foreach ($this->itens as $index => $item) {
            $tipo = match (true) {
                $item instanceof Downloadavel => "📥 Digital",
                $item instanceof Enviavel => "📦 Físico",
                default => "📋 Produto"
            };
            
            echo ($index + 1) . ". {$tipo}: " . $item->getDescricao();
            echo " - R$ " . number_format($item->getPreco(), 2, ',', '.') . "\n";
        }
    }

    public function getItensDownloadaveis(): array
    {
        return array_filter($this->itens, fn($item) => $item instanceof Downloadavel);
    }
}

// ============================================
// DEMONSTRAÇÃO
// ============================================

echo "=== SISTEMA DE E-COMMERCE ===\n\n";

// Criando produtos
$notebook = new ProdutoFisico(
    "Notebook Gamer",
    4599.00,
    5,
    peso: 2.5,
    largura: 40,
    altura: 3,
    profundidade: 27
);

$mouse = new ProdutoFisico(
    "Mouse Wireless",
    89.90,
    20,
    peso: 0.1,
    largura: 12,
    altura: 4,
    profundidade: 6
);

$ebook = new ProdutoDigital(
    "E-book PHP Avançado",
    49.90,
    999,
    "https://exemplo.com/downloads/php-avancado.pdf",
    15 * 1024 * 1024, // 15MB
    "PDF"
);

$curso = new ProdutoDigital(
    "Curso Completo de POO",
    199.00,
    999,
    "https://exemplo.com/cursos/poo",
    2 * 1024 * 1024 * 1024, // 2GB
    "MP4"
);

// Usando o carrinho polimórfico
$carrinho = new CarrinhoCompras();

$carrinho->adicionar($notebook);
$carrinho->adicionar($mouse);
$carrinho->adicionar($ebook);
$carrinho->adicionar($curso);

$carrinho->listarItens();

echo "\n================================\n";
$subtotal = $carrinho->calcularTotal();
$frete = $carrinho->calcularFreteTotal("01310-100");

echo "Subtotal: R$ " . number_format($subtotal, 2, ',', '.') . "\n";
echo "Frete: R$ " . number_format($frete, 2, ',', '.') . "\n";
echo "TOTAL: R$ " . number_format($subtotal + $frete, 2, ',', '.') . "\n";

// Listando downloads disponíveis
echo "\n📥 Downloads após a compra:\n";
foreach ($carrinho->getItensDownloadaveis() as $item) {
    /** @var Downloadavel $item */
    echo "- " . $item->getDescricao() . "\n";
    echo "  URL: " . $item->getUrlDownload() . "\n";
}

// ============================================
// TESTANDO DESCONTOS
// ============================================

echo "\n=== APLICANDO DESCONTOS ===\n";

$desconto20 = 20;
echo "\nDesconto de {$desconto20}%:\n";
echo "Notebook: -R$ " . number_format($notebook->calcularDesconto($desconto20), 2, ',', '.') . "\n";
echo "E-book: -R$ " . number_format($ebook->calcularDesconto($desconto20), 2, ',', '.') . "\n";

$desconto50 = 50;
echo "\nDesconto de {$desconto50}% (note os limites):\n";
echo "Notebook (máx 30%): -R$ " . number_format($notebook->calcularDesconto($desconto50), 2, ',', '.') . "\n";
echo "E-book (máx 50%): -R$ " . number_format($ebook->calcularDesconto($desconto50), 2, ',', '.') . "\n";
