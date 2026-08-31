<?
$Self = _kot::self();
$nT = $Self::nc('tpl');
$nPlE = $Self::nc('Pl-E'); //tpl-place--equipment
$Self::req_css('target-tpl');

_kot::req_vue('ui', 'button', array(), 'ui-button');
_kot::req_vue('ui', 'multi-select');
?>

<section tw class="<?=$nT?> <?=$nPlE?>">
    <? if (!1) { ?><pre>cfg: {{ cfg }}</pre><? } ?>

	<?=$Self::tpl('vue-tpl-forecast')?>

    <div>
        <multi-select class="-cell _2"
            :ref="el => addValidate(el, 'select')"
            :label="'Тип оборудования'"
            v-model:options="options"
            :info="optionsInfo"
            :busy="busy"
            v-model:value="cfg['list']"
        ></multi-select>
    </div>

    <?=$Self::tpl('vue-tpl-cmd')?>

</section>