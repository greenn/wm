<?
$Self = _kot::self();
$nTW = $Self::nc('TW'); //target-view
$Self::req_css('target-tpl');
_kot::req_vue('ui', 'content-section');
_kot::req_vue('ui', 'no-field');
//_kot::req_vue('ui', 'field-forecast');
_kot::req_vue('ui', 'busy', array(), 'ui-busy');

$Self::req_vue('passes/station-freq-tpl2', array(), 'tpl2-passes--station-freq');
$Self::req_vue('passes/passes-qy-tpl2', array(), 'tpl2-passes--passes-qy');
$Self::req_vue('restore/rebalance-tpl2', array(), 'tpl2-restore--rebalance');
$Self::req_vue('restore/rebalance-time-tpl2', array(), 'tpl2-restore--rebalance-time');
$Self::req_vue('restore/rebalance-reason-tpl2', array(), 'tpl2-restore--rebalance-reason');
$Self::req_vue('write/balance-tpl2', array(), 'tpl2-write--balance');
$Self::req_vue('topup/time-tpl2', array(), 'tpl2-topup--time');
$Self::req_vue('topup/sum-tpl2', array(), 'tpl2-topup--sum');
$Self::req_vue('helpdesk/ticket-tpl2', array(), 'tpl2-helpdesk--ticket');
$Self::req_vue('sale/sale-tpl2', array(), 'tpl2-sale--sale');
$Self::req_vue('passenger/acc-tpl2', array(), 'tpl2-passenger--acc');
$Self::req_vue('passenger/age-tpl2', array(), 'tpl2-passenger--age');
$Self::req_vue('passenger/reg-tpl2', array(), 'tpl2-passenger--reg');
$Self::req_vue('passenger/bio-tpl2', array(), 'tpl2-passenger--bio');
$Self::req_vue('passenger/tech-tpl2', array(), 'tpl2-passenger--tech');
$Self::req_vue('message/feedback-tpl2', array(), 'tpl2-message--feedback');
$Self::req_vue('services/usage-tpl2', array(), 'tpl2-services--usage');
$Self::req_vue('place/transport-tpl2', array(), 'tpl2-place--transport');
$Self::req_vue('place/equipment-tpl2', array(), 'tpl2-place--equipment');
$Self::req_vue('place/operation-tpl2', array(), 'tpl2-place--operation');
$Self::req_vue('card/card-type-tpl2', array(), 'tpl2-card--card-type');
//$Self::req_vue('card/card-factor-tpl2', array(), 'tpl2-card--card-factor');
    $Self::req_vue('card-v2/card-factor-tpl2', array(), 'tpl2-card--card-factor');
$Self::req_vue('card/card-status-tpl2', array(), 'tpl2-card--card-status');
    //$Self::req_vue('card-v2/card-status-tpl2', array(), 'tpl2-card--card-status');
$Self::req_vue('card/pers-exist-tpl2', array(), 'tpl2-card--pers-exist');
$Self::req_vue('card/pers-qy-tpl2', array(), 'tpl2-card--pers-qy');
$Self::req_vue('card/pers-on-tpl2', array(), 'tpl2-card--pers-on');
$Self::req_vue('card/pers-off-tpl2', array(), 'tpl2-card--pers-off');
$Self::req_vue('card-v2/ticket-type-tpl2', array(), 'tpl2-card--ticket-type');
$Self::req_vue('card-v2/ticket-design-tpl2', array(), 'tpl2-card--ticket-design');
$Self::req_vue('passes/route-ngpt-tpl2', array(), 'tpl2-passes--route-ngpt');
$Self::req_vue('passes/station-mcd-tpl2', array(), 'tpl2-passes--station-mcd');
?>

<content-section :title="'Таргеты в шаблоне'" :toggler="toggler || false" :icon="'apps'">

    <? if (0) { ?>
        <field-forecast class="<?=$nTW?>-forecast" v-if="forecast"
            :value="forecast"
            @onCalc="$emit('onCalcCoverage')"
            :busy="busyCoverage"
        ></field-forecast>
    <? } ?>

    <template v-if="targets && targets.length">
        <template v-for="(item, index) in targets">
            <div class="<?=$nTW?>-title ft-text w-bld">
                {{ item.title }}
                <? if (isLocalhost) { ?><span dbg>({{ item.name }})</span><? } ?>
            </div>

	        <? if (!1) { ?>
                <pre>item: {{ item }}</pre>
	        <? } ?>
	        <? /* ?>
            <field-forecast class="<?=$nTW?>-item-forecast" v-if="item"
                :disabled="!item.cfg"
                :value="item.forecast"
                @onCalc="calcCoverage(item)"
                :busy="item.busyCoverage"
            ></field-forecast>
	        <? */ ?>

            <div class="<?=$nTW?>-item" v-if="item.cfg">
	            <?if(1){?><component :is="item.tpl2" :cfg="item.cfg" :ref="el => addRef(el, item)"/><?}?>
	            <?if(0){/*?><component :is="item.tpl2" :cfg="item.cfg" :ref="el => item.ref = item.ref || el"/><?*/}?>
                <?if(0){/*?><component :is="item.tpl2" :cfg="item.cfg" :ref="function(el) { if (!item.ref) item.ref = el; }/><?*/}?>
            </div>

            <div class="<?=$nTW?>-busy" v-else>
                <ui-busy :visible="true"></ui-busy>
            </div>

            <div <?//v-if="index < targets.length - 1"?> class="<?=$nTW?>-sep"></div>
        </template>
    </template>
    <template v-else>
        <div class="<?=$nTW?>-empty">Ничего не выбрано</div>
    </template>
</content-section>
