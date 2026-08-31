<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _site::self();
$n = $Self::nc();
$nBGR = $Self::nc('BGR');

$tr = _css('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>

.<?=$n?> {
    height: 73px;
    margin-top: 10px;

    <?=pcss('transition', array(
        "margin-top $tr",
    ))?>
}

.<?=$n?>-search {
    margin-left: 10px;
}


.<?=$n?>-order {
    top: -5px;
}

<?
	$ni = 'header/bg-ribbon/src.png';
	$h = _i::h($ni);

    $niB = 'header/bg-ribbon/beyond/3/beyond-cut.png';
	$hB = _i::h($niB);

    $h -= $hB;
?>
.<?=$nBGR?> {
	max-width: <?=_i::w($ni)?>px;
	height: <?=$h?>px;
	background-image: url('<?=_i::uri($ni)?>');
	background-repeat: no-repeat;
	background-position: center top;
}

.<?=$nBGR?>-beyond {
    height: <?=$hB?>px;
    background-image: url('<?=_i::uri($niB)?>');
    background-repeat: no-repeat;
    background-position: center top;
}


@media (min-width: <?=_css::mq('max')?>px) {
    .<?=$n?> {
        margin-top: 30px;
    }
}