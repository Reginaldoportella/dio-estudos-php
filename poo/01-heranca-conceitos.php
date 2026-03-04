<?php

/**
 * ==========================================================
 * HERANÇA EM PHP - CONCEITOS FUNDAMENTAIS
 * ==========================================================
 * 
 * Herança é um dos pilares da POO que permite criar novas classes
 * baseadas em classes existentes, herdando seus atributos e métodos.
 * 
 * Benefícios:
 * - Reutilização de código
 * - Organização hierárquica
 * - Facilidade de manutenção
 */

// ============================================
// CLASSE PAI (SUPERCLASSE OU CLASSE BASE)
// ============================================

class Animal
{
    // Atributos protegidos - acessíveis nas classes filhas
    protected string $nome;
    protected int $idade;
    protected string $cor;

    public function __construct(string $nome, int $idade, string $cor)
    {
        $this->nome = $nome;
        $this->idade = $idade;
        $this->cor = $cor;
    }

    // Métodos que serão herdados
    public function comer(): void
    {
        echo "{$this->nome} está comendo.\n";
    }

    public function dormir(): void
    {
        echo "{$this->nome} está dormindo.\n";
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getIdade(): int
    {
        return $this->idade;
    }

    // Método que pode ser sobrescrito (override)
    public function emitirSom(): void
    {
        echo "{$this->nome} está emitindo um som.\n";
    }
}

// ============================================
// CLASSES FILHAS (SUBCLASSES)
// ============================================

// Usando 'extends' para herdar de Animal
class Cachorro extends Animal
{
    private string $raca;

    public function __construct(string $nome, int $idade, string $cor, string $raca)
    {
        // Chamando o construtor da classe pai
        parent::__construct($nome, $idade, $cor);
        $this->raca = $raca;
    }

    // Método exclusivo da classe Cachorro
    public function buscarBola(): void
    {
        echo "{$this->nome} está buscando a bola!\n";
    }

    public function getRaca(): string
    {
        return $this->raca;
    }
}

class Gato extends Animal
{
    private bool $domestico;

    public function __construct(string $nome, int $idade, string $cor, bool $domestico = true)
    {
        parent::__construct($nome, $idade, $cor);
        $this->domestico = $domestico;
    }

    // Método exclusivo da classe Gato
    public function arranhar(): void
    {
        echo "{$this->nome} está arranhando o sofá!\n";
    }

    public function isDomestico(): bool
    {
        return $this->domestico;
    }
}

// ============================================
// EXEMPLOS DE USO
// ============================================

echo "=== DEMONSTRAÇÃO DE HERANÇA ===\n\n";

// Criando objetos das classes filhas
$rex = new Cachorro("Rex", 3, "marrom", "Pastor Alemão");
$mimi = new Gato("Mimi", 2, "branca", true);

// Usando métodos herdados da classe Animal
echo "--- Métodos Herdados ---\n";
$rex->comer();      // Método herdado
$rex->dormir();     // Método herdado
$mimi->comer();     // Método herdado
$mimi->dormir();    // Método herdado

echo "\n--- Métodos Específicos ---\n";
// Usando métodos específicos de cada classe
$rex->buscarBola(); // Método exclusivo de Cachorro
$mimi->arranhar();  // Método exclusivo de Gato

echo "\n--- Informações dos Animais ---\n";
echo "Cachorro: {$rex->getNome()}, {$rex->getIdade()} anos, Raça: {$rex->getRaca()}\n";
echo "Gato: {$mimi->getNome()}, {$mimi->getIdade()} anos, Doméstico: " . ($mimi->isDomestico() ? "Sim" : "Não") . "\n";

// ============================================
// VERIFICANDO INSTÂNCIAS
// ============================================

echo "\n--- Verificação de Instâncias ---\n";

// instanceof verifica se um objeto é instância de uma classe
var_dump($rex instanceof Cachorro);  // true
var_dump($rex instanceof Animal);    // true - também é Animal!
var_dump($mimi instanceof Cachorro); // false

echo "\nRex é um Cachorro? " . ($rex instanceof Cachorro ? "Sim" : "Não") . "\n";
echo "Rex é um Animal? " . ($rex instanceof Animal ? "Sim" : "Não") . "\n";
echo "Mimi é um Cachorro? " . ($mimi instanceof Cachorro ? "Sim" : "Não") . "\n";
