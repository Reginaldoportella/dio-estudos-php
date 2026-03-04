<?php

/**
 * ==========================================================
 * RESUMO: HERANÇA E POLIMORFISMO EM PHP
 * ==========================================================
 */

echo "╔═══════════════════════════════════════════════════════════════╗\n";
echo "║        RESUMO - PILARES: HERANÇA E POLIMORFISMO               ║\n";
echo "╚═══════════════════════════════════════════════════════════════╝\n\n";

// ============================================
// CONCEITOS PRINCIPAIS
// ============================================

$resumo = <<<RESUMO
┌─────────────────────────────────────────────────────────────────────┐
│                           HERANÇA                                    │
├─────────────────────────────────────────────────────────────────────┤
│  • Permite criar classes filhas a partir de classes pai              │
│  • Usa a palavra-chave 'extends'                                     │
│  • Classes filhas herdam atributos e métodos                         │
│  • PHP só permite herança simples (uma classe pai)                   │
│  • Use 'parent::' para acessar métodos da classe pai                 │
│  • 'protected' permite acesso nas classes filhas                     │
│  • 'final' impede sobrescrita de métodos ou herança de classes       │
├─────────────────────────────────────────────────────────────────────┤
│  Exemplo:                                                            │
│    class Cachorro extends Animal {                                   │
│        public function __construct(\$nome) {                          │
│            parent::__construct(\$nome);                                │
│        }                                                             │
│    }                                                                 │
└─────────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────────┐
│                         POLIMORFISMO                                 │
├─────────────────────────────────────────────────────────────────────┤
│  • "Muitas formas" - mesmo método, comportamentos diferentes         │
│  • Permite tratar objetos diferentes de forma uniforme               │
│  • Pode ser alcançado via herança ou interfaces                      │
│  • Use 'instanceof' para verificar o tipo do objeto                  │
│  • Type hints garantem que o método recebe o tipo correto            │
├─────────────────────────────────────────────────────────────────────┤
│  Exemplo:                                                            │
│    function processar(Animal \$animal) {                              │
│        \$animal->emitirSom(); // Cada animal faz som diferente        │
│    }                                                                 │
└─────────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────────┐
│                      CLASSES ABSTRATAS                               │
├─────────────────────────────────────────────────────────────────────┤
│  • Não podem ser instanciadas diretamente                            │
│  • Usam a palavra-chave 'abstract'                                   │
│  • Podem ter métodos abstratos (sem implementação)                   │
│  • Podem ter métodos concretos (com implementação)                   │
│  • Classes filhas DEVEM implementar métodos abstratos                │
├─────────────────────────────────────────────────────────────────────┤
│  Exemplo:                                                            │
│    abstract class Forma {                                            │
│        abstract public function calcularArea(): float;               │
│        public function getCor() { return \$this->cor; }               │
│    }                                                                 │
└─────────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────────┐
│                         INTERFACES                                   │
├─────────────────────────────────────────────────────────────────────┤
│  • Definem um contrato de métodos obrigatórios                       │
│  • Usam a palavra-chave 'interface' e 'implements'                   │
│  • Uma classe pode implementar MÚLTIPLAS interfaces                  │
│  • Todos os métodos são públicos e abstratos (implicitamente)        │
│  • Não podem ter atributos (apenas constantes)                       │
├─────────────────────────────────────────────────────────────────────┤
│  Exemplo:                                                            │
│    interface Pagavel {                                               │
│        public function processar(float \$valor): bool;                │
│    }                                                                 │
│    class CartaoCredito implements Pagavel { ... }                    │
└─────────────────────────────────────────────────────────────────────┘
RESUMO;

echo $resumo;

// ============================================
// COMPARAÇÃO RÁPIDA
// ============================================

echo "\n\n";
echo "┌────────────────────┬───────────────────────┬────────────────────────┐\n";
echo "│    CARACTERÍSTICA  │   CLASSE ABSTRATA     │       INTERFACE        │\n";
echo "├────────────────────┼───────────────────────┼────────────────────────┤\n";
echo "│ Instanciável       │         Não           │          Não           │\n";
echo "│ Herança múltipla   │   Não (extends 1)     │  Sim (implements N)    │\n";
echo "│ Métodos concretos  │         Sim           │     Não (até PHP 8)    │\n";
echo "│ Atributos          │         Sim           │    Não (constantes)    │\n";
echo "│ Construtores       │         Sim           │          Não           │\n";
echo "│ Modificadores      │  public/protected     │    Apenas public       │\n";
echo "└────────────────────┴───────────────────────┴────────────────────────┘\n";

// ============================================
// EXERCÍCIO PRÁTICO
// ============================================

echo "\n\n";
echo "╔═══════════════════════════════════════════════════════════════╗\n";
echo "║                    EXERCÍCIO PRÁTICO                          ║\n";
echo "╚═══════════════════════════════════════════════════════════════╝\n\n";

