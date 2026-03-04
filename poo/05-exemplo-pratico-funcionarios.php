<?php

/**
 * ==========================================================
 * EXEMPLO PRÁTICO COMPLETO: SISTEMA DE FUNCIONÁRIOS
 * ==========================================================
 * 
 * Este arquivo demonstra todos os conceitos de:
 * - Herança
 * - Polimorfismo
 * - Classes Abstratas
 * - Interfaces
 * - Sobrescrita de métodos
 */

// ============================================
// INTERFACES
// ============================================

interface Trabalhador
{
    public function trabalhar(): void;
    public function getSalario(): float;
}

interface Bonificavel
{
    public function calcularBonus(): float;
}

interface Gerenciavel
{
    public function gerenciarEquipe(): void;
    public function getSubordinados(): array;
}

// ============================================
// CLASSE ABSTRATA BASE
// ============================================

abstract class Funcionario implements Trabalhador, Bonificavel
{
    protected string $nome;
    protected string $cpf;
    protected float $salarioBase;
    protected string $departamento;
    protected \DateTime $dataContratacao;

    public function __construct(
        string $nome,
        string $cpf,
        float $salarioBase,
        string $departamento
    ) {
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->salarioBase = $salarioBase;
        $this->departamento = $departamento;
        $this->dataContratacao = new \DateTime();
    }

    // Getters
    public function getNome(): string
    {
        return $this->nome;
    }

    public function getDepartamento(): string
    {
        return $this->departamento;
    }

    public function getSalarioBase(): float
    {
        return $this->salarioBase;
    }

    // Método template - define estrutura, detalhes nas classes filhas
    public function gerarContraCheque(): void
    {
        echo "\n╔════════════════════════════════════╗\n";
        echo "║        CONTRA-CHEQUE               ║\n";
        echo "╠════════════════════════════════════╣\n";
        echo "║ Funcionário: {$this->nome}\n";
        echo "║ CPF: {$this->cpf}\n";
        echo "║ Departamento: {$this->departamento}\n";
        echo "║ Cargo: " . $this->getCargo() . "\n";
        echo "╠════════════════════════════════════╣\n";
        echo "║ Salário Base: R$ " . number_format($this->salarioBase, 2, ',', '.') . "\n";
        echo "║ Bônus: R$ " . number_format($this->calcularBonus(), 2, ',', '.') . "\n";
        echo "║ Descontos: R$ " . number_format($this->calcularDescontos(), 2, ',', '.') . "\n";
        echo "╠════════════════════════════════════╣\n";
        echo "║ TOTAL: R$ " . number_format($this->getSalario(), 2, ',', '.') . "\n";
        echo "╚════════════════════════════════════╝\n";
    }

    // Métodos abstratos - DEVEM ser implementados
    abstract public function getCargo(): string;
    abstract protected function calcularDescontos(): float;

    // Implementação padrão - pode ser sobrescrita
    public function calcularBonus(): float
    {
        return $this->salarioBase * 0.05; // 5% padrão
    }

    public function getSalario(): float
    {
        return $this->salarioBase + $this->calcularBonus() - $this->calcularDescontos();
    }
}

// ============================================
// CLASSES CONCRETAS
// ============================================

class Desenvolvedor extends Funcionario
{
    private string $linguagemPrincipal;
    private string $nivel; // junior, pleno, senior

    public function __construct(
        string $nome,
        string $cpf,
        float $salarioBase,
        string $linguagemPrincipal,
        string $nivel = 'junior'
    ) {
        parent::__construct($nome, $cpf, $salarioBase, "TI");
        $this->linguagemPrincipal = $linguagemPrincipal;
        $this->nivel = $nivel;
    }

    public function getCargo(): string
    {
        return "Desenvolvedor " . ucfirst($this->nivel) . " ({$this->linguagemPrincipal})";
    }

    public function trabalhar(): void
    {
        echo "👨‍💻 {$this->nome} está codando em {$this->linguagemPrincipal}...\n";
    }

    protected function calcularDescontos(): float
    {
        // INSS + IR simplificado
        return $this->salarioBase * 0.15;
    }

    // Sobrescrita do bônus - devs têm bônus por nível
    public function calcularBonus(): float
    {
        $multiplicador = match ($this->nivel) {
            'junior' => 0.05,
            'pleno' => 0.10,
            'senior' => 0.15,
            default => 0.05
        };
        return $this->salarioBase * $multiplicador;
    }

    public function getNivel(): string
    {
        return $this->nivel;
    }
}

class Gerente extends Funcionario implements Gerenciavel
{
    private array $subordinados = [];
    private float $metaBatida; // 0 a 1

    public function __construct(
        string $nome,
        string $cpf,
        float $salarioBase,
        string $departamento,
        float $metaBatida = 0.0
    ) {
        parent::__construct($nome, $cpf, $salarioBase, $departamento);
        $this->metaBatida = min(1, max(0, $metaBatida));
    }

    public function getCargo(): string
    {
        return "Gerente do departamento {$this->departamento}";
    }

    public function trabalhar(): void
    {
        echo "👔 {$this->nome} está em reunião de planejamento estratégico...\n";
    }

