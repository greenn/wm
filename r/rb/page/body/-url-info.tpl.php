<?
    $constData = array(
        'URL',
        'pageUrl',
	    'URI',
        'pagePath',
        'pageUri',
    );

    $nc = 'url-info';

?>
<style type="text/css">
    .<?=$nc?>-label {
        display: inline-block;
        min-width: 65px;
    }
</style>

<? foreach($constData as $constName) {

?>
    <div class="<?=$nc?>-const">
        <span class="<?=$nc?>-label"><?=$constName?>:</span>
        <var>'<?=constant($constName)?>'</var>
    </div>
<? } ?>