<?php

/**
 * ============================================
 * 2. DECLARANDO NAMESPACES
 * ============================================
 * 
 * Como declarar namespaces em PHP:
 * - Usar a palavra-chave 'namespace'
 * - Deve ser a PRIMEIRA instrução do arquivo
 * - Apenas comentários e declare() podem vir antes
 */

// Obs: Para fins didáticos, este arquivo mostra exemplos
// Na prática, cada classe ficaria em seu próprio arquivo

echo "╔═══════════════════════════════════════════════════════════════╗\n";
echo "║              DECLARANDO NAMESPACES EM PHP                      ║\n";
echo "╚═══════════════════════════════════════════════════════════════╝\n\n";

// ============================================
// SINTAXE BÁSICA
// ============================================

echo "1. SINTAXE BÁSICA:\n\n";

$sintaxe = <<<TEXTO
   Declaração simples:
   ┌─────────────────────────────────────────┐
   │  <?php                                  │
   │  namespace MeuProjeto;                  │
   │                                         │
   │  class MinhaClasse {                    │
   │      // código                          │
   │  }                                      │
   └─────────────────────────────────────────┘

   Com subnamespaces (níveis):
   ┌─────────────────────────────────────────┐
   │  <?php                                  │
   │  namespace MeuProjeto\Models\Database;  │
   │                                         │
   │  class Connection {                     │
   │      // código                          │
   │  }                                      │
   └─────────────────────────────────────────┘

   IMPORTANTE: 'namespace' deve ser a PRIMEIRA linha!
   (exceto comentários e declare)

TEXTO;

echo $sintaxe;

// ============================================
// REGRAS IMPORTANTES
// ============================================

echo "\n2. REGRAS IMPORTANTES:\n\n";

$regras = <<<TEXTO
   ❌ ERRADO - Código antes do namespace:
   ┌─────────────────────────────────────────┐
   │  <?php                                  │
   │  echo "Olá";  // ← ERRO!               │
   │  namespace App;                         │
   │  class User {}                          │
   └─────────────────────────────────────────┘
   Fatal error: Namespace declaration statement 
   has to be the very first statement

   ✅ CORRETO - Comentários são permitidos:
   ┌─────────────────────────────────────────┐
   │  <?php                                  │
   │  /**                                    │
   │   * Classe de usuário                   │
   │   */                                    │
   │  namespace App;                         │
   │                                         │
   │  class User {}                          │
   └─────────────────────────────────────────┘

   ✅ CORRETO - declare() é permitido:
   ┌─────────────────────────────────────────┐
   │  <?php                                  │
   │  declare(strict_types=1);               │
   │  namespace App;                         │
   │                                         │
   │  class User {}                          │
   └─────────────────────────────────────────┘

TEXTO;

echo $regras;

// ============================================
// DEMONSTRAÇÃO PRÁTICA
// ============================================

echo "\n3. DEMONSTRAÇÃO PRÁTICA:\n\n";

// Namespace global (raiz)
namespace {
    echo "   Estamos no namespace GLOBAL (raiz)\n";
    echo "   Qualquer código fora de namespace fica aqui\n\n";
}

// Definindo um namespace
namespace App\Models {
    
    class Usuario {
        public string $nome;
        
        public function __construct(string $nome) {
            $this->nome = $nome;
        }
        
        public function saudacao(): string {
            return "Olá, eu sou {$this->nome}!";
        }
    }
    
    echo "   Dentro do namespace App\\Models:\n";
    echo "   - Classe Usuario definida\n";
    echo "   - Nome completo: App\\Models\\Usuario\n\n";
}

// Outro namespace no mesmo arquivo (possível mas não recomendado)
namespace App\Services {
    
    class UsuarioService {
        public function criar(string $nome): \App\Models\Usuario {
            // Usando o caminho completo (fully qualified)
            return new \App\Models\Usuario($nome);
        }
    }
    
    echo "   Dentro do namespace App\\Services:\n";
    echo "   - Classe UsuarioService definida\n";
    echo "   - Para usar Usuario, precisa do caminho completo\n\n";
}

// Voltando ao namespace global para testar
namespace {
    
    echo "4. TESTANDO AS CLASSES:\n\n";
    
    // Usando nome completo (Fully Qualified Name - FQN)
    $usuario = new \App\Models\Usuario("João");
    echo "   " . $usuario->saudacao() . "\n\n";
    
    $service = new \App\Services\UsuarioService();
    $outroUsuario = $service->criar("Maria");
    echo "   " . $outroUsuario->saudacao() . "\n\n";
    
    // Verificando o nome completo da classe
    echo "   Nome da classe: " . get_class($usuario) . "\n";
    echo "   Nome da classe: " . get_class($outroUsuario) . "\n";
}

// ============================================
// SINTAXE COM CHAVES (ALTERNATIVA)
// ============================================

namespace {

echo "\n5. SINTAXE COM CHAVES (ALTERNATIVA):\n\n";

$chaves = <<<TEXTO
   Você pode usar chaves para delimitar o namespace:
   ┌─────────────────────────────────────────┐
   │  <?php                                  │
   │  namespace App\Models {                 │
   │      class User { }                     │
   │  }                                      │
   │                                         │
   │  namespace App\Services {               │
   │      class UserService { }              │
   │  }                                      │
   └─────────────────────────────────────────┘

   ⚠️  Não misture sintaxes no mesmo arquivo!
   Use OU simples (sem chaves) OU com chaves.

TEXTO;

echo $chaves;

// ============================================
// BOAS PRÁTICAS
// ============================================

echo "\n6. BOAS PRÁTICAS:\n\n";

$praticas = <<<TEXTO
   ✅ RECOMENDADO:
   ┌─────────────────────────────────────────────────────┐
   │  • UMA classe por arquivo                           │
   │  • UM namespace por arquivo                         │
   │  • Nome do arquivo = Nome da classe                 │
   │  • Estrutura de pastas espelha namespace            │
   └─────────────────────────────────────────────────────┘

   Exemplo de estrutura:
   ┌─────────────────────────────────────────────────────┐
   │  src/                                               │
   │  ├── Models/                                        │
   │  │   └── Usuario.php    → App\Models\Usuario       │
   │  ├── Services/                                      │
   │  │   └── UsuarioService.php                         │
   │  └── Controllers/                                   │
   │      └── UsuarioController.php                      │
   └─────────────────────────────────────────────────────┘

TEXTO;

echo $praticas;

// ============================================
// RESUMO
// ============================================

echo "\n╔═══════════════════════════════════════════════════════════════╗\n";
echo "║                         RESUMO                                 ║\n";
echo "╠═══════════════════════════════════════════════════════════════╣\n";
echo "║  • Use 'namespace NomeDoProjeto;' no início do arquivo        ║\n";
echo "║  • Subnamespaces: namespace App\\Models\\Database;              ║\n";
echo "║  • Namespace DEVE ser a primeira instrução                    ║\n";
echo "║  • Apenas comentários e declare() podem vir antes             ║\n";
echo "║  • Prefira: 1 classe = 1 arquivo = 1 namespace                ║\n";
echo "╚═══════════════════════════════════════════════════════════════╝\n";

}
