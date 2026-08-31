<?
$Self = _lay::self();
$nS3d1 = $Self::nc('S3d-1');

//_rb::req_css('lay', 'flex');
//_rb::req_css('page', 'css/aq');
$Self::req_css('split-3d-1');

$_ctx = $Self::tempCtx(array(
    'uri' => '',
    'pic' => '',
    'pic-height' => '',
    'height' => 400,
    'type' => 'narrow',
));
$uri = $_ctx['uri'];

if (!$uri) {
    $uri = _i::uri($_ctx['pic']);
}

$h = $_ctx['height'];

$type = $_ctx['type'];
$ncType = $type ? "-$type" : '';

$M_aCss = "style=\"height: {$h}px\""; //main
$S_aCss = "style=\"background-image: url($uri)\""; //Side

//$M_aCss = '';
//$S_aCss = '';
?>
<div class="<?=$nS3d1?> <?=$ncType?>" <?=$M_aCss?>>
    <div class="<?=$nS3d1?>-block">
        <div class="<?=$nS3d1?>-side -main" <?=$S_aCss?>></div>
        <div class="<?=$nS3d1?>-side -left" <?=$S_aCss?>></div>
    </div>
    <div class="<?=$nS3d1?>-block">
        <div class="<?=$nS3d1?>-side -main" <?=$S_aCss?>></div>
        <div class="<?=$nS3d1?>-side -left" <?=$S_aCss?>></div>
    </div>
    <div class="<?=$nS3d1?>-block">
        <div class="<?=$nS3d1?>-side -main" <?=$S_aCss?>></div>
        <div class="<?=$nS3d1?>-side -left" <?=$S_aCss?>></div>
    </div>
</div>