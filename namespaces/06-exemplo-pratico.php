<?php

/**
 * ============================================
 * 6. EXEMPLO PRÁTICO - SISTEMA DE E-COMMERCE
 * ============================================
 * 
 * Vamos aplicar tudo que aprendemos sobre namespaces
 * em um exemplo prático de mini sistema de e-commerce.
 */

echo "╔═══════════════════════════════════════════════════════════════╗\n";
echo "║       EXEMPLO PRÁTICO - MINI E-COMMERCE                        ║\n";
echo "╚═══════════════════════════════════════════════════════════════╝\n\n";

// ============================================
// ESTRUTURA DO PROJETO
// ============================================

echo "ESTRUTURA DO PROJETO:\n\n";

$estrutura = <<<TEXTO
   ┌─────────────────────────────────────────────────────┐
   │  ecommerce/                                         │
   │  ├── src/                                           │
   │  │   ├── Models/                                    │
   │  │   │   ├── Produto.php                            │
   │  │   │   ├── Cliente.php                            │
   │  │   │   └── Pedido.php                             │
   │  │   ├── Services/                                  │
   │  │   │   ├── CarrinhoService.php                    │
   │  │   │   └── PagamentoService.php                   │
   │  │   └── Contracts/                                 │
   │  │       └── PagamentoInterface.php                 │
   │  └── composer.json                                  │
   └─────────────────────────────────────────────────────┘

TEXTO;

echo $estrutura;

// ============================================
// DEFININDO OS NAMESPACES
// ============================================

// Contracts (Interfaces)
namespace Ecommerce\Contracts {
    
    interface Pagavel {
        public function getValorTotal(): float;
    }
    
    interface MetodoPagamento {
        public function processar(Pagavel $item): bool;
        public function getNome(): string;
    }
}

// Models
namespace Ecommerce\Models {
    
    use Ecommerce\Contracts\Pagavel;
    
    class Produto {
        public function __construct(
            private int $id,
            private string $nome,
            private float $preco,
            private int $estoque = 0
        ) {}
        
        public function getId(): int {
            return $this->id;
        }
        
        public function getNome(): string {
            return $this->nome;
        }
        
        public function getPreco(): float {
            return $this->preco;
        }
        
        public function getEstoque(): int {
            return $this->estoque;
        }
        
        public function temEstoque(int $quantidade = 1): bool {
            return $this->estoque >= $quantidade;
        }
        
        public function reduzirEstoque(int $quantidade): void {
            if ($this->temEstoque($quantidade)) {
                $this->estoque -= $quantidade;
            }
        }
        
        public function __toString(): string {
            return "{$this->nome} - R$ " . number_format($this->preco, 2, ',', '.');
        }
    }
    
    class Cliente {
        private array $pedidos = [];
        
        public function __construct(
            private int $id,
            private string $nome,
            private string $email
        ) {}
        
        public function getId(): int {
            return $this->id;
        }
        
        public function getNome(): string {
            return $this->nome;
        }
        
        public function getEmail(): string {
            return $this->email;
        }
        
        public function adicionarPedido(Pedido $pedido): void {
            $this->pedidos[] = $pedido;
        }
        
        public function getPedidos(): array {
            return $this->pedidos;
        }
    }
    
    class ItemPedido {
        public function __construct(
            private Produto $produto,
            private int $quantidade
        ) {}
        
        public function getProduto(): Produto {
            return $this->produto;
        }
        
        public function getQuantidade(): int {
            return $this->quantidade;
        }
        
        public function getSubtotal(): float {
            return $this->produto->getPreco() * $this->quantidade;
        }
    }
    
    class Pedido implements Pagavel {
        private array $itens = [];
        private string $status = 'pendente';
        private static int $contador = 0;
        private int $numero;
        
        public function __construct(
            private Cliente $cliente
        ) {
            self::$contador++;
            $this->numero = self::$contador;
        }
        
        public function getNumero(): int {
            return $this->numero;
        }
        
        public function getCliente(): Cliente {
            return $this->cliente;
        }
        
        public function adicionarItem(Produto $produto, int $quantidade = 1): void {
            $this->itens[] = new ItemPedido($produto, $quantidade);
        }
        
        public function getItens(): array {
            return $this->itens;
        }
        
        public function getValorTotal(): float {
            return array_reduce(
                $this->itens,
                fn($total, $item) => $total + $item->getSubtotal(),
                0.0
            );
        }
        
        public function getStatus(): string {
            return $this->status;
        }
        
        public function setStatus(string $status): void {
            $this->status = $status;
        }
        
        public function confirmar(): void {
            $this->status = 'confirmado';
            $this->cliente->adicionarPedido($this);
        }
    }
}

// Services
namespace Ecommerce\Services {
    
    use Ecommerce\Models\{Produto, Pedido, Cliente};
    use Ecommerce\Contracts\{Pagavel, MetodoPagamento};
    
    class CarrinhoService {
        private array $itens = [];
        
