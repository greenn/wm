<?
$Self = _kot::self();
$nT2 = $Self::nc('T2');
$nHT = $Self::nc('H-T'); //tpl-helpdesk--ticket
$Self::req_css('target-tpl');

$Self::req_vue('tpl2/tpl2-interval', array(), 'tpl2-interval');
?>
<section class="<?=$nT2?> -pt <?=$nHT?>">

	<?=$Self::tpl('vue-tpl2-forecast')?>

    <tpl2-interval
        :value="cfg['interval']"
        <?//:from="cfg['from']"?>
        <?//:to="cfg['to']"?>
    ></tpl2-interval>

</section>