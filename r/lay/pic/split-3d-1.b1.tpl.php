<?
$Self = _lay::self();
$nS3d1 = $Self::nc('S3d-1');

//_rb::req_css('lay', 'flex');
//_rb::req_css('page', 'css/aq');
$Self::req_css('split-3d-1');

$_ctx = $Self::tempCtx(array(
    'uri' => '',
    'pic' => '',
    'height' => 400,
));
$uri = $_ctx['uri'];


if (!$uri) {
    $uri = _i::uri($_ctx['pic']);
}
$S_h = $_ctx['height']; //100%
$B_h = $S_h; //100%
$BS_h = floor($S_h * .8); //80%


$B_aCss = "style=\"height: {$B_h}px\""; //Block
$BS_aCss = "style=\"height: {$BS_h}px\""; //BlockSide
$S_aCss = "style=\"background-image: url($uri); height: {$S_h}px\""; //Side

$S_aCss = '';
$B_aCss = '';
$BS_aCss = '';
?>

<div class="<?=$nS3d1?>">
    <div class="<?=$nS3d1?>-block" <?=$BS_aCss?>>
        <div class="<?=$nS3d1?>-side -main" <?=$S_aCss?>></div>
        <div class="<?=$nS3d1?>-side -left" <?=$S_aCss?>></div>
    </div>
    <div class="<?=$nS3d1?>-block" <?=$B_aCss?>>
        <div class="<?=$nS3d1?>-side -main" <?=$S_aCss?>></div>
        <div class="<?=$nS3d1?>-side -left" <?=$S_aCss?>></div>
    </div>
    <div class="<?=$nS3d1?>-block" <?=$BS_aCss?>>
        <div class="<?=$nS3d1?>-side -main" <?=$S_aCss?>></div>
        <div class="<?=$nS3d1?>-side -left" <?=$S_aCss?>></div>
    </div>
</div>