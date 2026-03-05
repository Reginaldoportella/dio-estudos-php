<?php

/**
 * ============================================
 * 4. AUTOLOAD MANUAL
 * ============================================
 * 
 * O que é Autoload?
 * - Carregamento automático de classes
 * - Evita múltiplos require/include manuais
 * - Quando você usa 'new Classe()', PHP carrega automaticamente
 * 
 * Como funciona?
 * - PHP chama uma função quando uma classe não é encontrada
 * - Essa função localiza e carrega o arquivo da classe
 */

echo "╔═══════════════════════════════════════════════════════════════╗\n";
echo "║                    AUTOLOAD MANUAL EM PHP                      ║\n";
echo "╚═══════════════════════════════════════════════════════════════╝\n\n";

// ============================================
// O PROBLEMA: MUITOS REQUIRES
// ============================================

echo "1. O PROBLEMA - MUITOS REQUIRES:\n\n";

$problema = <<<TEXTO
   Sem autoload, você precisa incluir cada arquivo manualmente:

   ┌─────────────────────────────────────────────────────┐
   │  <?php                                              │
   │  require 'src/Models/Usuario.php';                  │
   │  require 'src/Models/Produto.php';                  │
   │  require 'src/Models/Pedido.php';                   │
   │  require 'src/Models/Categoria.php';                │
   │  require 'src/Services/EmailService.php';           │
   │  require 'src/Services/PagamentoService.php';       │
   │  require 'src/Controllers/UsuarioController.php';   │
   │  require 'src/Controllers/ProdutoController.php';   │
   │  // ... mais 50 requires ...                        │
   │                                                     │
   │  \$usuario = new Usuario();                          │
   └─────────────────────────────────────────────────────┘

   ❌ Problemas:
   • Manutenção difícil
   • Fácil esquecer um require
   • Carrega tudo mesmo sem usar
   • Ordem dos requires importa

TEXTO;

echo $problema;

// ============================================
// A SOLUÇÃO: AUTOLOAD
// ============================================

echo "\n2. A SOLUÇÃO - AUTOLOAD:\n\n";

$solucao = <<<TEXTO
   Com autoload, PHP carrega automaticamente:

   ┌─────────────────────────────────────────────────────┐
   │  <?php                                              │
   │  // Registra a função de autoload                   │
   │  spl_autoload_register(function(\$classe) {         │
   │      // Converte namespace em caminho de arquivo    │
   │      \$arquivo = str_replace('\\\\', '/', \$classe);  │
   │      require "src/{\$arquivo}.php";                  │
   │  });                                                │
   │                                                     │
   │  // Agora use qualquer classe!                      │
   │  \$usuario = new App\Models\Usuario();               │
   │  // PHP automaticamente carrega:                    │
   │  // src/App/Models/Usuario.php                      │
   └─────────────────────────────────────────────────────┘

   ✅ Benefícios:
   • Carrega apenas quando necessário
   • Sem requires manuais
   • Manutenção simples
   • Código mais limpo

TEXTO;

echo $solucao;

// ============================================
// SPL_AUTOLOAD_REGISTER
// ============================================

echo "\n3. SPL_AUTOLOAD_REGISTER:\n\n";

$spl = <<<TEXTO
   spl_autoload_register() registra função(ões) de autoload:

   Sintaxe:
   ┌─────────────────────────────────────────────────────┐
   │  spl_autoload_register(callable \$callback);         │
   └─────────────────────────────────────────────────────┘

   Formas de usar:
   ┌─────────────────────────────────────────────────────┐
   │  // 1. Função anônima (mais comum)                  │
   │  spl_autoload_register(function(\$classe) {         │
   │      // lógica de carregamento                      │
   │  });                                                │
   │                                                     │
   │  // 2. Função nomeada                               │
   │  function meuAutoload(\$classe) {                   │
   │      // lógica de carregamento                      │
   │  }                                                  │
   │  spl_autoload_register('meuAutoload');              │
   │                                                     │
   │  // 3. Método de classe                             │
   │  class Autoloader {                                 │
   │      public static function carregar(\$classe) {}   │
   │  }                                                  │
   │  spl_autoload_register([Autoloader::class,          │
   │      'carregar']);                                  │
   └─────────────────────────────────────────────────────┘

TEXTO;

echo $spl;

// ============================================
// EXEMPLO PRÁTICO DE AUTOLOAD
// ============================================

echo "\n4. EXEMPLO PRÁTICO DE AUTOLOAD:\n\n";

// Definindo um autoloader simples para demonstração
spl_autoload_register(function($classe) {
    // Log para demonstração
    echo "   🔄 Autoload chamado para: {$classe}\n";
    
    // Converte namespace em caminho
    // App\Models\Usuario → App/Models/Usuario
    $caminho = str_replace('\\', '/', $classe);
    
    // Monta caminho completo
    $arquivo = __DIR__ . "/demo/{$caminho}.php";
    
    echo "   📁 Procurando: {$arquivo}\n";
    
    // Verifica se arquivo existe
    if (file_exists($arquivo)) {
        require $arquivo;
        echo "   ✅ Arquivo carregado!\n\n";
        return true;
    }
    
    echo "   ⚠️  Arquivo não encontrado (demo)\n\n";
    return false;
});

