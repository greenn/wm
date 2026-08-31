<?
$Self = _kot::self();
$nT = $Self::nc('tpl');
$nPQ = $Self::nc('PQ'); //passes-qy
$Self::req_css('target-tpl');

_kot::req_vue('ui', 'button', array(), 'ui-button');
_kot::req_vue('ui', 'field', array(), 'ui-field');
?>

<section t class="<?=$nT?> <?=$nPQ?>">

	<?=$Self::tpl('vue-tpl-forecast')?>

    <div>
        <ui-field class="-num -cell _1"
            :ref="el => addValidate(el, 'passes_min')"
            :label="'Количество'"
            :def="0"
            v-model:value="cfg['qy']"
            v-model:checkbox="cfg['qy-fix']"
        ></ui-field>
    </div>
    <div class="<?=$nT?>-vsep"></div>
    <div>
        <select-time-preset fxr fxi="b" class="-cell _2"
            :ref="el => addValidate(el, 'interval')"
            :label="'В период'"
            v-model:value="cfg['interval']"
            <?//v-model:checkbox="cfg['interval-fix']"?>
            :dates="!false"
            :datefields="false"
            <?//v-model:from="cfg['from']"?>
            <?//v-model:to="cfg['to']"?>
            @onReady="wait.interval = true"
        ></select-time-preset>
    </div>

	<?=$Self::tpl('vue-tpl-cmd')?>

</section>