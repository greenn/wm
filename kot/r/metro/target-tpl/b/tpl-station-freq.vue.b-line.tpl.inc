<?
$Self = _kot::self();
$nT = $Self::nc('tpl');
$nPQ = $Self::nc('PQ'); //passes-qy
$Self::req_css('target-tpl');

_kot::req_vue('ui', 'button', array(), 'ui-button');
_kot::req_vue('ui', 'field', array(), 'ui-field');
_kot::req_vue('ui', 'select-station');
_kot::req_vue('ui', 'select-time-preset');

?>

<section tw class="<?=$nT?>">

    <div fxr="sb" fxi="c">
        <ui-field class="-num"
            :label="'Проходов более'"
            :def="0"
            v-model:value="cfg['passes_min']"
            v-model:checkbox="cfg['passes_min-fix']"
        ></ui-field>

        <div style="width: 50%">
            <select-station
                v-model:value="cfg['station']"
                v-model:checkbox="cfg['station-fix']"
            ></select-station>
        </div>

    </div>

    <? if (1){ ?>
        <div fxr fxi="c">
            <select-time-preset
                :label="'В период'"
                v-model:value="cfg['interval']"
                <?//v-model:checkbox="cfg['interval-fix']"?>
                v-model:from="cfg['from']"
                v-model:to="cfg['to']"
            ></select-time-preset>
        </div>
    <? } else { ?>

        <div fxr fxi="c">
            <select-time-preset
                :label="'В период'"
                :type="'time'"
                v-model:value="cfg['from_preset']"
                v-model:checkbox="cfg['from-fix']"
                v-model:from="cfg['from']"
                v-model:to="cfg['to']"
            ></select-time-preset>
        </div>
    <? } ?>

	<? if (0) { ?>



    <div fxr fxi="c">

        <ui-field
            :label="'от'"
            :type="'datetime-local'"
            v-model:value="cfg['from']"
            v-model:checkbox="cfg['from-fix']"
        ></ui-field>

        <ui-field
            :label="'до'"
            :type="'datetime-local'"
            v-model:value="cfg['to']"
            v-model:checkbox="cfg['to-fix']"
        ></ui-field>

    </div>

	<? } ?>


    <?=$Self::tpl('vue-tpl-cmd')?>

</section>