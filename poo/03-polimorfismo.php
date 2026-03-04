<?php

/**
 * ==========================================================
 * POLIMORFISMO EM PHP
 * ==========================================================
 * 
 * Polimorfismo = "muitas formas"
 * 
 * Permite que objetos de diferentes classes sejam tratados
 * de forma uniforme através de uma interface comum.
 * 
 * Tipos de Polimorfismo:
 * 1. Polimorfismo de Sobrescrita (Override) - já vimos
 * 2. Polimorfismo de Interface
 * 3. Polimorfismo Paramétrico (Type Hints)
 */

// ============================================
// EXEMPLO 1: POLIMORFISMO COM CLASSES ABSTRATAS
// ============================================

/**
 * Classes abstratas definem um "contrato" que as filhas
 * devem implementar. Não podem ser instanciadas diretamente.
 */
abstract class Forma
{
    protected string $cor;

    public function __construct(string $cor)
    {
        $this->cor = $cor;
    }

    // Método abstrato - DEVE ser implementado nas classes filhas
    abstract public function calcularArea(): float;
    
    // Método abstrato
    abstract public function desenhar(): void;

    // Método concreto - pode ser usado diretamente
    public function getCor(): string
    {
        return $this->cor;
    }
}

class Retangulo extends Forma
{
    private float $largura;
    private float $altura;

    public function __construct(string $cor, float $largura, float $altura)
    {
        parent::__construct($cor);
        $this->largura = $largura;
        $this->altura = $altura;
    }

    // Implementação obrigatória
    public function calcularArea(): float
    {
        return $this->largura * $this->altura;
    }

    public function desenhar(): void
    {
        echo "Desenhando um retângulo {$this->cor} ({$this->largura}x{$this->altura})\n";
    }
}

class Circulo extends Forma
{
    private float $raio;

    public function __construct(string $cor, float $raio)
    {
        parent::__construct($cor);
        $this->raio = $raio;
    }

    public function calcularArea(): float
    {
        return pi() * pow($this->raio, 2);
    }

    public function desenhar(): void
    {
        echo "Desenhando um círculo {$this->cor} (raio: {$this->raio})\n";
    }
}

class Triangulo extends Forma
{
    private float $base;
    private float $altura;

    public function __construct(string $cor, float $base, float $altura)
    {
        parent::__construct($cor);
        $this->base = $base;
        $this->altura = $altura;
    }

    public function calcularArea(): float
    {
        return ($this->base * $this->altura) / 2;
    }

    public function desenhar(): void
    {
        echo "Desenhando um triângulo {$this->cor} (base: {$this->base}, altura: {$this->altura})\n";
    }
}

// ============================================
// DEMONSTRAÇÃO - POLIMORFISMO EM AÇÃO
// ============================================

echo "=== POLIMORFISMO COM CLASSES ABSTRATAS ===\n\n";

// Criando diferentes formas
$formas = [
    new Retangulo("azul", 10, 5),
    new Circulo("vermelho", 7),
    new Triangulo("verde", 8, 6),
    new Retangulo("amarelo", 3, 3),
    new Circulo("roxo", 4)
];

// Polimorfismo: tratamos todas as formas da mesma maneira!
foreach ($formas as $forma) {
    $forma->desenhar();
    echo "Área: " . number_format($forma->calcularArea(), 2, ',', '.') . " cm²\n";
    echo "Cor: " . $forma->getCor() . "\n\n";
}

// Função que aceita qualquer Forma (Type Hint polimórfico)
function imprimirInfoForma(Forma $forma): void
{
    echo "Processando forma...\n";
    $forma->desenhar();
    echo "Área calculada: " . $forma->calcularArea() . "\n";
}

echo "--- Função Polimórfica ---\n";
imprimirInfoForma(new Circulo("laranja", 5));

// ============================================
// EXEMPLO 2: POLIMORFISMO COM INTERFACES
// ============================================

echo "\n=== POLIMORFISMO COM INTERFACES ===\n\n";

/**
 * Interfaces definem um contrato de métodos que uma classe
 * DEVE implementar. Uma classe pode implementar múltiplas interfaces.
 */

