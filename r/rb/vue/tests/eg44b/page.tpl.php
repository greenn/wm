<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

$Self = _rt::self();
$relDir = $Self::relDir();

$nP = $Self::nc('page');

$Self::req_js("$relDir/page");
$Self::req_css("$relDir/page");
?>
<div class="<?=$nP?>">
    <?=$Self::tpl("$relDir/menu")?>
    <?=$Self::tpl("$relDir/content")?>
</div>