        public function adicionar(Produto $produto, int $quantidade = 1): void {
            $id = $produto->getId();
            
            if (isset($this->itens[$id])) {
                $this->itens[$id]['quantidade'] += $quantidade;
            } else {
                $this->itens[$id] = [
                    'produto' => $produto,
                    'quantidade' => $quantidade
                ];
            }
        }
        
        public function remover(int $produtoId): void {
            unset($this->itens[$produtoId]);
        }
        
        public function getItens(): array {
            return $this->itens;
        }
        
        public function getTotal(): float {
            return array_reduce(
                $this->itens,
                fn($total, $item) => 
                    $total + ($item['produto']->getPreco() * $item['quantidade']),
                0.0
            );
        }
        
        public function criarPedido(Cliente $cliente): Pedido {
            $pedido = new Pedido($cliente);
            
            foreach ($this->itens as $item) {
                $pedido->adicionarItem($item['produto'], $item['quantidade']);
            }
            
            return $pedido;
        }
        
        public function limpar(): void {
            $this->itens = [];
        }
        
        public function quantidadeItens(): int {
            return array_sum(array_column($this->itens, 'quantidade'));
        }
    }
    
    // Implementações de pagamento
    class PagamentoCartao implements MetodoPagamento {
        public function __construct(
            private string $numeroCartao,
            private string $cvv
        ) {}
        
        public function processar(Pagavel $item): bool {
            // Simula processamento
            $valor = $item->getValorTotal();
            echo "      💳 Processando cartão {$this->mascarar()}...\n";
            echo "      📝 Valor: R$ " . number_format($valor, 2, ',', '.') . "\n";
            
            // Simula aprovação (90% de chance)
            $aprovado = rand(1, 10) <= 9;
            
            if ($aprovado) {
                echo "      ✅ Pagamento APROVADO!\n";
            } else {
                echo "      ❌ Pagamento RECUSADO!\n";
            }
            
            return $aprovado;
        }
        
        public function getNome(): string {
            return 'Cartão de Crédito';
        }
        
        private function mascarar(): string {
            return '**** **** **** ' . substr($this->numeroCartao, -4);
        }
    }
    
    class PagamentoPix implements MetodoPagamento {
        public function processar(Pagavel $item): bool {
            $valor = $item->getValorTotal();
            $chave = $this->gerarChave();
            
            echo "      📱 PIX gerado!\n";
            echo "      🔑 Chave: {$chave}\n";
            echo "      📝 Valor: R$ " . number_format($valor, 2, ',', '.') . "\n";
            echo "      ✅ Aguardando confirmação...\n";
            echo "      ✅ Pagamento confirmado!\n";
            
            return true;
        }
        
        public function getNome(): string {
            return 'PIX';
        }
        
        private function gerarChave(): string {
            return sprintf(
                '%08x-%04x-%04x-%04x-%012x',
                rand(0, 0xffffffff),
                rand(0, 0xffff),
                rand(0, 0xffff),
                rand(0, 0xffff),
                rand(0, 0xffffffffffff)
            );
        }
    }
    
    class CheckoutService {
        public function finalizar(
            Pedido $pedido,
            MetodoPagamento $metodoPagamento
        ): bool {
            echo "   📦 Finalizando pedido #{$pedido->getNumero()}...\n";
            echo "   👤 Cliente: {$pedido->getCliente()->getNome()}\n";
            echo "   💰 Total: R$ " . number_format($pedido->getValorTotal(), 2, ',', '.') . "\n";
            echo "   💳 Método: {$metodoPagamento->getNome()}\n\n";
            
            $sucesso = $metodoPagamento->processar($pedido);
            
            if ($sucesso) {
                $pedido->confirmar();
                echo "\n   🎉 Pedido confirmado com sucesso!\n";
            } else {
                $pedido->setStatus('falha_pagamento');
                echo "\n   😔 Falha no pagamento. Tente novamente.\n";
            }
            
            return $sucesso;
        }
    }
}

// ============================================
// DEMONSTRAÇÃO - SIMULANDO COMPRA
// ============================================

namespace {
    
    // Importando classes
    use Ecommerce\Models\{Produto, Cliente, Pedido};
    use Ecommerce\Services\{
        CarrinhoService,
        CheckoutService,
        PagamentoCartao,
        PagamentoPix
    };
    
    echo "\n" . str_repeat("=", 60) . "\n";
    echo "           SIMULAÇÃO DE COMPRA\n";
    echo str_repeat("=", 60) . "\n\n";
    
    // Criando produtos
    echo "1. CADASTRANDO PRODUTOS:\n\n";
    
    $produtos = [
        new Produto(1, "Notebook Dell Inspiron", 3499.90, 10),
        new Produto(2, "Mouse Logitech MX Master", 549.90, 25),
        new Produto(3, "Teclado Mecânico Redragon", 299.90, 15),
        new Produto(4, "Monitor LG 27\" 4K", 2199.90, 8),
    ];
    
    foreach ($produtos as $p) {
        echo "   ✓ {$p}\n";
    }
    
