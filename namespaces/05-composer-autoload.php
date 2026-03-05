<?php

/**
 * ============================================
 * 5. COMPOSER AUTOLOAD
 * ============================================
 * 
 * Composer é o gerenciador de dependências do PHP
 * - Instala bibliotecas de terceiros
 * - Gera autoloader PSR-4 automaticamente
 * - Padrão da indústria para projetos PHP
 */

echo "╔═══════════════════════════════════════════════════════════════╗\n";
echo "║                  COMPOSER AUTOLOAD                             ║\n";
echo "╚═══════════════════════════════════════════════════════════════╝\n\n";

// ============================================
// O QUE É O COMPOSER?
// ============================================

echo "1. O QUE É O COMPOSER?\n\n";

$composer = <<<TEXTO
   Composer é o gerenciador de dependências do PHP:

   ┌─────────────────────────────────────────────────────┐
   │  ✓ Instala bibliotecas (packages)                   │
   │  ✓ Gerencia versões e dependências                  │
   │  ✓ Gera autoloader automaticamente                  │
   │  ✓ Padrão em projetos profissionais                 │
   │  ✓ Usado por Laravel, Symfony, etc.                 │
   └─────────────────────────────────────────────────────┘

   Site oficial: https://getcomposer.org

   Instalação:
   ┌─────────────────────────────────────────────────────┐
   │  Windows: Baixe o Composer-Setup.exe                │
   │  Linux/Mac: curl -sS https://getcomposer.org/       │
   │             installer | php                         │
   └─────────────────────────────────────────────────────┘

TEXTO;

echo $composer;

// ============================================
// COMPOSER.JSON
// ============================================

echo "\n2. ARQUIVO COMPOSER.JSON:\n\n";

$composerJson = <<<TEXTO
   O composer.json define seu projeto e dependências:

   ┌─────────────────────────────────────────────────────┐
   │  {                                                  │
   │      "name": "meu-usuario/meu-projeto",             │
   │      "description": "Descrição do projeto",         │
   │      "type": "project",                             │
   │      "require": {                                   │
   │          "php": ">=8.0",                            │
   │          "monolog/monolog": "^3.0"                  │
   │      },                                             │
   │      "require-dev": {                               │
   │          "phpunit/phpunit": "^10.0"                 │
   │      },                                             │
   │      "autoload": {                                  │
   │          "psr-4": {                                 │
   │              "App\\\\": "src/"                       │
   │          }                                          │
   │      },                                             │
   │      "autoload-dev": {                              │
   │          "psr-4": {                                 │
   │              "Tests\\\\": "tests/"                   │
   │          }                                          │
   │      }                                              │
   │  }                                                  │
   └─────────────────────────────────────────────────────┘

TEXTO;

echo $composerJson;

// ============================================
// CONFIGURANDO AUTOLOAD
// ============================================

echo "\n3. CONFIGURANDO AUTOLOAD NO COMPOSER:\n\n";

$autoloadConfig = <<<TEXTO
   Seção 'autoload' no composer.json:

   ┌─────────────────────────────────────────────────────┐
   │  "autoload": {                                      │
   │      "psr-4": {                                     │
   │          "App\\\\": "src/",                          │
   │          "Database\\\\": "database/"                 │
   │      },                                             │
   │      "files": [                                     │
   │          "src/helpers.php"                          │
   │      ],                                             │
   │      "classmap": [                                  │
   │          "legacy/"                                  │
   │      ]                                              │
   │  }                                                  │
   └─────────────────────────────────────────────────────┘

   Tipos de autoload:
   ┌─────────────────────────────────────────────────────┐
   │  psr-4     | Padrão recomendado                     │
   │            | Namespace mapeia para diretório        │
   │  ──────────┼────────────────────────────────────────│
   │  psr-0     | Padrão antigo (legado)                 │
   │            | Raramente usado hoje                   │
   │  ──────────┼────────────────────────────────────────│
   │  classmap  | Mapeia diretório inteiro               │
   │            | Útil para código legado                │
   │  ──────────┼────────────────────────────────────────│
   │  files     | Carrega arquivos automaticamente       │
   │            | Útil para funções globais              │
   └─────────────────────────────────────────────────────┘

