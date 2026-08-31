<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _lay::self();
$n = $Self::nc();
$nVC1 = $Self::nc('VC1'); //vmk-context-1

$tr = css('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>

.<?=$nVC1?>-pic.-middle IMG {
    max-height: 150px;
}

@media (max-width: <?=_mq(2)?>px) {}