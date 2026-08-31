<?
$Self = _kot::self();
$nT = $Self::nc('tpl');
$nPlO = $Self::nc('Pl-O'); //tpl-place--operation
$Self::req_css('target-tpl');

_kot::req_vue('ui', 'button', array(), 'ui-button');
_kot::req_vue('ui', 'multi-select');
?>

<section tw class="<?=$nT?> <?=$nPlO?>">
    <? if (!1) { ?><pre>cfg: {{ cfg }}</pre><? } ?>

	<?=$Self::tpl('vue-tpl-forecast')?>

    <div>
        <ui-field class="-num -cell _1"
            <?//:ref="el => addValidate(el, 'value')"?>
            :label="'Поиск'"
            :def="'-'"
            v-model:value="cfg['value']"
            :note="'(поиск не работает)'"
        ></ui-field>
    </div>

    <div>
        <multi-select class="-cell _2"
            :ref="el => addValidate(el, 'select')"
            :label="'Адрес'"
            v-model:options="options"
            :info="optionsInfo"
            :busy="busy"
            v-model:value="cfg['list']"
        ></multi-select>
    </div>



    <?=$Self::tpl('vue-tpl-cmd')?>

</section>