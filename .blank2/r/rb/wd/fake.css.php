<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');
$Self = _rb::self();
$nF = $Self::nc('fake');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(
        $nF
    ),
    __FILE__
), SITE_CACHE);
?>

.<?=$nF?> {
    display: table;
    position: relative;
}
.<?=$nF?>:after {
    content: '';
    display: block;
    position: absolute;
    left: 0; top: 0; right: 0; bottom: 0;
}

.<?=$nF?> IMG {
    width: 100%;
    float: left;
}

.<?=$nF?>[ib] {
    clear: none;
}
.<?=$nF?>[ib] IMG {
    float: none;
}
