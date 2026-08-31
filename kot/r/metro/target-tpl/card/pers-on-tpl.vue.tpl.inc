<?
$Self = _kot::self();
$nT = $Self::nc('tpl');
$nCPOn = $Self::nc('C-POn'); //tpl-card--pers-on
$Self::req_css('target-tpl');

_kot::req_vue('ui', 'button', array(), 'ui-button');
_kot::req_vue('ui', 'select-time-preset');
?>

<section tw class="<?=$nT?> <?=$nCPOn?>">
    <? if (0) { ?><pre>cfg: {{ cfg }}</pre><? } ?>

	<?=$Self::tpl('vue-tpl-forecast')?>

    <div fxr fxi="c" class="<?=$nCPOn?>-line1">
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

    <?=$Self::tpl('vue-tpl-cmd')?>

</section>