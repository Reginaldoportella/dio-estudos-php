<?php

/**
 * ============================================
 * 5. ENTENDENDO A HIERARQUIA DAS EXCEÇÕES
 * ============================================
 * 
 * Hierarquia no PHP 7+:
 * 
 * Throwable (interface)
 * ├── Error (erros fatais do PHP)
 * │   ├── ArithmeticError
 * │   │   └── DivisionByZeroError
 * │   ├── AssertionError
 * │   ├── CompileError
 * │   │   └── ParseError
 * │   └── TypeError
 * │       └── ArgumentCountError
 * │
 * └── Exception (exceções do programador)
 *     ├── ErrorException
 *     ├── LogicException
 *     │   ├── BadFunctionCallException
 *     │   │   └── BadMethodCallException
 *     │   ├── DomainException
 *     │   ├── InvalidArgumentException
 *     │   ├── LengthException
 *     │   └── OutOfRangeException
 *     │
 *     └── RuntimeException
 *         ├── OutOfBoundsException
 *         ├── OverflowException
 *         ├── RangeException
 *         ├── UnderflowException
 *         └── UnexpectedValueException
 */

echo "=== HIERARQUIA DAS EXCEÇÕES ===\n\n";

// -------------------------
// 1. Error vs Exception
// -------------------------
echo "1. DIFERENÇA ENTRE ERROR E EXCEPTION:\n\n";

echo "   ERROR:\n";
echo "   - Erros graves do PHP (não devem ser capturados normalmente)\n";
echo "   - Ex: TypeError, ParseError, DivisionByZeroError\n\n";

echo "   EXCEPTION:\n";
echo "   - Exceções lançadas pelo programador\n";
echo "   - Devem ser capturadas e tratadas\n";
echo "   - Ex: InvalidArgumentException, RuntimeException\n\n";

// -------------------------
// 2. Tipos de Exception
// -------------------------
echo "2. TIPOS COMUNS DE EXCEPTION:\n\n";

// InvalidArgumentException - Argumento inválido
function setIdade($idade) {
    if (!is_int($idade)) {
        throw new InvalidArgumentException("Idade deve ser um número inteiro!");
    }
    if ($idade < 0 || $idade > 150) {
        throw new RangeException("Idade deve estar entre 0 e 150!");
    }
    return $idade;
}

// RuntimeException - Erro em tempo de execução
function conectarBanco($host) {
    // Simulando falha de conexão
    throw new RuntimeException("Não foi possível conectar ao banco: $host");
}

// Testando InvalidArgumentException
echo "   a) InvalidArgumentException:\n";
try {
    setIdade("vinte");
} catch (InvalidArgumentException $e) {
    echo "      Erro: " . $e->getMessage() . "\n";
}

// Testando RangeException
echo "\n   b) RangeException:\n";
try {
    setIdade(200);
} catch (RangeException $e) {
    echo "      Erro: " . $e->getMessage() . "\n";
}

// Testando RuntimeException
echo "\n   c) RuntimeException:\n";
try {
    conectarBanco("localhost");
} catch (RuntimeException $e) {
    echo "      Erro: " . $e->getMessage() . "\n";
}

// -------------------------
// 3. Capturando múltiplos tipos
// -------------------------
echo "\n\n3. CAPTURANDO MÚLTIPLOS TIPOS DE EXCEÇÃO:\n\n";

function processarValor($valor) {
    if (!is_numeric($valor)) {
        throw new InvalidArgumentException("Valor deve ser numérico!");
    }
    if ($valor < 0) {
        throw new RangeException("Valor não pode ser negativo!");
    }
    if ($valor == 0) {
        throw new RuntimeException("Valor não pode ser zero!");
    }
    return $valor * 2;
}

$testes = ["abc", -5, 0, 10];

foreach ($testes as $teste) {
    echo "   Testando valor '$teste': ";
    try {
        $resultado = processarValor($teste);
        echo "Resultado = $resultado\n";
    } catch (InvalidArgumentException $e) {
        echo "[InvalidArgument] " . $e->getMessage() . "\n";
    } catch (RangeException $e) {
        echo "[Range] " . $e->getMessage() . "\n";
    } catch (RuntimeException $e) {
        echo "[Runtime] " . $e->getMessage() . "\n";
    }
}

// -------------------------
// 4. Usando Throwable
// -------------------------
echo "\n\n4. USANDO THROWABLE (CAPTURA TUDO):\n\n";

function dividirNumeros($a, $b) {
    return intdiv($a, $b);  // Pode gerar DivisionByZeroError
}

try {
    echo "   10 / 2 = " . dividirNumeros(10, 2) . "\n";
    echo "   10 / 0 = " . dividirNumeros(10, 0) . "\n";
} catch (Throwable $t) {
    // Throwable captura tanto Error quanto Exception
    echo "   Erro capturado: " . $t->getMessage() . "\n";
    echo "   Tipo: " . get_class($t) . "\n";
}

// -------------------------
// 5. Criando exceções customizadas
// -------------------------
echo "\n\n5. CRIANDO EXCEÇÕES CUSTOMIZADAS:\n\n";

// Exceção personalizada para validação
class ValidacaoException extends Exception {
    private $campo;
    
    public function __construct($campo, $mensagem, $code = 0) {
        $this->campo = $campo;
        parent::__construct($mensagem, $code);
    }
    
    public function getCampo() {
        return $this->campo;
    }
}

// Exceção personalizada para autenticação
class AutenticacaoException extends Exception {
    public function __construct($mensagem = "Falha na autenticação") {
        parent::__construct($mensagem, 401);
    }
}

// Usando exceções customizadas
function validarUsuario($dados) {
    if (empty($dados['email'])) {
        throw new ValidacaoException('email', 'O email é obrigatório!');
    }
    if (empty($dados['senha'])) {
        throw new ValidacaoException('senha', 'A senha é obrigatória!');
    }
    if ($dados['senha'] !== '123456') {
        throw new AutenticacaoException('Senha incorreta!');
    }
    return true;
}

$usuarios = [
    ['email' => '', 'senha' => '123'],
    ['email' => 'teste@email.com', 'senha' => ''],
    ['email' => 'teste@email.com', 'senha' => 'errada'],
    ['email' => 'teste@email.com', 'senha' => '123456'],
];

foreach ($usuarios as $i => $usuario) {
    echo "   Teste " . ($i + 1) . ": ";
    try {
        validarUsuario($usuario);
        echo "OK - Usuário válido!\n";
    } catch (ValidacaoException $e) {
        echo "Validação falhou no campo '{$e->getCampo()}': {$e->getMessage()}\n";
    } catch (AutenticacaoException $e) {
        echo "Autenticação falhou: {$e->getMessage()}\n";
    }
}