TEXTO;

echo $autoloadConfig;

// ============================================
// COMANDOS ESSENCIAIS
// ============================================

echo "\n4. COMANDOS ESSENCIAIS DO COMPOSER:\n\n";

$comandos = <<<TEXTO
   ┌─────────────────────────────────────────────────────────────┐
   │  COMANDO                    │  DESCRIÇÃO                    │
   ├─────────────────────────────┼───────────────────────────────┤
   │  composer init              │  Cria composer.json           │
   │                             │  interativamente              │
   ├─────────────────────────────┼───────────────────────────────┤
   │  composer install           │  Instala dependências do      │
   │                             │  composer.json                │
   ├─────────────────────────────┼───────────────────────────────┤
   │  composer require pacote    │  Adiciona nova dependência    │
   │                             │                               │
   ├─────────────────────────────┼───────────────────────────────┤
   │  composer require pacote    │  Adiciona dependência de      │
   │  --dev                      │  desenvolvimento              │
   ├─────────────────────────────┼───────────────────────────────┤
   │  composer update            │  Atualiza dependências        │
   │                             │                               │
   ├─────────────────────────────┼───────────────────────────────┤
   │  composer dump-autoload     │  Regenera autoloader          │
   │                             │  (após mudar composer.json)   │
   └─────────────────────────────────────────────────────────────┘

TEXTO;

echo $comandos;

// ============================================
// USANDO O AUTOLOAD DO COMPOSER
// ============================================

echo "\n5. USANDO O AUTOLOAD DO COMPOSER:\n\n";

$usando = <<<TEXTO
   Após 'composer install', use assim:

   ┌─────────────────────────────────────────────────────┐
   │  <?php                                              │
   │  // IMPORTANTE: primeiro inclua o autoload          │
   │  require __DIR__ . '/vendor/autoload.php';          │
   │                                                     │
   │  // Agora use qualquer classe do projeto            │
   │  use App\Models\Usuario;                            │
   │  use App\Services\EmailService;                     │
   │                                                     │
   │  // E bibliotecas instaladas via Composer           │
   │  use Monolog\Logger;                                │
   │  use Monolog\Handler\StreamHandler;                 │
   │                                                     │
   │  \$usuario = new Usuario("João");                    │
   │  \$logger = new Logger('app');                       │
   └─────────────────────────────────────────────────────┘

   Apenas UMA linha de require e tudo funciona!

TEXTO;

echo $usando;

// ============================================
// ESTRUTURA DE PROJETO
// ============================================

echo "\n6. ESTRUTURA DE PROJETO COM COMPOSER:\n\n";

$estrutura = <<<TEXTO
   Estrutura típica de projeto PHP profissional:

   ┌─────────────────────────────────────────────────────┐
   │  meu-projeto/                                       │
   │  ├── composer.json          # Configuração          │
   │  ├── composer.lock          # Versões travadas      │
   │  ├── vendor/                # NÃO EDITE! Composer   │
   │  │   ├── autoload.php       # Inclua este arquivo   │
   │  │   └── ...                # Dependências          │
   │  │                                                  │
   │  ├── src/                   # Seu código (App\\)    │
   │  │   ├── Models/                                    │
   │  │   │   └── Usuario.php    # App\Models\Usuario   │
   │  │   ├── Services/                                  │
   │  │   └── Controllers/                               │
   │  │                                                  │
   │  ├── tests/                 # Testes (Tests\\)      │
   │  │   └── Models/                                    │
   │  │       └── UsuarioTest.php                        │
   │  │                                                  │
   │  ├── public/                # Arquivos públicos     │
   │  │   └── index.php          # Entry point           │
   │  │                                                  │
   │  └── .gitignore             # Ignorar vendor/       │
   └─────────────────────────────────────────────────────┘