// Simulação de uso (arquivos não existem, apenas demonstração)
echo "   Tentando: new Demo\\Models\\Usuario()\n";
// Descomentar para testar: $user = new Demo\Models\Usuario();

// ============================================
// IMPLEMENTAÇÃO PADRÃO PSR-4
// ============================================

echo "\n5. IMPLEMENTAÇÃO PADRÃO PSR-4:\n\n";

$psr4 = <<<TEXTO
   PSR-4 é o padrão da indústria para autoload:

   ┌─────────────────────────────────────────────────────┐
   │  Regras do PSR-4:                                   │
   │  • Namespace raiz mapeia para diretório base        │
   │  • Subnamespaces = subdiretórios                    │
   │  • Nome da classe = nome do arquivo                 │
   │  • Arquivos terminam em .php                        │
   └─────────────────────────────────────────────────────┘

   Exemplo de mapeamento:
   ┌─────────────────────────────────────────────────────┐
   │  Namespace          │  Diretório Base              │
   │  ───────────────────┼──────────────────────────────│
   │  App\\               │  src/                        │
   │  Tests\\             │  tests/                      │
   └─────────────────────────────────────────────────────┘

   Classe: App\Models\Usuario
   Arquivo: src/Models/Usuario.php

TEXTO;

echo $psr4;

// ============================================
// AUTOLOADER PSR-4 COMPLETO
// ============================================

echo "\n6. AUTOLOADER PSR-4 COMPLETO:\n\n";

$autoloaderCode = <<<'CODE'
<?php
/**
 * Autoloader PSR-4 simples
 */
class Autoloader
{
    /** @var array Mapeamento namespace => diretório */
    private array $prefixos = [];

    /**
     * Adiciona namespace ao autoloader
     */
    public function addNamespace(string $prefix, string $baseDir): void
    {
        // Normaliza o prefixo do namespace
        $prefix = trim($prefix, '\\') . '\\';
        
        // Normaliza o diretório base
        $baseDir = rtrim($baseDir, DIRECTORY_SEPARATOR) . '/';
        
        // Armazena o mapeamento
        $this->prefixos[$prefix] = $baseDir;
    }

    /**
     * Carrega a classe
     */
    public function carregarClasse(string $classe): bool
    {
        // Percorre os prefixos registrados
        foreach ($this->prefixos as $prefix => $baseDir) {
            // Verifica se a classe usa este namespace
            if (strncmp($prefix, $classe, strlen($prefix)) === 0) {
                // Remove o prefixo do namespace
                $classeRelativa = substr($classe, strlen($prefix));
                
                // Monta o caminho do arquivo
                $arquivo = $baseDir 
                    . str_replace('\\', '/', $classeRelativa) 
                    . '.php';
                
                // Carrega se existir
                if (file_exists($arquivo)) {
                    require $arquivo;
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Registra o autoloader
     */
    public function registrar(): void
    {
        spl_autoload_register([$this, 'carregarClasse']);
    }
}

// USO:
$loader = new Autoloader();
$loader->addNamespace('App\\', __DIR__ . '/src');
$loader->addNamespace('Tests\\', __DIR__ . '/tests');
$loader->registrar();

// Agora use qualquer classe!
$usuario = new App\Models\Usuario();
CODE;

echo "   " . str_replace("\n", "\n   ", $autoloaderCode) . "\n";

// ============================================
// MÚLTIPLOS AUTOLOADERS
// ============================================

echo "\n\n7. MÚLTIPLOS AUTOLOADERS:\n\n";

$multiplos = <<<TEXTO
   PHP permite registrar vários autoloaders em cadeia:

   ┌─────────────────────────────────────────────────────┐
   │  // Autoloader do seu projeto                       │
   │  spl_autoload_register(function(\$c) {              │
   │      // tenta carregar de src/                      │
   │  });                                                │
   │                                                     │
   │  // Autoloader de biblioteca externa                │
   │  spl_autoload_register(function(\$c) {              │
   │      // tenta carregar de vendor/                   │
   │  });                                                │
   │                                                     │
   │  // PHP tenta cada um até encontrar a classe        │
   └─────────────────────────────────────────────────────┘

   O Composer faz exatamente isso - gerencia múltiplos
   autoloaders de diferentes bibliotecas!

TEXTO;

echo $multiplos;

// ============================================
// RESUMO
// ============================================

echo "\n╔═══════════════════════════════════════════════════════════════╗\n";
echo "║                         RESUMO                                 ║\n";
echo "╠═══════════════════════════════════════════════════════════════╣\n";
echo "║  • Autoload carrega classes automaticamente                   ║\n";
echo "║  • spl_autoload_register() registra função de autoload        ║\n";
echo "║  • PSR-4: namespace mapeia para estrutura de diretórios       ║\n";
echo "║  • Converta \\ em / para encontrar o arquivo                   ║\n";
echo "║  • Múltiplos autoloaders podem coexistir                      ║\n";
echo "║  • Na prática, use o autoloader do Composer!                  ║\n";
echo "╚═══════════════════════════════════════════════════════════════╝\n";
