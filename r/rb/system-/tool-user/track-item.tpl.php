<?
$Self = self_rp();

$_ctx = $Self::tplCtx(array(
	'track_id' => false,
	'is_cur' => false,
	'data' => false,
)); //dx($_ctx);


$trackId = $_ctx['track_id'];
$isCur = $_ctx['is_cur'];
$trackData = $_ctx['data'];

$cssActive = '';
if ($isCur) $cssActive = 'color: #bf1bce;'
?>

<div style="padding: 15px;">
	<b style="<?=$cssActive?>"><?= $trackId ?></b>
	<? d($trackData) ?>
</div>
