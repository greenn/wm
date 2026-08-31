<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _lay::self();
$nRB1 = $Self::nc('RB1');

$tr = css('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));


$cg0 = '#c6d9dc';
$cg1 = '#b5c9cd';
$h_cg0 = '#aadeeb';
$h_cg1 = '#8fcee1';

$ct = '#005771';
$ct_h = '#327c93';


$fs = 14;
$pv = 20;
$ph = 50;

$br = floor(($fs + $pv + $ph) / 2);
?>

.ft-rbutton-1 {
    font-size: <?=$fs?>px;
    font-weight: 300;
    color: <?=$ct?>;
}

.<?=$nRB1?>:hover .ft-rbutton-1 {
    color: <?=$ct_h?>;
}

.<?=$nRB1?> {
    <?=pcss('transition', array(
        "background $tr",
        "padding $tr",
        "border-radius $tr",
    ))?>
    box-shadow: 14px 14px 5px -12px rgba(0,0,0,0.1);
<?/*
    background: linear-gradient(to bottom, <?=$cg0?> 0%, #fff 50%, <?=$cg1?> 100%);
    background: linear-gradient(to bottom, <?=$cg0?> 0%, <?=$cg1?> 100%);
*/?>
    background: linear-gradient(to bottom, <?=$cg0?>, <?=$cg1?>);
    padding: <?=$pv?>px <?=$ph?>px;
    border-radius: <?=$br?>px;
}

.<?=$nRB1?>:hover {
    background: linear-gradient(to bottom, <?=$h_cg0?>, <?=$h_cg1?>);
}

@media (max-width: <?=_mq(2)?>px) {}