<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
include_once $_SERVER['DOCUMENT_ROOT'].'/iq/tool/log/tool-log.class.php';
_needphp('headers', 'pcss');

$Self = _rw::name('tool-log');
$nLt = $Self::nc('log-list');

headers('css', 'utf8', 'nosniff', etag::ctx(__FILE__));
?>
.<?=$nLt?> {}