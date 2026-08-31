<?

$Self = self_rp();


$_ctx = $Self::tplCtx(array(
	'sid' => true,
)); //dx($_ctx);

$sid = $_ctx['sid'];
if ($sid === true) $sid = session_id();

$sessionData = $Self::getSessionLogBySid($sid, false, 'html');


?>
<? foreach ($sessionData as $pid => $logData) { ?>
	<h2><?=$pid?></h2>
	<? foreach ($logData as $index => $item) {
		$type = $item['type'];
	?>
		<h3><?=$item['msg']?></h3>
		<div><?=$item['ctx']?></div>
	<? } ?>
<? } ?>

