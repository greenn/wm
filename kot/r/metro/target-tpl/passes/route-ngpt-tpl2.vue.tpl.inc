<?
$Self = _kot::self();
$nT2 = $Self::nc('T2');
$nPRN = $Self::nc('P-SN'); //passes--route-ngpt
$Self::req_css('target-tpl');

//_kot::req_vue('ui', 'button', array(), 'ui-button');

$Self::req_vue('tpl2/tpl2-ngpt', array(), 'tpl2-ngpt');
$Self::req_vue('tpl2/tpl2-interval', array(), 'tpl2-interval');

?>
<section class="<?=$nT2?> -pt <?=$nPRN?>">

	<?=$Self::tpl('vue-tpl2-forecast')?>

    <tpl2-ngpt :value="cfg['list']"></tpl2-ngpt>

    <tpl2-interval class="-pt"
        :value="cfg['interval']"
        <?//:from="cfg['from']"?>
        <?//:to="cfg['to']"?>
    ></tpl2-interval>

</section>