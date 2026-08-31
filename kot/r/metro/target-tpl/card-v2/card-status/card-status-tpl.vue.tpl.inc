<?
$Self = _kot::self();
$nT = $Self::nc('tpl');
$nCCS = $Self::nc('C-CS'); //tpl-card--card-status
$Self::req_css('target-tpl');

_kot::req_vue('ui', 'button', array(), 'ui-button');
_kot::req_vue('ui', 'multi-select');
?>

<section tw class="<?=$nT?> <?=$nCCS?>">
    <? if (0) { ?><pre>cfg: {{ cfg }}</pre><? } ?>

    <multi-select
        :ref="el => addValidate(el, 'select')"
        :label="'Тип'"
        v-model:options="options"
        :info="optionsInfo"
        :busy="busy"
        v-model:value="cfg['list']"
    ></multi-select>

    <?=$Self::tpl('vue-tpl-cmd')?>

</section>