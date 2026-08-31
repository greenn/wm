<?
$Self = _kot::self();
$nT = $Self::nc('tpl');
$nRRn = $Self::nc('R-Rn'); //tpl-restore--rebalance-reason
$Self::req_css('target-tpl');

_kot::req_vue('ui', 'button', array(), 'ui-button');
_kot::req_vue('ui', 'checkbox', array(), 'ui-checkbox');
?>

<section tw class="<?=$nT?> <?=$nRRn?>">
    <? if (!1) { ?><pre>cfg: {{ cfg }}</pre><? } ?>

	<?=$Self::tpl('vue-tpl-forecast')?>

    <ui-checkbox
        :ref="el => addValidate(el, 'flag')"
        :label="'Перенос по инициативе пассажира'"
        v-model:value="cfg['flag']"
    ></ui-checkbox>

    <?=$Self::tpl('vue-tpl-cmd')?>

</section>