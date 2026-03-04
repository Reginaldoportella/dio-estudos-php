<?php

/**
 * ==========================================================
 * SOBRESCRITA DE MÉTODOS (METHOD OVERRIDE)
 * ==========================================================
 * 
 * Sobrescrita permite que uma classe filha redefina um método
 * da classe pai, alterando seu comportamento.
 * 
 * Regras:
 * - O método deve ter o mesmo nome
 * - Deve ter a mesma assinatura (mesmos parâmetros)
 * - Pode usar parent:: para chamar o método original
 */

// ============================================
// CLASSE BASE
// ============================================

class Veiculo
{
    protected string $marca;
    protected string $modelo;
    protected int $ano;

    public function __construct(string $marca, string $modelo, int $ano)
    {
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->ano = $ano;
    }

    public function ligar(): void
    {
        echo "O veículo {$this->modelo} está ligando...\n";
    }

    public function desligar(): void
    {
        echo "O veículo {$this->modelo} está desligando...\n";
    }

    public function mover(): void
    {
        echo "O veículo está se movendo.\n";
    }

    public function getInfo(): string
    {
        return "{$this->marca} {$this->modelo} ({$this->ano})";
    }
}

// ============================================
// SOBRESCRITA DE MÉTODOS
// ============================================

class Carro extends Veiculo
{
    private int $portas;

    public function __construct(string $marca, string $modelo, int $ano, int $portas = 4)
    {
        parent::__construct($marca, $modelo, $ano);
        $this->portas = $portas;
    }

    // Sobrescrevendo o método ligar()
    public function ligar(): void
    {
        echo "Girando a chave...\n";
        echo "O carro {$this->modelo} está ligando o motor!\n";
    }

    // Sobrescrevendo e extendendo com parent::
    public function mover(): void
    {
        parent::mover(); // Chama o método original
        echo "O carro está acelerando na estrada.\n";
    }

    // Sobrescrevendo getInfo() para adicionar informações
    public function getInfo(): string
    {
        $infoBase = parent::getInfo();
        return "{$infoBase} - {$this->portas} portas";
    }
}

class Motocicleta extends Veiculo
{
    private int $cilindradas;

    public function __construct(string $marca, string $modelo, int $ano, int $cilindradas)
    {
        parent::__construct($marca, $modelo, $ano);
        $this->cilindradas = $cilindradas;
    }

    // Sobrescrevendo o método ligar()
    public function ligar(): void
    {
        echo "Acionando a partida...\n";
        echo "A moto {$this->modelo} está rugindo! VRUMMM!\n";
    }

    // Sobrescrevendo mover()
    public function mover(): void
    {
        echo "A motocicleta está cortando o vento!\n";
    }

    public function empinar(): void
    {
        echo "A moto {$this->modelo} está empinando! 🏍️\n";
    }

    public function getInfo(): string
    {
        return parent::getInfo() . " - {$this->cilindradas}cc";
    }
}

class Bicicleta extends Veiculo
{
    private int $marchas;

    public function __construct(string $marca, string $modelo, int $ano, int $marchas)
    {
        parent::__construct($marca, $modelo, $ano);
        $this->marchas = $marchas;
    }

    // Bicicleta não liga como um motor
    public function ligar(): void
    {
        echo "Bicicleta {$this->modelo} pronta para pedalar!\n";
    }

    public function mover(): void
    {
        echo "Pedalando a bicicleta...\n";
    }
}

// ============================================
// DEMONSTRAÇÃO
// ============================================

echo "=== SOBRESCRITA DE MÉTODOS ===\n\n";

$fusca = new Carro("Volkswagen", "Fusca", 1970, 2);
$ninja = new Motocicleta("Kawasaki", "Ninja", 2023, 1000);
$caloi = new Bicicleta("Caloi", "Explorer", 2022, 21);

// Mesmo método, comportamentos diferentes
echo "--- Ligando os Veículos ---\n";
$fusca->ligar();
echo "\n";
$ninja->ligar();
echo "\n";
$caloi->ligar();

echo "\n--- Movendo os Veículos ---\n";
$fusca->mover();
echo "\n";
$ninja->mover();
echo "\n";
$caloi->mover();

echo "\n--- Informações Detalhadas ---\n";
echo "Carro: " . $fusca->getInfo() . "\n";
echo "Moto: " . $ninja->getInfo() . "\n";
echo "Bike: " . $caloi->getInfo() . "\n";

// ============================================
// PALAVRA-CHAVE 'final'
// ============================================

echo "\n=== MÉTODOS E CLASSES FINAL ===\n";

/**
 * 'final' impede sobrescrita de métodos ou herança de classes
 */

class ContaBancaria
{
    protected float $saldo = 0;

    // Este método NÃO pode ser sobrescrito
    final public function getSaldo(): float
    {
        return $this->saldo;
    }

    public function depositar(float $valor): void
    {
        $this->saldo += $valor;
        echo "Depositado: R$ {$valor}. Saldo: R$ {$this->saldo}\n";
    }
}

class ContaCorrente extends ContaBancaria
{
    private float $limite = 1000;

    // Não podemos sobrescrever getSaldo() pois é final!
    // Isso geraria um erro:
    // public function getSaldo(): float { ... }

    public function sacarComLimite(float $valor): void
    {
        $disponivel = $this->saldo + $this->limite;
        if ($valor <= $disponivel) {
            $this->saldo -= $valor;
            echo "Sacado: R$ {$valor}. Saldo: R$ {$this->saldo}\n";
        } else {
            echo "Saldo insuficiente!\n";
        }
    }
}

$conta = new ContaCorrente();
$conta->depositar(500);
$conta->sacarComLimite(800);
echo "Saldo final: R$ " . $conta->getSaldo() . "\n";

// ============================================
// CLASSE FINAL - NÃO PODE SER HERDADA
// ============================================

final class Singleton
{
    private static ?Singleton $instancia = null;

    private function __construct() {}

    public static function getInstancia(): Singleton
    {
        if (self::$instancia === null) {
            self::$instancia = new Singleton();
        }
        return self::$instancia;
    }
}

// Isso geraria erro - não pode herdar de classe final:
// class MinhaClasse extends Singleton {}

echo "\n✅ Singleton criado com sucesso!\n";
