<?
$Self = _kot::self();
$nT = $Self::nc('tpl');
$nCPE = $Self::nc('C-PE'); //tpl-card--pers-exist
$Self::req_css('target-tpl');

_kot::req_vue('ui', 'button', array(), 'ui-button');
_kot::req_vue('ui', 'checkbox', array(), 'ui-checkbox');
?>

<section tw class="<?=$nT?> <?=$nCPE?>">
    <? if (!1) { ?><pre>cfg: {{ cfg }}</pre><? } ?>

	<?=$Self::tpl('vue-tpl-forecast')?>

    <ui-checkbox
        :ref="el => addValidate(el, 'flag')"
        :req="false"
        :label="'Привязан как минимум 1 носитель'" <?//Наличие привязанного носителя?>
        v-model:value="cfg['flag']"
    ></ui-checkbox>

    <?=$Self::tpl('vue-tpl-cmd')?>

</section>