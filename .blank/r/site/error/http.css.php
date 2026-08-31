<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _site::self();
$nH = $Self::nc('http');

//$oo = gt_on('oo'); //dbg

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>
.<?=$nH?> {
    padding: 150px 200px
}

.<?=$nH?>-coolpic {
    padding: 20px 40px;
}

.<?=$nH?>-coolpic IMG {
    height: 150px;
}

.<?=$nH?>-uri {
    opacity: 0;
    margin-top: 30px;
    padding: 20px 50px;
}