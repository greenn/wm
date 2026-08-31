<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _rb::self();
$n = $Self::nc();
$nPos = $Self::nc('pos');

$tr = _css('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>
.<?=$nPos?> [pane] * {
    font-size: 15px;
}
.<?=$nPos?> [pane] [cp] {
    text-align: center;
    transition: transform 0.15s ease;
}

.<?=$nPos?> [pane] [cp]:hover {
    transform: scale(1.1);
}