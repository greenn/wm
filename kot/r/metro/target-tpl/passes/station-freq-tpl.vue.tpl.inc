<?
$Self = _kot::self();
$nT = $Self::nc('tpl');
$nPSF = $Self::nc('P-SF'); //passes--station-freq
$Self::req_css('target-tpl');


_kot::req_vue('ui', 'button', array(), 'ui-button');
_kot::req_vue('ui', 'field', array(), 'ui-field');
_kot::req_vue('ui', 'select-stations');
_kot::req_vue('ui', 'select-time-preset');
js::wreq('wait-list');

?>

<section tw class="<?=$nT?> <?=$nPSF?>">
    <? if (0) { ?><pre>cfg: {{ cfg }}</pre><? } ?>

	<?=$Self::tpl('vue-tpl-forecast')?>

    <div fxr fxi="c" class="<?=$nPSF?>-line1 <?//-v1?>">
        <? if (0) { //v1 ?>
            <ui-field class="-num -cell _1"
                :ref="el => addValidate(el, 'passes_min')"
                :label="'Проходов более'"
                :def="0"
                v-model:value="cfg['qy']"
                v-model:checkbox="cfg['qy-fix']"
            ></ui-field>
        <? } ?>

        <select-time-preset class="-cell _2"
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

    <div class="<?=$nT?>-vsep"></div>

    <div class="<?=$nPSF?>-line2">
        <select-stations
            :ref="el => addValidate(el, 'station')"
            v-model:value="cfg['list']"
            :valueWait="!!initData"
            <?//v-model:checkbox="cfg['station-fix']"?>
            @onReady="wait.station = true"
        ></select-stations>
    </div>

    <?=$Self::tpl('vue-tpl-cmd')?>

</section>