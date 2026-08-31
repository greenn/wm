<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
include_once $_SERVER['DOCUMENT_ROOT'].'/iq/tool/log/tool-log.class.php';
_needphp('headers', 'pcss');

$Self = _rw::name('tool-log');
$nSD = $Self::nc('start-date');

headers('css', 'utf8', 'nosniff', etag::ctx(__FILE__));
?>
.<?=$nSD?> {}