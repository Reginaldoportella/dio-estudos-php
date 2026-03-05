<?php

/**
 * ============================================
 * 3. USE E ALIAS
 * ============================================
 * 
 * A palavra-chave 'use':
 * - Importa classes de outros namespaces
 * - Evita escrever o caminho completo toda vez
 * - Permite criar aliases (apelidos) para classes
 * - Torna o código mais limpo e legível
 */

echo "╔═══════════════════════════════════════════════════════════════╗\n";
echo "║                   USE E ALIAS EM PHP                           ║\n";
echo "╚═══════════════════════════════════════════════════════════════╝\n\n";

// ============================================
// DEFININDO CLASSES EM DIFERENTES NAMESPACES
// ============================================

namespace App\Models {
    
    class Usuario {
        public string $nome;
        public string $email;
        
        public function __construct(string $nome, string $email) {
            $this->nome = $nome;
            $this->email = $email;
        }
    }
    
    class Produto {
        public string $nome;
        public float $preco;
        
        public function __construct(string $nome, float $preco) {
            $this->nome = $nome;
            $this->preco = $preco;
        }
    }
}

namespace Vendor\OutraBiblioteca\Models {
    
    // Outra classe Usuario de biblioteca externa
    class Usuario {
        public int $id;
        public string $username;
        
        public function __construct(int $id, string $username) {
            $this->id = $id;
            $this->username = $username;
        }
    }
}

namespace App\Services {
    
    class EmailService {
        public function enviar(string $para, string $assunto): void {
            echo "   📧 Enviando email para: {$para}\n";
            echo "      Assunto: {$assunto}\n";
        }
    }
}

// ============================================
// DEMONSTRANDO O USE
// ============================================

namespace App\Controllers {
    
    // Importando classes com USE
    use App\Models\Usuario;
    use App\Models\Produto;
    use App\Services\EmailService;
    
    // Importando com ALIAS (apelido)
    use Vendor\OutraBiblioteca\Models\Usuario as UsuarioExterno;
    
    echo "1. SEM USE vs COM USE:\n\n";
    
    $semUse = <<<TEXTO
   SEM use (caminho completo sempre):
   ┌─────────────────────────────────────────────────────┐
   │  \$user = new \App\Models\Usuario("João", "j@e.com");│
   │  \$prod = new \App\Models\Produto("Mouse", 99.90);  │
   │  \$email = new \App\Services\EmailService();        │
   └─────────────────────────────────────────────────────┘

   COM use (importação no topo):
   ┌─────────────────────────────────────────────────────┐
   │  use App\Models\Usuario;                            │
   │  use App\Models\Produto;                            │
   │  use App\Services\EmailService;                     │
   │                                                     │
   │  \$user = new Usuario("João", "j@e.com");           │
   │  \$prod = new Produto("Mouse", 99.90);              │
   │  \$email = new EmailService();                      │
   └─────────────────────────────────────────────────────┘

   Muito mais limpo! ✨

TEXTO;
    
    echo $semUse;
    
    // Exemplo prático
    echo "\n2. EXEMPLO PRÁTICO:\n\n";
    
    $usuario = new Usuario("Maria", "maria@email.com");
    $produto = new Produto("Teclado", 299.90);
    $emailService = new EmailService();
    
    echo "   Usuário criado: {$usuario->nome} ({$usuario->email})\n";
    echo "   Produto criado: {$produto->nome} - R$ " . number_format($produto->preco, 2, ',', '.') . "\n\n";
    
    $emailService->enviar($usuario->email, "Bem-vindo!");
    
    // ============================================
    // ALIAS - RESOLVENDO CONFLITOS
    // ============================================
    
    echo "\n3. ALIAS - RESOLVENDO CONFLITOS:\n\n";
    
    $alias = <<<TEXTO
   Quando duas classes têm o mesmo nome:
   ┌─────────────────────────────────────────────────────┐
   │  use App\Models\Usuario;                            │
   │  use Vendor\OutraBiblioteca\Models\Usuario;         │
   │                                                     │
   │  // ❌ ERRO: Qual Usuario usar?                     │
   └─────────────────────────────────────────────────────┘

   Solução: usar alias (apelido)
   ┌─────────────────────────────────────────────────────┐
   │  use App\Models\Usuario;                            │
   │  use Vendor\OutraBiblioteca\Models\Usuario          │
   │      as UsuarioExterno;                             │
   │                                                     │
   │  \$meuUser = new Usuario(...);                      │
   │  \$outroUser = new UsuarioExterno(...);             │
   │                                                     │
   │  // ✅ Sem conflito!                                │
   └─────────────────────────────────────────────────────┘

TEXTO;
    
    echo $alias;
    
    // Demonstração
    $meuUsuario = new Usuario("Pedro", "pedro@email.com");
    $usuarioExterno = new UsuarioExterno(123, "pedro_ext");
    
