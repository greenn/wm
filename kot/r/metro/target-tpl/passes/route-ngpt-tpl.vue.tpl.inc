<?
$Self = _kot::self();
$nT = $Self::nc('tpl');
$nPRN = $Self::nc('P-SN'); //passes--route-ngpt
$Self::req_css('target-tpl');


_kot::req_vue('ui', 'button', array(), 'ui-button');
_kot::req_vue('ui', 'field', array(), 'ui-field');
_kot::req_vue('ui', 'select-ngpt');
_kot::req_vue('ui', 'select-time-preset');
js::wreq('wait-list');

?>

<section tw class="<?=$nT?> <?=$nPRN?>">
    <? if (!1) { ?><pre>cfg: {{ cfg }}</pre><? } ?>

	<?=$Self::tpl('vue-tpl-forecast')?>

    <div fxr fxi="c" class="<?=$nPRN?>-line1 <?//-v1?>">
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

    <div class="<?=$nPRN?>-line2">
        <select-ngpt
            :ref="el => addValidate(el, 'station')"
            v-model:value="cfg['list']"
            :valueWait="!!initData"
            <?//v-model:checkbox="cfg['station-fix']"?>
            @onReady="wait.station = true"
        ></select-ngpt>
    </div>

    <?=$Self::tpl('vue-tpl-cmd')?>

</section>