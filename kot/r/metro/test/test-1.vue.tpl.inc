<?
$Self = _kot::self();
$n = $Self::nc();

_kot::req_vue('ui', 'content-section');

_kot::req_vue('ui', 'select', array(), 'ui-select');
_kot::req_vue('ui', 'select-station');

_kot::req_vue('ui', 'select-time');
?>
<div>

    <? if (0) { ?>
    <content-section :title="'select-time'" :open="true">
        <div>time1: {{ cfg.time1 || "-пусто-" }}</div>
        <div>time1-fix: {{ cfg['time1-fix'] }}</div>

        <select-time
            :label="'От'"
            v-model:value="cfg.time1"
            v-model:checkbox="cfg['time1-fix']"
        ></select-time>
    </content-section>
    <? } ?>

    <content-section :title="'select-station'" :open="true">

        <div>Станция: {{ cfg.station || "-пусто-" }}</div>
        <div>fix: {{ cfg['station-fix'] }}</div>

        <? if (0) { ?>
            <ui-select
                :label="'На станции'"
                :options="stationOptions"
                :busy="stationBusy"
                v-model:value="cfg.station"
                v-model:checkbox="cfg['station-fix']"
            ></ui-select>
        <? } ?>

        <select-station
            <?//:busy="stationBusy"?>
            v-model:value="cfg.station"
            v-model:checkbox="cfg['station-fix']"
            @onReady="onStationData"
        ></select-station>

    </content-section>
</div>