/**
 * EXERCÍCIO: Complete as classes abaixo seguindo as instruções
 */

// Interface para veículos que podem ser alugados
interface Alugavel
{
    public function calcularAluguel(int $dias): float;
    public function estaDisponivel(): bool;
}

// Classe abstrata base
abstract class VeiculoFrota
{
    protected string $placa;
    protected string $modelo;
    protected bool $disponivel = true;

    public function __construct(string $placa, string $modelo)
    {
        $this->placa = $placa;
        $this->modelo = $modelo;
    }

    abstract public function getTipo(): string;

    public function getPlaca(): string
    {
        return $this->placa;
    }

    public function setDisponivel(bool $disponivel): void
    {
        $this->disponivel = $disponivel;
    }
}

// TODO: Implemente a classe CarroAluguel
class CarroAluguel extends VeiculoFrota implements Alugavel
{
    private float $diariaBase;

    public function __construct(string $placa, string $modelo, float $diariaBase)
    {
        parent::__construct($placa, $modelo);
        $this->diariaBase = $diariaBase;
    }

    public function getTipo(): string
    {
        return "Carro";
    }

    public function calcularAluguel(int $dias): float
    {
        // Desconto progressivo: 5% a partir de 7 dias, 10% a partir de 15 dias
        $desconto = match (true) {
            $dias >= 15 => 0.10,
            $dias >= 7 => 0.05,
            default => 0
        };

        $total = $this->diariaBase * $dias;
        return $total - ($total * $desconto);
    }

    public function estaDisponivel(): bool
    {
        return $this->disponivel;
    }
}

// TODO: Implemente a classe MotoAluguel
class MotoAluguel extends VeiculoFrota implements Alugavel
{
    private float $diariaBase;
    private int $cilindradas;

    public function __construct(string $placa, string $modelo, float $diariaBase, int $cilindradas)
    {
        parent::__construct($placa, $modelo);
        $this->diariaBase = $diariaBase;
        $this->cilindradas = $cilindradas;
    }

    public function getTipo(): string
    {
        return "Moto {$this->cilindradas}cc";
    }

    public function calcularAluguel(int $dias): float
    {
        // Motos com mais de 600cc têm adicional de 20%
        $adicional = $this->cilindradas > 600 ? 1.20 : 1.0;
        return $this->diariaBase * $dias * $adicional;
    }

    public function estaDisponivel(): bool
    {
        return $this->disponivel;
    }
}

// Testando o exercício
echo "--- Testando Sistema de Aluguel ---\n\n";

$carro = new CarroAluguel("ABC-1234", "Honda Civic", 150.00);
$moto1 = new MotoAluguel("XYZ-5678", "Honda CG 160", 50.00, 160);
$moto2 = new MotoAluguel("DEF-9012", "Kawasaki Z900", 180.00, 900);

$veiculos = [$carro, $moto1, $moto2];

foreach ($veiculos as $veiculo) {
    echo "Veículo: {$veiculo->getPlaca()} - {$veiculo->getTipo()}\n";
    echo "  Aluguel 3 dias: R$ " . number_format($veiculo->calcularAluguel(3), 2, ',', '.') . "\n";
    echo "  Aluguel 7 dias: R$ " . number_format($veiculo->calcularAluguel(7), 2, ',', '.') . "\n";
    echo "  Aluguel 15 dias: R$ " . number_format($veiculo->calcularAluguel(15), 2, ',', '.') . "\n";
    echo "  Disponível: " . ($veiculo->estaDisponivel() ? "Sim" : "Não") . "\n\n";
}

// ============================================
// PARABÉNS!
// ============================================

echo "\n";
echo "╔═══════════════════════════════════════════════════════════════╗\n";
echo "║                    🎉 PARABÉNS! 🎉                            ║\n";
echo "║                                                               ║\n";
echo "║  Você concluiu o módulo de Herança e Polimorfismo!            ║\n";
echo "║                                                               ║\n";
echo "║  Arquivos estudados:                                          ║\n";
echo "║  ✅ 01-heranca-conceitos.php                                  ║\n";
echo "║  ✅ 02-sobrescrita-metodos.php                                ║\n";
echo "║  ✅ 03-polimorfismo.php                                       ║\n";
echo "║  ✅ 04-classes-abstratas-vs-interfaces.php                    ║\n";
echo "║  ✅ 05-exemplo-pratico-funcionarios.php                       ║\n";
echo "║  ✅ 06-resumo-exercicio.php                                   ║\n";
echo "║                                                               ║\n";
echo "║  Próximo passo: Praticar criando seus próprios projetos!      ║\n";
echo "╚═══════════════════════════════════════════════════════════════╝\n";
