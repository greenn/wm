<?
$Self = _kot::self();
$nT2 = $Self::nc('T2');
$nPSM = $Self::nc('P-SM'); //passes--station-mcd
$Self::req_css('target-tpl');

//_kot::req_vue('ui', 'button', array(), 'ui-button');
_kot::req_vue('ui', 'field', array(), 'ui-field');

$Self::req_vue('tpl2/tpl2-field', array(), 'tpl2-field');
$Self::req_vue('tpl2/tpl2-stations', array(), 'tpl2-stations');
$Self::req_vue('tpl2/tpl2-interval', array(), 'tpl2-interval');

?>
<section class="<?=$nT2?> -pt <?=$nPSM?>">

	<?=$Self::tpl('vue-tpl2-forecast')?>

    <tpl2-stations :value="cfg['list']" :mcd="true"></tpl2-stations>

    <tpl2-interval class="-pt"
        :value="cfg['interval']"
        <?//:from="cfg['from']"?>
        <?//:to="cfg['to']"?>
    ></tpl2-interval>

</section>