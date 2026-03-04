<?php

/**
 * ============================================
 * 3. INTERPRETANDO UMA PILHA DE EXCEÇÕES
 * ============================================
 * 
 * Stack Trace (Pilha de Exceções):
 * É o rastro de chamadas de funções que levaram ao erro.
 * Ajuda a identificar ONDE e COMO o erro ocorreu.
 * 
 * Leitura: De baixo para cima (do início ao ponto do erro)
 */

echo "=== PILHA DE EXCEÇÕES (STACK TRACE) ===\n\n";

// Criando uma cadeia de funções para demonstrar o stack trace
function funcaoA() {
    echo "Entrando na funcaoA...\n";
    funcaoB();
}

function funcaoB() {
    echo "Entrando na funcaoB...\n";
    funcaoC();
}

function funcaoC() {
    echo "Entrando na funcaoC...\n";
    funcaoD();
}

function funcaoD() {
    echo "Entrando na funcaoD...\n";
    // Aqui lançamos a exceção
    throw new Exception("Erro ocorreu na funcaoD!");
}

// -------------------------
// Demonstração do Stack Trace
// -------------------------
echo "1. DEMONSTRAÇÃO DO STACK TRACE:\n\n";

try {
    funcaoA();
} catch (Exception $e) {
    echo "\n========== EXCEÇÃO CAPTURADA ==========\n";
    echo "Mensagem: " . $e->getMessage() . "\n";
    echo "Arquivo: " . $e->getFile() . "\n";
    echo "Linha: " . $e->getLine() . "\n";
    
    echo "\n========== STACK TRACE (PILHA) ==========\n";
    echo $e->getTraceAsString() . "\n";
}

// -------------------------
// Analisando o Trace como Array
// -------------------------
echo "\n\n2. ANALISANDO O TRACE DETALHADAMENTE:\n\n";

function nivel1() {
    nivel2();
}

function nivel2() {
    nivel3();
}

function nivel3() {
    throw new Exception("Erro no nível 3!");
}

try {
    nivel1();
} catch (Exception $e) {
    $trace = $e->getTrace();
    
    echo "O erro passou por " . count($trace) . " níveis:\n\n";
    
    foreach ($trace as $index => $item) {
        echo "Nível $index:\n";
        echo "  - Função: " . ($item['function'] ?? 'N/A') . "\n";
        echo "  - Linha: " . ($item['line'] ?? 'N/A') . "\n";
        echo "\n";
    }
}

// -------------------------
// Dicas para ler o Stack Trace
// -------------------------
echo "3. DICAS PARA LER O STACK TRACE:\n\n";
echo "   1. Comece pela PRIMEIRA linha - é onde o erro ocorreu\n";
echo "   2. Siga as linhas para baixo para ver o caminho percorrido\n";
echo "   3. Procure por SUAS funções (ignore funções do framework)\n";
echo "   4. O número da linha indica onde a próxima função foi chamada\n";
echo "   5. Use as informações para encontrar a causa raiz do problema\n";
