<?
$Self = _kot::self();
$nT2 = $Self::nc('T2');
$nPR = $Self::nc('P-R'); //tpl-passenger--reg
$Self::req_css('target-tpl');

$Self::req_vue('tpl2/tpl2-interval', array(), 'tpl2-interval');
$Self::req_vue('tpl2/tpl2-checkbox', array(), 'tpl2-checkbox');

?>
<section class="<?=$nT2?> -pt <?=$nPR?>">

	<?=$Self::tpl('vue-tpl2-forecast')?>

    <div>
        <template v-if="cfg['flag']">
            Всем зарегистрированным пассажирам
        </template>
        <template v-else>
            <tpl2-interval
                :value="cfg['interval']"
		        <?//:from="cfg['from']"?>
		        <?//:to="cfg['to']"?>
            ></tpl2-interval>
        </template>
    </div>



</section>