    protected function calcularDescontos(): float
    {
        // Gerentes têm desconto fixo de 20%
        return $this->salarioBase * 0.20;
    }

    // Gerentes têm bônus baseado em metas
    public function calcularBonus(): float
    {
        $bonusBase = $this->salarioBase * 0.10; // 10% base
        $bonusMeta = $this->salarioBase * 0.20 * $this->metaBatida; // até 20% por meta
        return $bonusBase + $bonusMeta;
    }

    public function adicionarSubordinado(Funcionario $funcionario): void
    {
        $this->subordinados[] = $funcionario;
        echo "✅ {$funcionario->getNome()} agora reporta para {$this->nome}\n";
    }

    public function gerenciarEquipe(): void
    {
        echo "📋 {$this->nome} está avaliando a equipe:\n";
        foreach ($this->subordinados as $sub) {
            echo "   - {$sub->getNome()} ({$sub->getCargo()})\n";
        }
    }

    public function getSubordinados(): array
    {
        return $this->subordinados;
    }
}

class Estagiario extends Funcionario
{
    private string $faculdade;
    private int $semestreAtual;

    public function __construct(
        string $nome,
        string $cpf,
        float $salarioBase,
        string $departamento,
        string $faculdade,
        int $semestreAtual
    ) {
        parent::__construct($nome, $cpf, $salarioBase, $departamento);
        $this->faculdade = $faculdade;
        $this->semestreAtual = $semestreAtual;
    }

    public function getCargo(): string
    {
        return "Estagiário - {$this->semestreAtual}º semestre";
    }

    public function trabalhar(): void
    {
        echo "📚 {$this->nome} está aprendendo e auxiliando nas tarefas...\n";
    }

    protected function calcularDescontos(): float
    {
        // Estagiário tem desconto menor
        return $this->salarioBase * 0.08;
    }

    // Estagiário não tem bônus
    public function calcularBonus(): float
    {
        return 0;
    }
}

// ============================================
// SISTEMA DE RECURSOS HUMANOS (POLIMORFISMO)
// ============================================

class RH
{
    /** @var Funcionario[] */
    private array $funcionarios = [];

    public function contratar(Funcionario $funcionario): void
    {
        $this->funcionarios[] = $funcionario;
        echo "🎉 Bem-vindo(a) {$funcionario->getNome()}! Cargo: {$funcionario->getCargo()}\n";
    }

    // Método polimórfico - funciona com qualquer Funcionario
    public function processarFolhaPagamento(): void
    {
        echo "\n========================================\n";
        echo "   PROCESSAMENTO DE FOLHA DE PAGAMENTO\n";
        echo "========================================\n";

        $totalFolha = 0;

        foreach ($this->funcionarios as $func) {
            $func->gerarContraCheque();
            $totalFolha += $func->getSalario();
        }

        echo "\n💰 TOTAL DA FOLHA: R$ " . number_format($totalFolha, 2, ',', '.') . "\n";
    }

    public function listarPorDepartamento(string $departamento): void
    {
        echo "\n📁 Funcionários do departamento {$departamento}:\n";
        foreach ($this->funcionarios as $func) {
            if ($func->getDepartamento() === $departamento) {
                echo "   - {$func->getNome()} ({$func->getCargo()})\n";
            }
        }
    }

    public function todosTrabalham(): void
    {
        echo "\n⏰ Início do expediente!\n";
        foreach ($this->funcionarios as $func) {
            $func->trabalhar(); // Polimorfismo em ação!
        }
    }

    public function getGerentes(): array
    {
        return array_filter(
            $this->funcionarios,
            fn($f) => $f instanceof Gerenciavel
        );
    }
}

// ============================================
// DEMONSTRAÇÃO
// ============================================

echo "╔═══════════════════════════════════════════════════╗\n";
echo "║     SISTEMA DE FUNCIONÁRIOS - POO PHP             ║\n";
echo "╚═══════════════════════════════════════════════════╝\n\n";

$rh = new RH();

// Contratando funcionários de diferentes tipos
echo "=== CONTRATAÇÕES ===\n";
$dev1 = new Desenvolvedor("João Silva", "123.456.789-00", 8000, "PHP", "senior");
$dev2 = new Desenvolvedor("Maria Santos", "234.567.890-11", 5500, "Python", "pleno");
$gerente = new Gerente("Carlos Oliveira", "345.678.901-22", 12000, "TI", 0.85);
$estagiario = new Estagiario("Ana Lima", "456.789.012-33", 1500, "TI", "USP", 5);

$rh->contratar($dev1);
$rh->contratar($dev2);
$rh->contratar($gerente);
$rh->contratar($estagiario);

// Configurando equipe do gerente
echo "\n=== CONFIGURANDO EQUIPE ===\n";
$gerente->adicionarSubordinado($dev1);
$gerente->adicionarSubordinado($dev2);
$gerente->adicionarSubordinado($estagiario);
$gerente->gerenciarEquipe();

// Todos trabalhando (polimorfismo)
$rh->todosTrabalham();

// Processando folha de pagamento
$rh->processarFolhaPagamento();

// Listando por departamento
$rh->listarPorDepartamento("TI");

echo "\n✅ Demonstração de Herança e Polimorfismo concluída!\n";
