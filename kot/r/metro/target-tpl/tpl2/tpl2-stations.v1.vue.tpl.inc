<?
$Self = _kot::self();
$nT2 = $Self::nc('T2');
$nT2S = $Self::nc('T2S'); //tpl2-stations
_kot::req_vue('ui', 'busy', array(), 'ui-busy');
?>
<span fxr fxw class="<?=$nT2?>">
    <span class="-pr">на станциях:</span>
    <div class="<?=$nT2S?>-stations">
        <ui-busy v-if="busy" :visible="true"></ui-busy>
        <template v-else-if="!value || !value.length">
            <b class="<?=$nT2?>-fix -warn">- выбрать -</b>
        </template>
        <template v-else>
            <span v-for="(station, index) in value">
                <b class="<?=$nT2?>-fix">{{ getStationTitle(station) }}</b>
                <span class="comma" v-if="index < value.length - 1">,</span>
            </span>
        </template>
    </div>
</span>