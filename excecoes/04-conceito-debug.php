<?php

/**
 * ============================================
 * 4. INTRODUÇÃO AO CONCEITO DE DEBUG
 * ============================================
 * 
 * Debug (Depuração):
 * Processo de encontrar e corrigir erros (bugs) no código.
 * 
 * Técnicas de Debug:
 * - var_dump() / print_r() - Inspecionar variáveis
 * - echo/print - Rastrear fluxo de execução
 * - error_log() - Registrar erros em arquivo
 * - Xdebug - Ferramenta profissional de debug
 */

echo "=== CONCEITOS DE DEBUG ===\n\n";

// -------------------------
// 1. var_dump() e print_r()
// -------------------------
echo "1. INSPECIONANDO VARIÁVEIS:\n\n";

$usuario = [
    'nome' => 'João Silva',
    'idade' => 25,
    'email' => 'joao@email.com',
    'ativo' => true
];

echo "var_dump() - Mostra tipo e valor:\n";
var_dump($usuario);

echo "\nprint_r() - Formato mais legível:\n";
print_r($usuario);

// -------------------------
// 2. Rastreando fluxo de execução
// -------------------------
echo "\n2. RASTREANDO FLUXO DE EXECUÇÃO:\n\n";

function processarPedido($pedido) {
    echo "[DEBUG] Iniciando processamento do pedido #{$pedido['id']}\n";
    
    // Passo 1: Validar
    echo "[DEBUG] Passo 1: Validando pedido...\n";
    if (empty($pedido['itens'])) {
        throw new Exception("Pedido sem itens!");
    }
    echo "[DEBUG] Validação OK\n";
    
    // Passo 2: Calcular total
    echo "[DEBUG] Passo 2: Calculando total...\n";
    $total = 0;
    foreach ($pedido['itens'] as $item) {
        echo "[DEBUG] Item: {$item['nome']} - R$ {$item['preco']}\n";
        $total += $item['preco'];
    }
    echo "[DEBUG] Total calculado: R$ $total\n";
    
    // Passo 3: Finalizar
    echo "[DEBUG] Passo 3: Finalizando pedido...\n";
    
    return $total;
}

$pedido = [
    'id' => 123,
    'itens' => [
        ['nome' => 'Camiseta', 'preco' => 59.90],
        ['nome' => 'Calça', 'preco' => 129.90]
    ]
];

try {
    $total = processarPedido($pedido);
    echo "\n[SUCESSO] Pedido processado! Total: R$ $total\n";
} catch (Exception $e) {
    echo "\n[ERRO] " . $e->getMessage() . "\n";
}

// -------------------------
// 3. error_log() - Registrar em arquivo
// -------------------------
echo "\n\n3. REGISTRANDO LOGS:\n\n";

function registrarLog($mensagem, $nivel = 'INFO') {
    $data = date('Y-m-d H:i:s');
    $log = "[$data] [$nivel] $mensagem";
    
    // Em produção, use: error_log($log, 3, 'app.log');
    echo "Log registrado: $log\n";
}

registrarLog("Aplicação iniciada");
registrarLog("Usuário logou: joao@email.com");
registrarLog("Tentativa de acesso negado", "WARNING");
registrarLog("Conexão com banco falhou", "ERROR");

// -------------------------
// 4. Técnicas de Debug com Exceções
// -------------------------
echo "\n\n4. DEBUG COM EXCEÇÕES:\n\n";

function debugExcecao(Exception $e) {
    echo "╔══════════════════════════════════════╗\n";
    echo "║         INFORMAÇÕES DO ERRO          ║\n";
    echo "╠══════════════════════════════════════╣\n";
    echo "║ Mensagem: " . str_pad($e->getMessage(), 27) . "║\n";
    echo "║ Código: " . str_pad($e->getCode(), 29) . "║\n";
    echo "║ Linha: " . str_pad($e->getLine(), 30) . "║\n";
    echo "╚══════════════════════════════════════╝\n";
    echo "\nStack Trace:\n";
    echo $e->getTraceAsString() . "\n";
}

try {
    throw new Exception("Erro de demonstração", 500);
} catch (Exception $e) {
    debugExcecao($e);
}

// -------------------------
// 5. Dicas de Debug
// -------------------------
echo "\n\n5. DICAS DE DEBUG:\n\n";
echo "   • Use nomes descritivos para variáveis\n";
echo "   • Divida funções grandes em funções menores\n";
echo "   • Adicione logs em pontos estratégicos\n";
echo "   • Teste seu código com diferentes entradas\n";
echo "   • Use try-catch para capturar erros específicos\n";
echo "   • Aprenda a usar o Xdebug para debug avançado\n";
