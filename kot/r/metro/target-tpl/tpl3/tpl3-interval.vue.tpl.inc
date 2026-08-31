<?
_kot::req_vue('ui', 'busy', array(), 'ui-busy');

$Self = _kot::self();
$nT3 = $Self::nc('T3');
$nT3I = $Self::nc('T3I'); //tpl3-interval
?>
<div fxr fxw class="<?=$nT3?> <?=$nT3I?>">
    <span class="-pr">в период:</span>

    <ui-busy size="3" v-if="busy" :visible="true"></ui-busy>
    <template v-else-if="!value">
        <b class="<?=$nT3?>-val -nofix -warn"><?=_pro('tpl3-nofix')?></b>
    </template>
    <template v-else>
        <b class="<?=$nT3?>-val" :title="datesTitle">{{ valueTitle }}</b>
    </template>
</div>