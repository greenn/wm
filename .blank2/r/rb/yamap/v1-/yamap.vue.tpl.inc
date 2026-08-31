<?
$Self = _site::self();
$n = $Self::nc();

?>
<div>
    <? if (!1) { ?>
        <div>currentZoom: {{ currentZoom }}</div>
        <div>polygon: {{ polygon }}</div>
	<? } ?>

    <div r class="<?=$n ?>-map-section">
        <div v-if="!isMapLive"
             class="<?=$n?>-static"
             cp
             style="width: 1265px"
             :style="{
                'background-image': `url('${staticUrl}')`,
             }"
             @click="initLiveMap"
        >
            <img h ref="static" :src="staticUrl"  />
        </div>
        <div v-else
             ref="map" class="<?=$n?>-map" style="width: 1265px"
        ></div>

    </div>

</div>
