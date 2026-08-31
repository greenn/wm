<?
$Self = _kot::self();
$Self::req_css('form');

$nSSs = $Self::nc('select-stations');
$nSNg = $Self::nc('select-ngpt');

$Self::req_vue('select-ngpt-item');
?>
<div class="<?=$nSSs?> <?=$nSNg?>">
    <ui-busy :size="2" :visible="busy" v-if="busy"></ui-busy>
    <template v-for="(station, index) in stations">
        <!--<template v-if="station">-->
            <select-ngpt-item
                :ref="el => addValidate(el, station, index)"

                v-model:passes="station.passes"
                v-model:type="station.type"
                v-model:id="station.id"
                :typeOptions="typeOptions"
                :optionsData="optionsData"
                :addButton="index === stations.length - 1"
                :addButtonDisabled="!station.id"
                <?///v-model:checkbox="cfg['station-fix']"?>
                <?//@onReady="wait.station1 = true"?>
                @onRemove="removeItem(index)"
                @onAdd="addItem"
            ></select-ngpt-item>
            <div class="<?=$nSSs?>-sep" v-if="index !== stations.length - 1"></div>
        <!--</template>-->
    </template>
</div>