TEXTO;

echo $estrutura;

// ============================================
// EXEMPLO PRÁTICO PASSO A PASSO
// ============================================

echo "\n7. EXEMPLO PRÁTICO - CRIANDO PROJETO:\n\n";

$exemplo = <<<TEXTO
   Passo 1: Criar diretório e iniciar Composer
   ┌─────────────────────────────────────────────────────┐
   │  mkdir meu-projeto                                  │
   │  cd meu-projeto                                     │
   │  composer init                                      │
   └─────────────────────────────────────────────────────┘

   Passo 2: Configurar autoload no composer.json
   ┌─────────────────────────────────────────────────────┐
   │  {                                                  │
   │      "autoload": {                                  │
   │          "psr-4": {                                 │
   │              "App\\\\": "src/"                       │
   │          }                                          │
   │      }                                              │
   │  }                                                  │
   └─────────────────────────────────────────────────────┘

   Passo 3: Criar estrutura de diretórios
   ┌─────────────────────────────────────────────────────┐
   │  mkdir src                                          │
   │  mkdir src/Models                                   │
   └─────────────────────────────────────────────────────┘

   Passo 4: Criar classe src/Models/Usuario.php
   ┌─────────────────────────────────────────────────────┐
   │  <?php                                              │
   │  namespace App\Models;                              │
   │                                                     │
   │  class Usuario {                                    │
   │      public function __construct(                   │
   │          public string \$nome                        │
   │      ) {}                                           │
   │  }                                                  │
   └─────────────────────────────────────────────────────┘

   Passo 5: Gerar autoload
   ┌─────────────────────────────────────────────────────┐
   │  composer dump-autoload                             │
   └─────────────────────────────────────────────────────┘

   Passo 6: Usar no index.php
   ┌─────────────────────────────────────────────────────┐
   │  <?php                                              │
   │  require __DIR__ . '/vendor/autoload.php';          │
   │                                                     │
   │  use App\Models\Usuario;                            │
   │                                                     │
   │  \$user = new Usuario("Maria");                      │
   │  echo \$user->nome;  // Maria                        │
   └─────────────────────────────────────────────────────┘

TEXTO;

echo $exemplo;

// ============================================
// DICAS IMPORTANTES
// ============================================

echo "\n8. DICAS IMPORTANTES:\n\n";

$dicas = <<<TEXTO
   ⚠️  IMPORTANTE:
   ┌─────────────────────────────────────────────────────┐
   │  • NUNCA edite arquivos em vendor/                  │
   │  • SEMPRE commite composer.lock no Git              │
   │  • SEMPRE adicione vendor/ no .gitignore            │
   │  • Execute 'composer install' após clonar projeto   │
   │  • Execute 'composer dump-autoload' após mudar      │
   │    namespaces no composer.json                      │
   └─────────────────────────────────────────────────────┘

   Conteúdo do .gitignore:
   ┌─────────────────────────────────────────────────────┐
   │  /vendor/                                           │
   │  .env                                               │
   └─────────────────────────────────────────────────────┘

TEXTO;

echo $dicas;

// ============================================
// RESUMO
// ============================================

echo "\n╔═══════════════════════════════════════════════════════════════╗\n";
echo "║                         RESUMO                                 ║\n";
echo "╠═══════════════════════════════════════════════════════════════╣\n";
echo "║  • Composer é o gerenciador de dependências padrão            ║\n";
echo "║  • composer.json configura projeto e autoload                 ║\n";
echo "║  • PSR-4: \"App\\\\\": \"src/\" mapeia namespace → diretório      ║\n";
echo "║  • require 'vendor/autoload.php' no início do código          ║\n";
echo "║  • 'composer dump-autoload' regenera o autoloader             ║\n";
echo "║  • Nunca edite vendor/, sempre ignore no .gitignore           ║\n";
echo "╚═══════════════════════════════════════════════════════════════╝\n";
