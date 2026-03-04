<?php

/**
 * ============================================
 * 6. TRATAMENTO DE EXCEÇÕES
 * ============================================
 * 
 * Boas práticas para tratamento de exceções:
 * - Capture exceções específicas, não genéricas
 * - Não silencie exceções sem motivo
 * - Use finally para limpeza de recursos
 * - Crie exceções customizadas quando necessário
 * - Registre exceções em log
 */

echo "=== TRATAMENTO DE EXCEÇÕES ===\n\n";

// -------------------------
// 1. Try-Catch básico
// -------------------------
echo "1. TRY-CATCH BÁSICO:\n\n";

function dividir($a, $b) {
    if ($b === 0) {
        throw new Exception("Divisão por zero!");
    }
    return $a / $b;
}

try {
    echo "   10 / 2 = " . dividir(10, 2) . "\n";
    echo "   10 / 0 = " . dividir(10, 0) . "\n";  // Gera exceção
    echo "   Esta linha não será executada\n";
} catch (Exception $e) {
    echo "   ERRO: " . $e->getMessage() . "\n";
}

// -------------------------
// 2. Múltiplos catch
// -------------------------
echo "\n2. MÚLTIPLOS CATCH:\n\n";

class BancoDadosException extends Exception {}
class ValidacaoException extends Exception {}
class PermissaoException extends Exception {}

function salvarUsuario($dados) {
    // Simula diferentes tipos de erro
    $erro = rand(1, 3);
    
    switch ($erro) {
        case 1:
            throw new ValidacaoException("Email inválido!");
        case 2:
            throw new BancoDadosException("Erro ao conectar ao banco!");
        case 3:
            throw new PermissaoException("Sem permissão para salvar!");
    }
}

for ($i = 1; $i <= 3; $i++) {
    echo "   Tentativa $i: ";
    try {
        salvarUsuario(['email' => 'teste@teste.com']);
        echo "Usuário salvo!\n";
    } catch (ValidacaoException $e) {
        echo "[VALIDAÇÃO] " . $e->getMessage() . "\n";
    } catch (BancoDadosException $e) {
        echo "[BANCO] " . $e->getMessage() . "\n";
    } catch (PermissaoException $e) {
        echo "[PERMISSÃO] " . $e->getMessage() . "\n";
    }
}

// -------------------------
// 3. Finally
// -------------------------
echo "\n3. FINALLY - SEMPRE EXECUTA:\n\n";

class Conexao {
    public $conectado = false;
    
    public function conectar() {
        echo "   [Conexão] Abrindo conexão...\n";
        $this->conectado = true;
    }
    
    public function desconectar() {
        echo "   [Conexão] Fechando conexão...\n";
        $this->conectado = false;
    }
    
    public function executar($sql) {
        if (str_contains($sql, 'ERRO')) {
            throw new Exception("Erro ao executar SQL!");
        }
        return "Resultado do SQL";
    }
}

function executarQuery($sql) {
    $conexao = new Conexao();
    
    try {
        $conexao->conectar();
        $resultado = $conexao->executar($sql);
        echo "   [OK] Query executada: $resultado\n";
        return $resultado;
    } catch (Exception $e) {
        echo "   [ERRO] " . $e->getMessage() . "\n";
        return null;
    } finally {
        // SEMPRE fecha a conexão, com ou sem erro
        $conexao->desconectar();
    }
}

echo "   Teste 1 - SQL válido:\n";
executarQuery("SELECT * FROM usuarios");

echo "\n   Teste 2 - SQL com ERRO:\n";
executarQuery("SELECT * FROM ERRO");

// -------------------------
// 4. Re-throwing (relançar exceção)
// -------------------------
echo "\n4. RE-THROWING (RELANÇAR EXCEÇÃO):\n\n";

function processarPagamento($valor) {
    try {
        if ($valor <= 0) {
            throw new InvalidArgumentException("Valor deve ser positivo!");
        }
        // Simula processamento
        if ($valor > 1000) {
            throw new Exception("Limite excedido!");
        }
        return "Pagamento de R$ $valor processado!";
    } catch (InvalidArgumentException $e) {
        // Trata localmente
        echo "   [LOCAL] Erro de validação tratado\n";
        throw $e;  // Relança para o chamador
    }
}

try {
    echo processarPagamento(-50);
} catch (Exception $e) {
    echo "   [CHAMADOR] Exceção recebida: " . $e->getMessage() . "\n";
}

// -------------------------
// 5. Exception chaining (encadeamento)
// -------------------------
echo "\n5. EXCEPTION CHAINING (ENCADEAMENTO):\n\n";

function buscarUsuario($id) {
    throw new Exception("Usuário $id não encontrado no banco!");
}

function autenticar($id, $senha) {
    try {
        $usuario = buscarUsuario($id);
    } catch (Exception $e) {
        // Encadeia a exceção original na nova
        throw new Exception(
            "Falha na autenticação",
            0,
            $e  // Exceção anterior
        );
    }
}

try {
    autenticar(123, "senha123");
} catch (Exception $e) {
    echo "   Erro: " . $e->getMessage() . "\n";
    
    if ($e->getPrevious()) {
        echo "   Causa: " . $e->getPrevious()->getMessage() . "\n";
    }
}

// -------------------------
// 6. Handler global de exceções
// -------------------------
echo "\n6. HANDLER GLOBAL DE EXCEÇÕES:\n\n";

// Define um handler global (útil para produção)
set_exception_handler(function(Throwable $e) {
    echo "   ╔═══════════════════════════════════════╗\n";
    echo "   ║     EXCEÇÃO NÃO TRATADA CAPTURADA     ║\n";
    echo "   ╠═══════════════════════════════════════╣\n";
    echo "   ║ " . str_pad($e->getMessage(), 37) . " ║\n";
    echo "   ╚═══════════════════════════════════════╝\n";
    
    // Em produção: registrar em log, enviar email, etc.
});

// Restaura o handler padrão para este exemplo não quebrar
restore_exception_handler();

echo "   Handler global configurado!\n";
echo "   Em produção, exceções não tratadas seriam capturadas.\n";

// -------------------------
// 7. Boas práticas
// -------------------------
echo "\n7. BOAS PRÁTICAS:\n\n";
echo "   ✓ Capture exceções específicas, não Exception genérico\n";
echo "   ✓ Use finally para liberar recursos (conexões, arquivos)\n";
echo "   ✓ Registre exceções em log para análise posterior\n";
echo "   ✓ Não silencie exceções (catch vazio)\n";
echo "   ✓ Crie exceções customizadas para seu domínio\n";
echo "   ✓ Inclua mensagens descritivas nas exceções\n";
echo "   ✓ Use exception chaining para preservar contexto\n";
echo "   ✓ Configure um handler global para produção\n";
