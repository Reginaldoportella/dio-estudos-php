<?php

/**
 * ============================================
 * 1. APRESENTAÇÃO E VISÃO GERAL - EXCEÇÕES PHP
 * ============================================
 * 
 * O que são exceções?
 * -------------------
 * Exceções são eventos que ocorrem durante a execução do programa
 * que interrompem o fluxo normal das instruções.
 * 
 * Por que usar exceções?
 * ----------------------
 * - Separar código de tratamento de erros do código principal
 * - Propagar erros pela pilha de chamadas
 * - Agrupar e diferenciar tipos de erros
 * - Código mais limpo e organizado
 * 
 * Diferença entre Erro e Exceção:
 * -------------------------------
 * - ERRO: Problema grave que não deveria ser tratado (ex: falta de memória)
 * - EXCEÇÃO: Problema que pode e deve ser tratado pelo programador
 */

echo "=== VISÃO GERAL DE EXCEÇÕES ===\n\n";

// Exemplo SEM tratamento de exceção (código frágil)
echo "1. Código SEM tratamento de exceção:\n";
echo "   - Se algo der errado, o programa para completamente\n";
echo "   - O usuário vê mensagens de erro confusas\n";
echo "   - Não há como recuperar o fluxo do programa\n\n";

// Exemplo COM tratamento de exceção (código robusto)
echo "2. Código COM tratamento de exceção:\n";
echo "   - Erros são capturados e tratados\n";
echo "   - O usuário vê mensagens amigáveis\n";
echo "   - O programa pode continuar executando\n\n";

// Demonstração prática
echo "=== DEMONSTRAÇÃO PRÁTICA ===\n\n";

// Função que pode gerar uma exceção
function dividir($a, $b) {
    if ($b == 0) {
        throw new Exception("Divisão por zero não é permitida!");
    }
    return $a / $b;
}

// Usando try-catch para tratar a exceção
try {
    echo "Tentando dividir 10 por 2: " . dividir(10, 2) . "\n";
    echo "Tentando dividir 10 por 0: " . dividir(10, 0) . "\n";
} catch (Exception $e) {
    echo "ERRO CAPTURADO: " . $e->getMessage() . "\n";
}

echo "\nO programa continua executando normalmente após o erro!\n";
