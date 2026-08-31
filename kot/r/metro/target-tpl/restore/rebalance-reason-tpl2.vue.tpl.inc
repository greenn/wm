<?
$Self = _kot::self();
$nT2 = $Self::nc('T2');
$nRRn = $Self::nc('R-Rn'); //tpl-restore--rebalance-reason
$Self::req_css('target-tpl');

$Self::req_vue('tpl2/tpl2-checkbox', array(), 'tpl2-checkbox');
?>
<section class="<?=$nT2?> -pt <?=$nRRn?>">
	<?=$Self::tpl('vue-tpl2-forecast')?>

    <div>
        <tpl2-checkbox
            :label="'Перенос по инициативе пассажира'"
            :value="cfg['flag']"
            <?//:nc="'-num2'"?>
        ></tpl2-checkbox>
    </div>

</section>