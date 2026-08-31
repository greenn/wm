<?
$Self = _kot::self();
$nT2 = $Self::nc('T2');
$nT2S = $Self::nc('T2S'); //tpl2-stations
_kot::req_vue('ui', 'busy', array(), 'ui-busy');
?>
<span fxr fxw class="<?=$nT2?> <?=$nT2S?>-stations">

    <? if (0) { ?><pre>value: {{ value }}</pre><? } ?>

    <span label class="-pr">
        Проходы:
    </span>



    <ui-busy v-if="busy" :visible="true"></ui-busy>
    <template v-else-if="!value || !value.length">
        <b class="<?=$nT2?>-fix -warn">- выбрать -</b>
    </template>
    <template v-else>
        <span v-for="(item, index) in value">
            <span class="-pr">более</span>
            <b class="<?=$nT2?>-fix -pr">{{ item.passes }} </b>
            <span class="-pr">вид</span>
            <b class="<?=$nT2?>-fix -pr">{{ typeTitle(item) }}</b>
            <span class="-pr">маршрут</span>
            <b class="<?=$nT2?>-fix">{{ valueTitle(item) }}</b>
            <span class="sep-or" v-if="index < value.length - 1">(или)</span>
        </span>
    </template>
</span>