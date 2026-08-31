<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _lay::self();
$nc = $Self::nc('Bk1');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    //etag::extra(),
    __FILE__
));
?>

.<?=$nc?> { background-color: lightcyan; }

@media (max-width: <?=_mq(2)?>px) {}