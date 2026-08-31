<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
include_once $_SERVER['DOCUMENT_ROOT'].'/iq/tool/log/tool-log.class.php';
_needphp('headers', 'pcss');

$Self = _rw::name('tool-log');
$nFB = $Self::nc('filter-button');

headers('css', 'utf8', 'nosniff', etag::ctx(__FILE__));
?>
.<?=$nFB?> {}
.<?=$nFB?>.-pressed {
    color: blue;
}