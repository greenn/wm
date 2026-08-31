<?
$Self = _kot::self();
$nT = $Self::nc('tpl');
$nSeU = $Self::nc('Se-U'); //tpl-services--usage
$Self::req_css('target-tpl');

_kot::req_vue('ui', 'button', array(), 'ui-button');
_kot::req_vue('ui', 'multi-select');
?>

<section tw class="<?=$nT?> <?=$nSeU?>">
    <? if (!1) { ?><pre>cfg: {{ cfg }}</pre><? } ?>

	<?=$Self::tpl('vue-tpl-forecast')?>

    <div>
        <select-time-preset class="-cell _2"
            :ref="el => addValidate(el, 'interval')"
            :label="'Дата пользования сервисом'"
            v-model:value="cfg['interval']"
            <?//v-model:checkbox="cfg['interval-fix']"?>
            :dates="!false"
            :datefields="false"
            v-model:from="cfg['from']"
            v-model:to="cfg['to']"
            @onReady="wait.interval = true"
        ></select-time-preset>
    </div>
    <div>
        <multi-select class="-cell _2"
            :ref="el => addValidate(el, 'list')"
            :label="'Наименование сервиса'"
            v-model:options="options"
            :info="optionsInfo"
            :busy="busy"
            v-model:value="cfg['list']"
        ></multi-select>
    </div>

    <?=$Self::tpl('vue-tpl-cmd')?>

</section>