<?php

// --- ShoeHub Boot Log ---
file_put_contents(__DIR__ . '/../storage/logs/boot.log', date('Y-m-d H:i:s') . " - Attempting to boot index.php\n", FILE_APPEND);

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// --- ShoeHub Premium Environment Health Check ---
$required_extensions = [
    'mbstring' => 'Multibyte String (Required for text processing)',
    'openssl'  => 'OpenSSL (Required for security/encryption)',
    'pdo_mysql' => 'PDO MySQL (Required for database connection)'
];

$missing = [];
foreach ($required_extensions as $ext => $desc) {
    if (!extension_loaded($ext)) {
        $missing[$ext] = $desc;
    }
}

if (!empty($missing)) {
    header('HTTP/1.1 500 Internal Server Error');
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Environment Setup Required | ShoeHub</title>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
        <style>
            :root { --primary: #7c3aed; --bg: #09090b; --card: #18181b; --text: #fafafa; --muted: #a1a1aa; }
            body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--text); display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; overflow: hidden; }
            .container { position: relative; z-index: 10; max-width: 500px; width: 90%; background: var(--card); padding: 40px; border-radius: 24px; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); text-align: center; }
            .glow { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 300px; height: 300px; background: var(--primary); filter: blur(120px); opacity: 0.15; z-index: 1; pointer-events: none; }
            h1 { font-size: 24px; font-weight: 800; margin-bottom: 12px; letter-spacing: -0.02em; }
            p { color: var(--muted); font-size: 15px; line-height: 1.6; margin-bottom: 30px; }
            .error-list { text-align: left; background: rgba(0,0,0,0.2); padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); margin-bottom: 30px; }
            .error-item { display: flex; align-items: center; gap: 12px; margin-bottom: 8px; font-size: 14px; }
            .error-item:last-child { margin-bottom: 0; }
            .indicator { width: 8px; height: 8px; background: #ef4444; border-radius: 50%; box-shadow: 0 0 10px #ef4444; }
            .btn { display: inline-block; background: var(--primary); color: white; padding: 14px 28px; border-radius: 12px; font-weight: 600; text-decoration: none; transition: all 0.2s; border: none; cursor: pointer; font-size: 15px; }
            .btn:hover { transform: translateY(-2px); opacity: 0.9; box-shadow: 0 10px 20px -5px rgba(124, 58, 237, 0.4); }
            footer { margin-top: 24px; font-size: 12px; color: var(--muted); }
        </style>
    </head>
    <body>
        <div class="glow"></div>
        <div class="container">
            <?php if (strpos(PHP_BINARY, 'Program Files') !== false): ?>
                <div style="background:rgba(239, 68, 68, 0.1); border: 1px solid #ef4444; padding: 15px; border-radius: 12px; margin-bottom: 25px; color: #ef4444; font-size: 14px; font-weight: 600;">
                    ⚠️ CAUTION: You are running the WRONG PHP version!
                </div>
            <?php endif; ?>
            
            <h1>ShoeHub Environment Setup</h1>
            <p>Your PHP environment is missing critical extensions required for <b>ShoeHub</b> to run securely and connect to the database.</p>
            
            <div class="error-list">
                <div class="error-item" style="color:var(--muted); font-size: 12px; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 8px; margin-bottom: 12px;">
                    <span><b>Active PHP:</b> <?php echo PHP_BINARY; ?></span><br>
                    <span><b>Config:</b> <?php echo php_ini_loaded_file() ?: 'None'; ?></span>
                </div>
                <?php foreach ($missing as $ext => $desc): ?>
                    <div class="error-item">
                        <div class="indicator"></div>
                        <span><b><?php echo $ext; ?>:</b> <?php echo $desc; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>

            <div style="margin-bottom: 30px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px;">
                <p style="font-size: 14px; color: #fff;"><b>How to Fix:</b></p>
                <ol style="text-align: left; font-size: 13px; color: var(--muted); line-height: 1.8;">
                    <li><b>Close</b> all black command windows on your computer.</li>
                    <li>Open <code>f:\Web development\ShoeHub-Laravel</code></li>
                    <li>Double-click on <b><code>run-server.bat</code></b></li>
                </ol>
            </div>
            
            <a href="javascript:location.reload()" class="btn">Check Again</a>
            
            <footer>Diagnostic ID: SH-ENV-FIX</footer>
        </div>
    </body>
    </html>
    <?php
    exit;
}
// --- End Health Check ---

// --- ShoeHub Environment Polyfill — Start ---
// This polyfill prevents crashes on systems where the mbstring extension is missing.
if (!function_exists('mb_split')) {
    function mb_split($pattern, $string, $limit = -1) { return preg_split('/' . $pattern . '/', $string, $limit); }
}
if (!function_exists('mb_strtolower')) {
    function mb_strtolower($string) { return strtolower($string); }
}
if (!function_exists('mb_strtoupper')) {
    function mb_strtoupper($string, $encoding = null) { return strtoupper($string); }
}
if (!function_exists('mb_substr')) {
    function mb_substr($string, $start, $length = null, $encoding = null) { return substr($string, $start, $length); }
}
if (!function_exists('mb_strlen')) {
    function mb_strlen($string, $encoding = null) { return strlen($string); }
}
if (!function_exists('mb_strpos')) {
    function mb_strpos($haystack, $needle, $offset = 0, $encoding = null) { return strpos($haystack, $needle, $offset); }
}
if (!function_exists('mb_strrpos')) {
    function mb_strrpos($haystack, $needle, $offset = 0, $encoding = null) { return strrpos($haystack, $needle, $offset); }
}
if (!function_exists('mb_str_split')) {
    function mb_str_split($string, $length = 1) { return str_split($string, $length); }
}
if (!function_exists('mb_convert_case')) {
    function mb_convert_case($string, $mode, $encoding = null) {
        if ($mode === 0 /* MB_CASE_UPPER */) return strtoupper($string);
        if ($mode === 1 /* MB_CASE_LOWER */) return strtolower($string);
        return ucwords(strtolower($string));
    }
}
if (!defined('MB_CASE_UPPER')) define('MB_CASE_UPPER', 0);
if (!defined('MB_CASE_LOWER')) define('MB_CASE_LOWER', 1);
if (!defined('MB_CASE_TITLE')) define('MB_CASE_TITLE', 2);
// --- ShoeHub Environment Polyfill — End ---

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
