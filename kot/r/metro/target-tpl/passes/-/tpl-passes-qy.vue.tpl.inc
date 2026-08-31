<?
$Self = _kot::self();
$nT = $Self::nc('tpl');
$nPQ = $Self::nc('PQ'); //passes-qy
$Self::req_css('target-tpl');

_kot::req_vue('ui', 'button', array(), 'ui-button');
_kot::req_vue('ui', 'field', array(), 'ui-field');
?>

<section t class="<?=$nT?>">
    <div>
        <ui-field fxr fxi="c" class="-num"
            :label="'Количество'"
            :def="0"
            v-model:value="cfg['passes_min']"
            v-model:checkbox="cfg['passes_min-fix']"
        ></ui-field>
    </div>
    <div fxr fxi="c">

        <ui-field fxr fxi="c"
            :label="'В период от'"
            :type="'datetime-local'"
            v-model:value="cfg['from']"
            v-model:checkbox="cfg['from-fix']"
        ></ui-field>

        <ui-field fxr fxi="c"
            :label="'до'"
            :type="'datetime-local'"
            v-model:value="cfg['to']"
            v-model:checkbox="cfg['to-fix']"
        ></ui-field>

    </div>

	<?=$Self::tpl('vue-tpl-cmd')?>

</section>