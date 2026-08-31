<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _site::self();
$n = $Self::nc();
$n1 = $Self::nc('1');
$nC = $Self::nc('content');

$nP1 = $Self::nc('p1');


headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>

.<?=$nC?>-pic {

}
