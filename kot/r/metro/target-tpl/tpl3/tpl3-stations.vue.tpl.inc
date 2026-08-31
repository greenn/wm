<?
$Self = _kot::self();
$nT3 = $Self::nc('T3');
$nT3S = $Self::nc('T3S'); //tpl3-stations
_kot::req_vue('ui', 'busy', array(), 'ui-busy');
?>
<span fxr fxw class="<?=$nT3?>">

    <div class="<?=$nT3S?>-stations">
        <template v-if="busy">
            <span class="-label">на станциях:</span>
            <ui-busy size="3" :visible="true"></ui-busy>
        </template>
        <template v-else-if="!value || !value.length">
            <span class="-label">на станциях:</span>
            <b class="<?=$nT3?>-val -warn"><?=_pro('tpl3-nofix')?></b>
        </template>
        <template v-else>
            <span :title="stationsTitle">
                на
                <b class="<?=$nT3?>-val -sp">{{ value.length }}</b>
                <span v-if="value.length === 1">станции</span><span v-else>станциях</span>
            </span>
        </template>
    </div>
</span>