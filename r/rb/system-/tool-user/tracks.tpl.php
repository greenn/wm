<?
$Self = self_rp();
$pr = $Self::relPath(__FILE__);

$_ctx = $Self::tplCtx(array(
	'data' => false,
)); //dx($_ctx);


$User = rp_user::$acc;

$stack = $User->tracksData();
$curTrackId = $User->curTrackId();
//dx('tracks', $stack);

?>

<h3>active track_id: <?=$curTrackId?></h3>
<div class="fx" style="flex-wrap: wrap;">
<? foreach($stack as $track_id => $item) {

?>
	<div style="<?=join(' ', array(
		'border: 1px solid blue;',
		//'width: 30%; margin: .5%',
		'width: 400px',
	))?>">
		<?= $Self::tpl("$pr/track-item", array(
			'data' => $item,
			'track_id' => $track_id,
			'is_cur' => $track_id === $curTrackId,
		)); ?>
	</div>
<? } ?>
</div>
