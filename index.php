<?php
/**
 * Operon Cortex - Front Controller Ponte (Hostinger)
 * 
 * Este arquivo serve como ponte entre o DocumentRoot da Hostinger (public_html)
 * e o entrypoint real do sistema (public/index.php).
 * 
 * NÃO MODIFIQUE ESTE ARQUIVO - Toda lógica está em /public/index.php
 */

// Define o caminho base do projeto (onde as pastas app, public etc estão)
define('BASE_PATH', __DIR__);

// Muda o diretório de trabalho para a pasta public original
// Isso garante que os caminhos relativos funcionem corretamente
chdir(BASE_PATH . '/public');

// Inclui o entrypoint real
require BASE_PATH . '/public/index.php';
