<?
$Self = _kot::self();
$nT2 = $Self::nc('T2');
$nCCF = $Self::nc('C-CF'); //tpl-card--card-factor
$Self::req_css('target-tpl');

$Self::req_vue('tpl2/tpl2-interval', array(), 'tpl2-interval');
?>
<section class="<?=$nT2?> -pt <?=$nCCF?>">

	<?=$Self::tpl('vue-tpl2-forecast')?>

    <tpl2-list
        :label="'Выбранные типы:'"
        :list="cfg['list']"
        :info="info"
        :busy="busy"
    ></tpl2-list>

</section>