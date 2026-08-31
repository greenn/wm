<?
$Self = _kot::self();
$nT2 = $Self::nc('T2');
$nCTT = $Self::nc('C-TT'); //tpl-card--ticket-type
$Self::req_css('target-tpl');

$Self::req_vue('tpl2/tpl2-interval', array(), 'tpl2-interval');
?>
<section class="<?=$nT2?> -pt <?=$nCTT?>">

	<?=$Self::tpl('vue-tpl2-forecast')?>

    <tpl2-list
        :label="'Выбранные типы:'"
        :list="cfg['list']"
        :info="info"
        :busy="busy"
    ></tpl2-list>

</section>