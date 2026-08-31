<?
$Self = _kot::self();
$nT = $Self::nc('tpl');
$nPAg = $Self::nc('P-Ag'); //tpl-passenger--age
$Self::req_css('target-tpl');

_kot::req_vue('ui', 'button', array(), 'ui-button');
_kot::req_vue('ui', 'field', array(), 'ui-field');
?>

<section tw class="<?=$nT?> <?=$nPAg?>">
    <? if (0) { ?><pre>cfg: {{ cfg }}</pre><? } ?>

	<?=$Self::tpl('vue-tpl-forecast')?>

    <div fxr fxi="c" class="<?=$nPAg?>-line1">
        <ui-field class="-num -cell _1"
            :ref="el => addValidate(el, 'numFrom')"
            :label="'От'"
            :def="0"
            v-model:value="cfg['numFrom']"
        ></ui-field>

        <ui-field class="-num -cell _2"
            :ref="el => addValidate(el, 'numTo')"
            :label="'до'"
            :def="0"
            v-model:value="cfg['numTo']"
        ></ui-field>
    </div>

    <?=$Self::tpl('vue-tpl-cmd')?>

</section>