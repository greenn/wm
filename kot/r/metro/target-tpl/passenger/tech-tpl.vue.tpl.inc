<?
$Self = _kot::self();
$nT = $Self::nc('tpl');
$nPT = $Self::nc('P-T'); //tpl-passenger--tech
$Self::req_css('target-tpl');

_kot::req_vue('ui', 'button', array(), 'ui-button');
_kot::req_vue('ui', 'multi-select');
?>

<section tw class="<?=$nT?> <?=$nPT?>">
    <? if (!1) { ?><pre>cfg: {{ cfg }}</pre><? } ?>

	<?=$Self::tpl('vue-tpl-forecast')?>

    <div>
        <multi-select class="-cell _2"
            :ref="el => addValidate(el, 'select')"
            :label="'Тип устройства'"
            v-model:options="options"
            :info="optionsInfo"
            :busy="busy"
            v-model:value="cfg['list']"
        ></multi-select>
    </div>

    <?=$Self::tpl('vue-tpl-cmd')?>

</section>