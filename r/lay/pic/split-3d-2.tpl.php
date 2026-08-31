<?
$Self = _lay::self();
$nS3d2 = $Self::nc('S3d-2');

//_rb::req_css('lay', 'flex');
//_rb::req_css('page', 'css/aq');
$Self::req_css('split-3d-2');

$_ctx = $Self::tempCtx(array(
	'uri' => '',
	'pic' => '',
	'height' => 400,
));
$uri = $_ctx['uri'];
if (!$uri) {
	$uri = _i::uri($_ctx['pic']);
}

$h = $_ctx['height'];

$M_Css = "height: {$h}px"; //main
$P_aCss = "style=\"background: url($uri) 50%/cover\""; //Panel

//$M_Css = '';
//$P_aCss = '';
?>

<div class="<?=$nS3d2?>-w">
    <div class="<?=$nS3d2?>" style="--dx: 0; <?=$M_Css?>">
        <div class="<?=$nS3d2?>-panel" style="--i: 0; --k: 0.25; --p: 0; --dx: 0; --dz: -0.2">
            <div class="<?=$nS3d2?>-panel-before" <?=$P_aCss?>></div>
            <div class="<?=$nS3d2?>-panel-after" <?=$P_aCss?>></div>
        </div>
        <div class="<?=$nS3d2?>-panel" style="--i: 1; --k: 0.5; --p: 0.25; --dx: -0.1; --dz: 0">
            <div class="<?=$nS3d2?>-panel-before" <?=$P_aCss?>></div>
            <div class="<?=$nS3d2?>-panel-after" <?=$P_aCss?>></div>
        </div>
        <div class="<?=$nS3d2?>-panel" style="--i: 2; --k: 0.25; --p: 0.75; --dx: 0; --dz: 0">
            <div class="<?=$nS3d2?>-panel-before" <?=$P_aCss?>></div>
            <div class="<?=$nS3d2?>-panel-after" <?=$P_aCss?>></div>
        </div>
    </div>
</div>