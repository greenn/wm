<?
$Self = _kot::self();
$nT2 = $Self::nc('T2');
$nCTD = $Self::nc('C-TD'); //tpl-card--ticket-design
$Self::req_css('target-tpl');

$Self::req_vue('tpl2/tpl2-interval', array(), 'tpl2-interval');
?>
<section class="<?=$nT2?> -pt <?=$nCTD?>">

	<?=$Self::tpl('vue-tpl2-forecast')?>

    <tpl2-list
        :label="'Выбранные типы:'"
        :list="cfg['list']"
        :info="info"
        :busy="busy"
    ></tpl2-list>

</section>