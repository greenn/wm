<?
$Self = _kot::self();
$nT2 = $Self::nc('T2');
$nT2S = $Self::nc('T2S'); //tpl2-stations
_kot::req_vue('ui', 'busy', array(), 'ui-busy');
?>
<span fxr fxw class="<?=$nT2?> <?=$nT2S?>-stations">

    <span label class="-pr">
        Проходов по станциям:
        <?//({{ value ? value.length : 0 }}шт)?>
    </span>

    <ui-busy v-if="busy" :visible="true"></ui-busy>

    <template v-else-if="!value || !value.length">
        <b class="<?=$nT2?>-fix -warn">- выбрать -</b>
    </template>
    <template v-else>
        <span v-for="(item, index) in value">
            <span class="-pr">более</span>
            <b class="<?=$nT2?>-fix -pr">{{ item.passes }} </b>
            <span class="-pr">на</span>
            <b class="<?=$nT2?>-fix">{{ getStationTitle(item) }}</b>
            <?//<span class="comma" v-if="index < value.length - 1">,</span>?>
            <span class="sep-or" v-if="index < value.length - 1">(или)</span>
        </span>
    </template>
</span>