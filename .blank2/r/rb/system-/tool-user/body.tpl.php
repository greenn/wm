<?

$Self = self_rp();

$tplName = 'listing'; //|listing|workspace|monitor|

$tplCtx = array(
	'uid' => gt('uid'),
	'sid' => gt('sid'),
	'rid' => gt('rid'),
	'filter' => gt('filter'),
);

$pr = $Self::relPath(__FILE__); //rp relPath

$User = rp_user::$acc;


?>

<style type="text/css">
    <? inc_root('site/css/aq.css.inc') ?>
</style>

<? d($User->__dbgData()); ?>

<?= $Self::tpl("$pr/header")?>

<?= $Self::tpl("$pr/clear-session")?>

<?= $Self::tpl("$pr/tracks")?>
