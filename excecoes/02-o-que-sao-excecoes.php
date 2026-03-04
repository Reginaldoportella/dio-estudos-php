<?php

/**
 * ============================================
 * 2. O QUE SÃO EXCEÇÕES?
 * ============================================
 * 
 * Exceção é um objeto que descreve um erro ou comportamento inesperado.
 * 
 * Palavras-chave principais:
 * - try: Bloco de código a ser testado
 * - catch: Bloco que captura e trata a exceção
 * - throw: Lança uma exceção
 * - finally: Bloco que sempre executa (com ou sem erro)
 */

echo "=== O QUE SÃO EXCEÇÕES ===\n\n";

// -------------------------
// THROW - Lançando exceções
// -------------------------
echo "1. THROW - Lançando exceções:\n";

function verificarIdade($idade) {
    if ($idade < 0) {
        throw new Exception("Idade não pode ser negativa!");
    }
    if ($idade < 18) {
        throw new Exception("Menor de idade não permitido!");
    }
    return "Acesso permitido!";
}

// -------------------------
// TRY-CATCH - Capturando exceções
// -------------------------
echo "2. TRY-CATCH - Capturando exceções:\n\n";

// Teste 1: Idade válida
try {
    echo "   Testando idade 25: ";
    echo verificarIdade(25) . "\n";
} catch (Exception $e) {
    echo "   Erro: " . $e->getMessage() . "\n";
}

// Teste 2: Menor de idade
try {
    echo "   Testando idade 15: ";
    echo verificarIdade(15) . "\n";
} catch (Exception $e) {
    echo "   Erro: " . $e->getMessage() . "\n";
}

// Teste 3: Idade negativa
try {
    echo "   Testando idade -5: ";
    echo verificarIdade(-5) . "\n";
} catch (Exception $e) {
    echo "   Erro: " . $e->getMessage() . "\n";
}

// -------------------------
// FINALLY - Sempre executa
// -------------------------
echo "\n3. FINALLY - Bloco que sempre executa:\n\n";

function abrirArquivo($nome) {
    echo "   Tentando abrir arquivo: $nome\n";
    
    try {
        if (!file_exists($nome)) {
            throw new Exception("Arquivo não encontrado!");
        }
        $conteudo = file_get_contents($nome);
        echo "   Arquivo lido com sucesso!\n";
        return $conteudo;
    } catch (Exception $e) {
        echo "   ERRO: " . $e->getMessage() . "\n";
        return null;
    } finally {
        // Este bloco SEMPRE executa, com ou sem erro
        echo "   [FINALLY] Limpeza de recursos executada.\n";
    }
}

abrirArquivo("arquivo_inexistente.txt");

// -------------------------
// Propriedades de uma Exceção
// -------------------------
echo "\n4. PROPRIEDADES DE UMA EXCEÇÃO:\n\n";

try {
    throw new Exception("Mensagem de erro personalizada", 100);
} catch (Exception $e) {
    echo "   getMessage(): " . $e->getMessage() . "\n";
    echo "   getCode(): " . $e->getCode() . "\n";
    echo "   getFile(): " . $e->getFile() . "\n";
    echo "   getLine(): " . $e->getLine() . "\n";
}
