<?
$checks = array(
    'bootstrap' => false,
    'iq-pro' => false,
    'connector' => false,
    'sources' => false,
    'missing-resource' => false,
    'template' => false,
);
$sourceHtml = '';
$cardHtml = '';
$errorCode = '';
$bufferLevel = ob_get_level();
ob_start();
try {
    include_once __DIR__.'/iq.inc';
    $checks['bootstrap'] = defined('BLANK_RM_READY');
    $checks['iq-pro'] = pro() instanceof iqPro && pro('opt', 'rMain') === 'blankRm';
    $checks['connector'] = _blankRm::req('demo') && _blankRm::name('demo') instanceof blankRm_demo;
    if (!$checks['connector']) throw new RuntimeException('blank-rm-connector-missing');

    blankRm('demo', 'registerSources');
    $sourceHtml = _source::html_export();
    $checks['sources'] = is_file(blankRm_demo::path('demo', 'css'))
        && is_file(blankRm_demo::path('demo', 'js'))
        && strpos($sourceHtml, 'href="'.blankRm_demo::uri('demo.css').'"') !== false
        && strpos($sourceHtml, 'src="'.blankRm_demo::uri('demo.js').'"') !== false;
    $checks['missing-resource'] = _blankRm::req('missing-resource') === false
        && _blankRm::name('missing-resource') === false;

    $cardHtml = blankRmTpl('demo', 'card', array('title' => 'Компонент найден. Шаблон работает.'));
    $checks['template'] = strpos($cardHtml, 'data-rm-card') !== false;
    if (ob_get_contents() !== '') throw new RuntimeException('blank-rm-unexpected-output');
} catch (Throwable $error) {
    $errorCode = 'blank-rm-load-failed';
    error_log('[blank/rm] '.$errorCode.': '.$error->getMessage());
}
// Also discard a template buffer if rendering was interrupted by an exception.
while (ob_get_level() > $bufferLevel) ob_end_clean();
$pageOk = $errorCode === '' && !in_array(false, $checks, true);
if (!$pageOk) {
    http_response_code(500);
    if ($errorCode === '') $errorCode = 'blank-rm-contract-failed';
}
header('Content-Type: text/html; charset=UTF-8');
header('X-Content-Type-Options: nosniff');
$diagnostics = json_encode(array('ok' => $pageOk, 'checks' => $checks, 'errorCode' => $errorCode));
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WM · Проверка ресурсного модуля</title>
    <?=$sourceHtml?>
</head>
<body data-rm-diagnostics="<?=htmlspecialchars($diagnostics, ENT_QUOTES, 'UTF-8')?>">
    <main class="rm-test">
        <header class="test-header">
            <a class="wm-logo" href="./" title="Открыть титульную страницу RM-теста">WM<span>/ rm</span></a>
            <span class="test-label">V2 · ИСПОЛНЯЕМЫЙ ПРИМЕР</span>
        </header>
        <section class="test-intro">
            <p class="eyebrow">01 / RESOURCE MANAGER</p>
            <h1>От connector<br>до страницы.</h1>
            <p class="test-description">Минимальный named RM: свой компонент, шаблон и ресурсы.
                Каждый шаг проверяется здесь, при открытии страницы.</p>
            <p class="overall-status" data-overall-status role="status"><?=$pageOk ? 'Сервер: PASS · проверяем браузер…' : 'Сервер: FAIL'?></p>
        </section>
        <section class="check-grid" aria-label="Серверные проверки">
            <? foreach ($checks as $checkName => $passed): ?>
            <article class="check-item" data-check="<?=$checkName?>" data-passed="<?=$passed ? 'true' : 'false'?>">
                <span class="check-status"><?=$passed ? 'PASS' : 'FAIL'?></span>
                <h2><?=$checkName?></h2>
            </article>
            <? endforeach; ?>
        </section>
        <?=$cardHtml?>
        <? if ($errorCode): ?>
        <p role="alert">Ошибка: <code><?=$errorCode?></code>. Подробности — в PHP error log.</p>
        <? endif; ?>
        <section class="missing-note">
            <h2>Проверяем и отсутствие ресурса</h2>
            <p><code>missing-resource</code>: <?=$checks['missing-resource'] ? 'connector отсутствует; req() и name() вернули false — ожидаемый результат.' : 'ожидаемый отказ не подтверждён; проверьте диагностику.'?></p>
        </section>
        <footer class="test-footer">
            <span>PHP 7.2 · IQ v2 · blankRm</span>
            <button type="button" data-check-again title="Повторить проверку DOM, CSS и серверных результатов" hidden>Проверить ещё раз</button>
        </footer>
    </main>
    <script>
    (() => {
        const diagnostics = JSON.parse(document.body.dataset.rmDiagnostics);
        Object.entries(diagnostics.checks).forEach(([stage, passed]) => {
            console.log('[blank/rm] ' + stage, { passed });
        });
        if (diagnostics.errorCode) console.log('[blank/rm] error', { code: diagnostics.errorCode });
    })();
    </script>
</body>
</html>