    // Criando cliente
    echo "\n2. CLIENTE:\n\n";
    
    $cliente = new Cliente(1, "Maria Silva", "maria@email.com");
    echo "   👤 {$cliente->getNome()} ({$cliente->getEmail()})\n";
    
    // Adicionando ao carrinho
    echo "\n3. ADICIONANDO AO CARRINHO:\n\n";
    
    $carrinho = new CarrinhoService();
    $carrinho->adicionar($produtos[0], 1);  // Notebook
    $carrinho->adicionar($produtos[1], 2);  // 2x Mouse
    $carrinho->adicionar($produtos[2], 1);  // Teclado
    
    foreach ($carrinho->getItens() as $item) {
        $subtotal = $item['produto']->getPreco() * $item['quantidade'];
        echo "   🛒 {$item['quantidade']}x {$item['produto']->getNome()}";
        echo " = R$ " . number_format($subtotal, 2, ',', '.') . "\n";
    }
    
    echo "\n   📊 Total de itens: {$carrinho->quantidadeItens()}\n";
    echo "   💰 Total: R$ " . number_format($carrinho->getTotal(), 2, ',', '.') . "\n";
    
    // Criando pedido
    echo "\n4. CRIANDO PEDIDO:\n\n";
    
    $pedido = $carrinho->criarPedido($cliente);
    echo "   📋 Pedido #{$pedido->getNumero()} criado!\n";
    echo "   📊 Status: {$pedido->getStatus()}\n";
    
    // Finalizando com pagamento
    echo "\n5. PROCESSANDO PAGAMENTO:\n\n";
    
    $checkout = new CheckoutService();
    
    // Escolha o método (descomente um):
    
    // Opção 1: Cartão de crédito
    // $metodoPagamento = new PagamentoCartao("4111111111111234", "123");
    
    // Opção 2: PIX
    $metodoPagamento = new PagamentoPix();
    
    $sucesso = $checkout->finalizar($pedido, $metodoPagamento);
    
    // Status final
    echo "\n6. STATUS FINAL:\n\n";
    echo "   📋 Pedido #{$pedido->getNumero()}\n";
    echo "   📊 Status: {$pedido->getStatus()}\n";
    echo "   👤 Cliente: {$cliente->getNome()}\n";
    echo "   📦 Pedidos do cliente: " . count($cliente->getPedidos()) . "\n";
    
    // Limpando carrinho
    $carrinho->limpar();
    echo "\n   🧹 Carrinho limpo!\n";
    
    // ============================================
    // MOSTRANDO OS NAMESPACES UTILIZADOS
    // ============================================
    
    echo "\n" . str_repeat("=", 60) . "\n";
    echo "           NAMESPACES UTILIZADOS\n";
    echo str_repeat("=", 60) . "\n\n";
    
    echo "   Classes criadas:\n";
    echo "   ├── Ecommerce\\Contracts\\Pagavel (interface)\n";
    echo "   ├── Ecommerce\\Contracts\\MetodoPagamento (interface)\n";
    echo "   ├── Ecommerce\\Models\\Produto\n";
    echo "   ├── Ecommerce\\Models\\Cliente\n";
    echo "   ├── Ecommerce\\Models\\ItemPedido\n";
    echo "   ├── Ecommerce\\Models\\Pedido\n";
    echo "   ├── Ecommerce\\Services\\CarrinhoService\n";
    echo "   ├── Ecommerce\\Services\\PagamentoCartao\n";
    echo "   ├── Ecommerce\\Services\\PagamentoPix\n";
    echo "   └── Ecommerce\\Services\\CheckoutService\n";
    
    echo "\n   Verificando nome completo das classes:\n";
    echo "   • Produto: " . get_class($produtos[0]) . "\n";
    echo "   • Cliente: " . get_class($cliente) . "\n";
    echo "   • Pedido: " . get_class($pedido) . "\n";
    echo "   • Checkout: " . get_class($checkout) . "\n";
    
    // ============================================
    // RESUMO FINAL
    // ============================================
    
    echo "\n╔═══════════════════════════════════════════════════════════════╗\n";
    echo "║              O QUE APRENDEMOS NESTE MÓDULO                     ║\n";
    echo "╠═══════════════════════════════════════════════════════════════╣\n";
    echo "║  ✓ Namespaces organizam código e evitam conflitos             ║\n";
    echo "║  ✓ Use 'namespace' para declarar o espaço de nomes            ║\n";
    echo "║  ✓ Use 'use' para importar classes de outros namespaces       ║\n";
    echo "║  ✓ Use 'as' para criar aliases quando há conflitos            ║\n";
    echo "║  ✓ Autoload carrega classes automaticamente                   ║\n";
    echo "║  ✓ Composer simplifica autoload com PSR-4                     ║\n";
    echo "║  ✓ Estruture projetos: 1 classe = 1 arquivo = 1 namespace     ║\n";
    echo "╚═══════════════════════════════════════════════════════════════╝\n";
}