    echo "   Meu Usuario: {$meuUsuario->nome}\n";
    echo "   Usuario Externo: ID {$usuarioExterno->id}, Username: {$usuarioExterno->username}\n";
}

// ============================================
// IMPORTAÇÃO AGRUPADA
// ============================================

namespace App\Demo {
    
    echo "\n4. IMPORTAÇÃO AGRUPADA (PHP 7+):\n\n";
    
    $agrupada = <<<TEXTO
   Importar várias classes do mesmo namespace:
   
   Forma tradicional:
   ┌─────────────────────────────────────────────────────┐
   │  use App\Models\Usuario;                            │
   │  use App\Models\Produto;                            │
   │  use App\Models\Pedido;                             │
   │  use App\Models\Categoria;                          │
   └─────────────────────────────────────────────────────┘

   Forma agrupada (PHP 7+):
   ┌─────────────────────────────────────────────────────┐
   │  use App\Models\{                                   │
   │      Usuario,                                       │
   │      Produto,                                       │
   │      Pedido,                                        │
   │      Categoria                                      │
   │  };                                                 │
   └─────────────────────────────────────────────────────┘

   Também funciona com alias:
   ┌─────────────────────────────────────────────────────┐
   │  use App\Models\{                                   │
   │      Usuario as User,                               │
   │      Produto as Product                             │
   │  };                                                 │
   └─────────────────────────────────────────────────────┘

TEXTO;
    
    echo $agrupada;
    
    // ============================================
    // USE PARA FUNÇÕES E CONSTANTES
    // ============================================
    
    echo "\n5. USE PARA FUNÇÕES E CONSTANTES:\n\n";
    
    $funcConst = <<<TEXTO
   Também é possível importar funções e constantes:
   
   ┌─────────────────────────────────────────────────────┐
   │  // Importar função                                 │
   │  use function App\Helpers\formatar_data;            │
   │                                                     │
   │  // Importar constante                              │
   │  use const App\Config\VERSAO;                       │
   │                                                     │
   │  // Importação agrupada mista                       │
   │  use App\{                                          │
   │      Models\Usuario,                                │
   │      function Helpers\formatar_data,                │
   │      const Config\VERSAO                            │
   │  };                                                 │
   └─────────────────────────────────────────────────────┘

TEXTO;
    
    echo $funcConst;
    
    // ============================================
    // TIPOS DE REFERÊNCIA
    // ============================================
    
    echo "\n6. TIPOS DE REFERÊNCIA:\n\n";
    
    $referencias = <<<TEXTO
   ┌─────────────────────────────────────────────────────────────┐
   │  TIPO                │  EXEMPLO              │  DESCRIÇÃO   │
   ├─────────────────────────────────────────────────────────────┤
   │  Fully Qualified     │  \App\Models\Usuario  │  Caminho     │
   │  (Completo)          │                       │  absoluto    │
   ├─────────────────────────────────────────────────────────────┤
   │  Qualified           │  Models\Usuario       │  Relativo ao │
   │  (Qualificado)       │                       │  namespace   │
   │                      │                       │  atual       │
   ├─────────────────────────────────────────────────────────────┤
   │  Unqualified         │  Usuario              │  Apenas o    │
   │  (Não qualificado)   │                       │  nome        │
   └─────────────────────────────────────────────────────────────┘

   Exemplo no namespace App\Controllers:
   ┌─────────────────────────────────────────────────────┐
   │  // Fully Qualified - sempre funciona              │
   │  \$u = new \App\Models\Usuario();                   │
   │                                                     │
   │  // Qualified - relativo ao atual                  │
   │  // Procura: App\Controllers\Models\Usuario        │
   │  \$u = new Models\Usuario();  // ❌ se não existir │
   │                                                     │
   │  // Unqualified - precisa de use                   │
   │  use App\Models\Usuario;                            │
   │  \$u = new Usuario();  // ✅                        │
   └─────────────────────────────────────────────────────┘

TEXTO;
    
    echo $referencias;
    
    // ============================================
    // RESUMO
    // ============================================
    
    echo "\n╔═══════════════════════════════════════════════════════════════╗\n";
    echo "║                         RESUMO                                 ║\n";
    echo "╠═══════════════════════════════════════════════════════════════╣\n";
    echo "║  • 'use' importa classes para usar sem caminho completo       ║\n";
    echo "║  • 'as' cria alias para resolver conflitos de nomes           ║\n";
    echo "║  • Agrupamento: use Namespace\\{Classe1, Classe2};             ║\n";
    echo "║  • 'use function' e 'use const' para funções/constantes       ║\n";
    echo "║  • Barra inicial (\\) indica caminho absoluto                  ║\n";
    echo "╚═══════════════════════════════════════════════════════════════╝\n";
}
