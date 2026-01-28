<?php
/**
 * Operon Cortex - Script de Diagnóstico de Ambiente
 * Este arquivo ajuda a identificar por que o MySQL não está conectando.
 */

header('Content-Type: text/html; charset=utf-8');

echo "<h1>🔍 Diagnóstico de Ambiente - Operon Cortex</h1>";

// 1. Verificar se o arquivo .env existe
$possiblePaths = [
    __DIR__ . '/../.env',
    __DIR__ . '/.env',
    dirname(__DIR__) . '/.env'
];

echo "<h2>1. Verificação de Arquivo .env</h2>";
$found = false;
foreach ($possiblePaths as $path) {
    echo "Pesquisando em: <code>$path</code> ... ";
    if (file_exists($path)) {
        echo "<strong style='color:green'>ENCONTRADO!</strong><br>";
        $found = $path;
        break;
    } else {
        echo "<span style='color:red'>Não encontrado</span><br>";
    }
}

if (!$found) {
    echo "<div style='background:#fee; border:1px solid red; padding:15px; margin:10px 0;'>";
    echo "<strong>ERRO CRÍTICO:</strong> O arquivo <code>.env</code> não existe no servidor!<br>";
    echo "Como ele está no .gitignore, o GitHub não o enviou. Você precisa criar este arquivo manualmente no seu painel da Hostinger (na mesma pasta onde está a pasta 'app').";
    echo "</div>";
}

// 2. Verificar variáveis carregadas
echo "<h2>2. Variáveis de Ambiente (getenv)</h2>";
$vars = ['APP_ENV', 'DB_TYPE', 'DB_HOST', 'DB_NAME', 'DB_USER'];
echo "<ul>";
foreach ($vars as $v) {
    $val = getenv($v);
    echo "<li><strong>$v:</strong> " . ($val ? "<code>$val</code>" : "<span style='color:red'>vazio / não definido</span>") . "</li>";
}
echo "</ul>";

// 3. Testar conexão PDO manual
echo "<h2>3. Teste de Conexão MySQL Direta</h2>";
if ($found) {
    $config = [];
    $lines = file($found, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') === false) continue;
        list($name, $value) = explode('=', $line, 2);
        $config[trim($name)] = trim($value);
    }

    try {
        $dsn = "mysql:host={$config['DB_HOST']};dbname={$config['DB_NAME']};charset=utf8mb4";
        $pdo = new PDO($dsn, $config['DB_USER'], $config['DB_PASS'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        echo "<strong style='color:green'>SUCESSO:</strong> Conexão MySQL estabelecida com sucesso!";
    } catch (Exception $e) {
        echo "<strong style='color:red'>ERRO:</strong> " . $e->getMessage();
    }
} else {
    echo "Não é possível testar sem o arquivo .env";
}

echo "<hr><p>Apague este arquivo (<code>public/debug.php</code>) após resolver o problema por segurança.</p>";