interface Pagavel
{
    public function processarPagamento(float $valor): bool;
    public function getDetalhes(): string;
}

interface Notificavel
{
    public function enviarNotificacao(string $mensagem): void;
}

// Uma classe pode implementar múltiplas interfaces
class CartaoCredito implements Pagavel, Notificavel
{
    private string $numero;
    private string $titular;

    public function __construct(string $numero, string $titular)
    {
        $this->numero = $numero;
        $this->titular = $titular;
    }

    public function processarPagamento(float $valor): bool
    {
        echo "Processando R$ {$valor} no cartão de crédito...\n";
        // Simulação de processamento
        return true;
    }

    public function getDetalhes(): string
    {
        $numeroMascarado = "**** **** **** " . substr($this->numero, -4);
        return "Cartão: {$numeroMascarado} - Titular: {$this->titular}";
    }

    public function enviarNotificacao(string $mensagem): void
    {
        echo "📧 SMS para titular do cartão: {$mensagem}\n";
    }
}

class Pix implements Pagavel, Notificavel
{
    private string $chave;
    private string $tipo;

    public function __construct(string $chave, string $tipo = "CPF")
    {
        $this->chave = $chave;
        $this->tipo = $tipo;
    }

    public function processarPagamento(float $valor): bool
    {
        echo "Transferindo R$ {$valor} via PIX...\n";
        return true;
    }

    public function getDetalhes(): string
    {
        return "PIX ({$this->tipo}): {$this->chave}";
    }

    public function enviarNotificacao(string $mensagem): void
    {
        echo "📱 Push notification: {$mensagem}\n";
    }
}

class Boleto implements Pagavel
{
    private string $codigoBarras;
    private string $vencimento;

    public function __construct(string $vencimento)
    {
        $this->codigoBarras = $this->gerarCodigoBarras();
        $this->vencimento = $vencimento;
    }

    private function gerarCodigoBarras(): string
    {
        return "23793.38128 " . rand(10000, 99999) . ".000000";
    }

    public function processarPagamento(float $valor): bool
    {
        echo "Gerando boleto de R$ {$valor}...\n";
        echo "Código de barras: {$this->codigoBarras}\n";
        return true;
    }

    public function getDetalhes(): string
    {
        return "Boleto - Vencimento: {$this->vencimento}";
    }
}

// ============================================
// USANDO POLIMORFISMO COM INTERFACES
// ============================================

// Função que aceita qualquer forma de pagamento
function realizarPagamento(Pagavel $metodoPagamento, float $valor): void
{
    echo "\n--- Realizando Pagamento ---\n";
    echo "Método: " . $metodoPagamento->getDetalhes() . "\n";
    
    if ($metodoPagamento->processarPagamento($valor)) {
        echo "✅ Pagamento realizado com sucesso!\n";
        
        // Verifica se também é Notificavel
        if ($metodoPagamento instanceof Notificavel) {
            $metodoPagamento->enviarNotificacao("Pagamento de R$ {$valor} confirmado!");
        }
    }
}

// Testando diferentes formas de pagamento
$cartao = new CartaoCredito("1234567890123456", "João Silva");
$pix = new Pix("joao@email.com", "Email");
$boleto = new Boleto("2026-03-15");

realizarPagamento($cartao, 150.00);
realizarPagamento($pix, 89.90);
realizarPagamento($boleto, 299.00);

// ============================================
// ARRAY DE PAGAMENTOS POLIMÓRFICO
// ============================================

echo "\n=== PROCESSAMENTO EM LOTE ===\n";

$pagamentos = [
    ['metodo' => new CartaoCredito("9876543210987654", "Maria Santos"), 'valor' => 50],
    ['metodo' => new Pix("11999998888", "Celular"), 'valor' => 25.50],
    ['metodo' => new CartaoCredito("1111222233334444", "Pedro Lima"), 'valor' => 199.90],
];

$total = 0;
foreach ($pagamentos as $pagamento) {
    $pagamento['metodo']->processarPagamento($pagamento['valor']);
    $total += $pagamento['valor'];
}

echo "\n💰 Total processado: R$ " . number_format($total, 2, ',', '.') . "\n";
