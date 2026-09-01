<?
declare(strict_types=1);

$checks = array(
    'bootstrap' => false,
    'iq-pro' => false,
    'rm-connector' => false,
    'template' => false,
    'assets' => false,
    'missing-resource' => false,
);
$sourceHtml = '';
$pageHtml = '';
$errorCode = '';

try {
    include_once dirname(__FILE__).'/iq.inc';
    $checks['bootstrap'] = defined('WEB') && class_exists('_blankRm');

    $Project = pro();
    $checks['iq-pro'] = $Project instanceof iqPro
        && pro('opt', 'rMain') === 'blankRm';

    $Demo = _blankRm::req('demo') ? _blankRm::name('demo') : false;
    $checks['rm-connector'] = $Demo instanceof blankRm_demo;
    $checks['missing-resource'] = _blankRm::req('missing-resource') === false;

    if ($Demo) {
        $checks['template'] = $Demo::hasTpl('card');
        $checks['assets'] = is_file($Demo::path('demo', 'css.php'))
            && is_file($Demo::path('demo', 'js.php'));
        blankRm('demo', 'registerSources');
        $pageHtml = blankRmTpl('demo', 'card', array(
            'title' => 'Первый автономный RM-тест',
            'checks' => $checks,
            'project-sid' => pro('opt', 'sid'),
            'resource-root' => 'blank/rm/r',
        ));
        $checks['template'] = $checks['template'] && $pageHtml !== '';

        $sourceHtml = _source::html_export();
        $checks['assets'] = $checks['assets']
            && strpos($sourceHtml, 'demo.css.php') !== false
            && strpos($sourceHtml, 'demo.js.php') !== false;
    }
} catch (Throwable $error) {
    $errorCode = 'blank-rm-bootstrap-failed';
    error_log('[blank/rm] '.$errorCode.': '.$error->getMessage());
}

$criticalChecks = array('bootstrap', 'iq-pro', 'rm-connector', 'template', 'assets');
$pageOk = $errorCode === '';
foreach ($criticalChecks as $checkName) {
    if (empty($checks[$checkName])) $pageOk = false;
}

if (!$pageOk) {
    http_response_code(500);
    if ($errorCode === '') $errorCode = 'blank-rm-contract-failed';
}

header('Content-Type: text/html; charset=UTF-8');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: same-origin');
$cspNonce = base64_encode(random_bytes(18));
header("Content-Security-Policy: default-src 'self'; base-uri 'none'; frame-ancestors 'none'; object-src 'none'; img-src 'self' data:; style-src 'self'; script-src 'self' 'nonce-$cspNonce'");

$diagnostics = array(
    'ok' => $pageOk,
    'checks' => $checks,
    'errorCode' => $errorCode,
    'rm' => 'blankRm',
    'component' => 'demo',
);
$diagnosticsJson = json_encode($diagnostics, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
if ($diagnosticsJson === false) $diagnosticsJson = '{}';
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Тест named RM, IQ, template и source mechanism WM.">
    <title>blank/rm · WM resource test</title>
    <?=$sourceHtml?>
</head>
<body data-rm-diagnostics="<?=htmlspecialchars($diagnosticsJson, ENT_QUOTES, 'UTF-8')?>">
<? if ($pageOk): ?>
    <?=$pageHtml?>
<? else: ?>
    <main class="fallback-error">
        <h1>RM-тест не загрузился</h1>
        <p>Безопасный код диагностики: <code><?=htmlspecialchars($errorCode, ENT_QUOTES, 'UTF-8')?></code></p>
        <p>Техническая причина записана в PHP error log без вывода пути в страницу.</p>
    </main>
    <script nonce="<?=htmlspecialchars($cspNonce, ENT_QUOTES, 'UTF-8')?>">
    (() => {
        const diagnostics = JSON.parse(document.body.dataset.rmDiagnostics || '{}');
        Object.entries(diagnostics.checks || {}).forEach(([stage, passed]) => {
            console[passed ? 'log' : 'error'](`[blank/rm] ${stage}:${passed ? 'success' : 'error'}`, { passed });
        });
        console.error('[blank/rm] server:error', { code: diagnostics.errorCode || 'blank-rm-contract-failed' });
    })();
    </script>
<? endif; ?>
</body>
</html>
