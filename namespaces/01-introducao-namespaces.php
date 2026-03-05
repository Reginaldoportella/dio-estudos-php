<?php

/**
 * ============================================
 * 1. INTRODUÇÃO A NAMESPACES
 * ============================================
 * 
 * O que são Namespaces?
 * - Mecanismo para organizar e agrupar código
 * - Evita conflitos de nomes entre classes, funções e constantes
 * - Similar a pastas em um sistema de arquivos
 * - Introduzido no PHP 5.3
 * 
 * Por que usar?
 * - Projetos grandes têm muitas classes
 * - Bibliotecas de terceiros podem ter nomes iguais
 * - Organização lógica do código
 * - Padrão da indústria (PSR-4)
 */

echo "╔═══════════════════════════════════════════════════════════════╗\n";
echo "║            INTRODUÇÃO A NAMESPACES EM PHP                      ║\n";
echo "╚═══════════════════════════════════════════════════════════════╝\n\n";

// ============================================
// O PROBLEMA: CONFLITO DE NOMES
// ============================================

echo "1. O PROBLEMA - CONFLITO DE NOMES:\n\n";

$problema = <<<TEXTO
   Imagine dois desenvolvedores criando classes:

   Desenvolvedor A (biblioteca de banco de dados):
   ┌─────────────────────────────────────────┐
   │  class Connection {                     │
   │      public function connect() { ... }  │
   │  }                                      │
   └─────────────────────────────────────────┘

   Desenvolvedor B (biblioteca de rede):
   ┌─────────────────────────────────────────┐
   │  class Connection {                     │
   │      public function connect() { ... }  │
   │  }                                      │
   └─────────────────────────────────────────┘

   ❌ ERRO: "Cannot redeclare class Connection"
   
   Ambos usaram o mesmo nome de classe!
   Como resolver isso?

TEXTO;

echo $problema;

// ============================================
// A SOLUÇÃO: NAMESPACES
// ============================================

echo "\n2. A SOLUÇÃO - NAMESPACES:\n\n";

$solucao = <<<TEXTO
   Com namespaces, cada classe fica em seu "espaço":

   ┌─────────────────────────────────────────┐
   │  namespace Database;                    │
   │                                         │
   │  class Connection {                     │
   │      // Conexão com banco de dados      │
   │  }                                      │
   └─────────────────────────────────────────┘
   Nome completo: Database\Connection

   ┌─────────────────────────────────────────┐
   │  namespace Network;                     │
   │                                         │
   │  class Connection {                     │
   │      // Conexão de rede                 │
   │  }                                      │
   └─────────────────────────────────────────┘
   Nome completo: Network\Connection

   ✅ Agora são classes diferentes!
   
   \$db = new Database\Connection();
   \$net = new Network\Connection();

TEXTO;

echo $solucao;

// ============================================
// ANALOGIA COM SISTEMA DE ARQUIVOS
// ============================================

echo "\n3. ANALOGIA - SISTEMA DE ARQUIVOS:\n\n";

$analogia = <<<TEXTO
   Namespaces funcionam como pastas:

   Sistema de Arquivos:
   ┌─────────────────────────────────────────┐
   │  C:\Projetos\Database\Connection.php    │
   │  C:\Projetos\Network\Connection.php     │
   └─────────────────────────────────────────┘

   Namespaces em PHP:
   ┌─────────────────────────────────────────┐
   │  \Database\Connection                   │
   │  \Network\Connection                    │
   └─────────────────────────────────────────┘

   A barra invertida (\) separa os níveis,
   assim como a barra separa pastas!

TEXTO;

echo $analogia;

// ============================================
// O QUE PODE TER NAMESPACE?
// ============================================

echo "\n4. O QUE PODE TER NAMESPACE?\n\n";

$elementos = <<<TEXTO
   ✅ Classes          → namespace App; class Usuario {}
   ✅ Interfaces       → namespace App; interface Autenticavel {}
   ✅ Traits           → namespace App; trait Logavel {}
   ✅ Funções          → namespace App; function soma() {}
   ✅ Constantes       → namespace App; const VERSAO = '1.0';
   ✅ Enums (PHP 8.1+) → namespace App; enum Status {}

   ❌ Variáveis NÃO podem ter namespace
      (usam escopo local/global normalmente)

TEXTO;

echo $elementos;

// ============================================
// CONVENÇÕES DE NOMENCLATURA
// ============================================

echo "\n5. CONVENÇÕES DE NOMENCLATURA:\n\n";

$convencoes = <<<TEXTO
   Padrão PSR-4 (Recomendado):
   ┌─────────────────────────────────────────────────────┐
   │  • PascalCase para cada nível do namespace          │
   │  • Vendor\Package\Subnamespace\Classe               │
   │  • Namespace espelha estrutura de diretórios        │
   └─────────────────────────────────────────────────────┘

   Exemplos:
   ┌─────────────────────────────────────────────────────┐
   │  App\Models\User              → app/Models/User.php │
   │  App\Controllers\HomeController                     │
   │  Illuminate\Database\Eloquent\Model                 │
   │  Symfony\Component\HttpFoundation\Request           │
   └─────────────────────────────────────────────────────┘

   Dica: O primeiro nível geralmente é o nome do 
   projeto/empresa (vendor name)

TEXTO;

echo $convencoes;

// ============================================
// RESUMO
// ============================================

echo "\n╔═══════════════════════════════════════════════════════════════╗\n";
echo "║                         RESUMO                                 ║\n";
echo "╠═══════════════════════════════════════════════════════════════╣\n";
echo "║  • Namespaces organizam código e evitam conflitos             ║\n";
echo "║  • Funcionam como 'pastas virtuais' para classes              ║\n";
echo "║  • Use barra invertida (\\) como separador                    ║\n";
echo "║  • Siga o padrão PSR-4 para projetos profissionais            ║\n";
echo "║  • Classes, interfaces, traits, funções e constantes          ║\n";
echo "╚═══════════════════════════════════════════════════════════════╝\n";
