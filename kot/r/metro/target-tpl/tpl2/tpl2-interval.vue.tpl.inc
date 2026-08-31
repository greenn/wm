<?
$Self = _kot::self();
$Self::req_css('target-tpl');

$nT2 = $Self::nc('T2');
$nT2I = $Self::nc('T2I'); //tpl2-interval

_kot::req_vue('ui', 'busy', array(), 'ui-busy');
?>
<div fxr fxw class="<?=$nT2?> <?=$nT2I?>">
    <span class="-pr">в период:</span>

    <ui-busy v-if="busy" :visible="true"></ui-busy>
    <template v-else-if="!value">
        <b class="<?=$nT2?>-fix -warn">- выбрать -</b>
    </template>
    <template v-else>
        <b class="<?=$nT2?>-fix">{{ valueTitle() }}</b>
        <span class="<?=$nT2I?>-dates" v-if="from && to && 0">
            <span class="-first">пример: с <b>{{ from }}</b></span>
            <span class="-sep"></span>
            <span class="-last">по <b>{{ to }}</b></span>
        </span>
    </template>
</div>