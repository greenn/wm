<?
$Self = _blankRm::self();
$_ctx = $Self::tempCtx(array(
    'title' => 'RM test',
    'checks' => array(),
    'project-sid' => '',
    'resource-root' => '',
));

$title = htmlspecialchars((string)$_ctx['title'], ENT_QUOTES, 'UTF-8');
$projectSid = htmlspecialchars((string)$_ctx['project-sid'], ENT_QUOTES, 'UTF-8');
$resourceRoot = htmlspecialchars((string)$_ctx['resource-root'], ENT_QUOTES, 'UTF-8');
$checks = is_array($_ctx['checks']) ? $_ctx['checks'] : array();
?>
<main class="<?=$Self::nc()?>" data-rm-test-root>
    <header class="test-hero">
        <a class="wm-mark" href="./" title="Перезапустить титульный RM-тест" aria-label="WM RM test home">
            <span>w</span>m
        </a>
        <div>
            <p class="eyebrow">WM · v2 resource contract</p>
            <h1><?=$title?></h1>
            <p class="lead">Одна страница проверяет IQ проекта, named RM, connector,
                template API, CSS/JS source и контролируемый отказ.</p>
        </div>
        <span class="overall-status" data-overall-status>READY</span>
    </header>

    <section class="test-grid" aria-label="Результаты проверки">
        <? foreach ($checks as $name => $passed): ?>
            <article class="test-card <?=$passed ? 'is-pass' : 'is-fail'?>" data-check="<?=htmlspecialchars($name, ENT_QUOTES, 'UTF-8')?>">
                <span class="status-dot" aria-hidden="true"></span>
                <div>
                    <strong><?=htmlspecialchars($name, ENT_QUOTES, 'UTF-8')?></strong>
                    <small><?=$passed ? 'contract resolved' : 'contract failed'?></small>
                </div>
            </article>
        <? endforeach; ?>
    </section>

    <section class="contract-panel">
        <div>
            <p class="eyebrow">Resolved through framework</p>
            <h2><code>blankRmTpl('demo', 'card')</code></h2>
            <p>Template не знает физический путь страницы: его нашёл manager
                <code>_blankRm</code> через обязательный connector
                <code>demo.class.inc</code>.</p>
        </div>
        <dl>
            <div><dt>iqPro</dt><dd><?=$projectSid?></dd></div>
            <div><dt>RM</dt><dd>blankRm</dd></div>
            <div><dt>Component</dt><dd>demo</dd></div>
            <div><dt>Root</dt><dd title="Физический root RM"><?=$resourceRoot?></dd></div>
        </dl>
    </section>

    <section class="missing-panel">
        <span class="missing-icon" aria-hidden="true">!</span>
        <div>
            <p class="eyebrow">Expected diagnostic</p>
            <h2>Отсутствующий ресурс не был выдуман</h2>
            <p><code>_blankRm::req('missing-resource')</code> вернул
                <code>false</code>; framework не создал connector по имени каталога.</p>
        </div>
        <button type="button" data-run-check title="Повторить клиентскую проверку DOM и diagnostics">
            Проверить ещё раз
        </button>
    </section>

    <footer>
        <span>PHP 7.2 · short tags · no build</span>
        <span data-client-status>Ожидаем JavaScript…</span>
    </footer>
</main>
