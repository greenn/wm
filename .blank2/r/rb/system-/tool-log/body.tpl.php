<?

$Self = self_rp();

$tplName = 'listing.cur'; //|listing|workspace|monitor|

$tplCtx = array(
	'uid' => gt('uid'),
	'sid' => gt('sid'),
	'rid' => gt('rid'),
	'filter' => gt('filter'),
);

$pr = $Self::relPath(__FILE__);

if (!isMe) return print 'access denied';
?>

<style type="text/css">
    <? inc_root('site/css/aq.css.inc') ?>
    <? //qak call_rp('root', 'inc', 'css/aq.css.inc') ?>
</style>

<?= $Self::tpl('tool-log/logo')?>

<?//= $Self::tpl('tool-log/clear-session')?>
<?= $Self::tpl('tool-user/clear-session')?>

<?= $Self::tpl("$pr/$tplName", $tplCtx); ?>