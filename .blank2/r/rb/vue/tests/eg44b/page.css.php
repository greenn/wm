<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _rt::self();

$nP = $Self::nc('page');
$nM = $Self::nc('menu');
$nC = $Self::nc('content');


headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>

.<?=$nP?> {
    margin: 20px;
}

.<?=$nM?> {
    width: 200px;
    float: left;
    border: 1px dashed dimgrey;
    padding: 15px;
    margin: 10px;
}

.<?=$nC?> {
    width: 300px;
    float: left;
    border: 1px dashed dimgrey;
}