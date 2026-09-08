<?
$cardCtx = static::tempCtx(array('title' => 'RM template'));
?>
<section class="<?=static::nc()?>" data-rm-card>
    <div>
        <p class="eyebrow">ЖИВОЙ TEMPLATE</p>
        <h2><?=htmlspecialchars($cardCtx['title'], ENT_QUOTES, 'UTF-8')?></h2>
        <p>Этот фрагмент вернул <code>blankRmTpl('demo', 'card', $ctx)</code>.</p>
    </div>
    <dl>
        <div><dt>Named RM</dt><dd>blankRm</dd></div>
        <div><dt>Компонент</dt><dd>demo</dd></div>
        <div><dt>Connector</dt><dd>demo.class.inc</dd></div>
        <div><dt>Шаблон</dt><dd>card.tpl.php</dd></div>
    </dl>
</section>
