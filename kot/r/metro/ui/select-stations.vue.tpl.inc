<?
$Self = _kot::self();
$Self::req_css('form');

$nSSs = $Self::nc('select-stations');

$Self::req_vue('select-station');
?>
<div class="<?=$nSSs?>">
    <ui-busy :size="2" :visible="busy" v-if="busy"></ui-busy>
    <template v-for="(station, index) in stations">
        <!--<template v-if="station">-->
            <select-station
                :ref="el => addValidate(el, station, index)"
                v-model:value="station.id"
                v-model:passes="station.passes"
                :relOptions="true" :options="options"
                :addButton="index === stations.length - 1"
                :addButtonDisabled="!station.id"
                <?///v-model:checkbox="cfg['station-fix']"?>
                <?//@onReady="wait.station1 = true"?>
                @onRemove="removeItem(index)"
                @onAdd="addItem"
                <?//:mcd="mcd"?>
            ></select-station>
            <div class="<?=$nSSs?>-sep" v-if="index !== stations.length - 1"></div>
        <!--</template>-->
    </template>
</div>