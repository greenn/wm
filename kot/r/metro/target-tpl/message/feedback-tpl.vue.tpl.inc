<?
$Self = _kot::self();
$nT = $Self::nc('tpl');
$nMF = $Self::nc('M-F'); //tpl-message--feedback
$Self::req_css('target-tpl');

_kot::req_vue('ui', 'button', array(), 'ui-button');
_kot::req_vue('ui', 'select-time-preset');
?>

<section tw class="<?=$nT?> <?=$nMF?>">
    <? if (0) { ?><pre>cfg: {{ cfg }}</pre><? } ?>

	<?=$Self::tpl('vue-tpl-forecast')?>

    <div fxr fxi="c" class="<?=$nMF?>-line1">
        <ui-field class="-num2 -cell _1"
            :ref="el => addValidate(el, 'numFrom')"
            :label="'Количество от'"
            :def="0"
            v-model:value="cfg['numFrom']"
        ></ui-field>

        <ui-field class="-num2 -cell _2"
            :ref="el => addValidate(el, 'numTo')"
            :label="'до'"
            :def="0"
            v-model:value="cfg['numTo']"
        ></ui-field>
    </div>

    <div class="<?=$nT?>-vsep"></div>

    <div fxr fxi="c" class="<?=$nMF?>-line2">
        <select-time-preset <?//class="-cell _1"?>
            :ref="el => addValidate(el, 'interval')"
            :label="'В период'"
            v-model:value="cfg['interval']"
            <?//v-model:checkbox="cfg['interval-fix']"?>
            :dates="!false"
            :datefields="false"
            v-model:from="cfg['from']"
            v-model:to="cfg['to']"
            @onReady="wait.interval = true"
        ></select-time-preset>
    </div>

    <?=$Self::tpl('vue-tpl-cmd')?>

</section>