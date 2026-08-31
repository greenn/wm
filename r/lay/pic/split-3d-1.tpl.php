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
    //'type' => 'narrow',
    'type' => 'wide',
));
$uri = $_ctx['uri'];
$hPic = $_ctx['pic-height'];


if (!$uri) {
    $uri = _i::uri($_ctx['pic']);
    $hPic = _i::h($_ctx['pic']);
}

$h = $_ctx['height'];
$k = round($h * .95 / $hPic, 4);

$hk = $_ctx['height']; //scaled


$type = $_ctx['type'];
$ncType = $type ? "-$type" : '';

$W_aCss = "style=\"height: {$h}px\""; //wrapper
$M_aCss = "style=\"height: {$hPic}px; transform: scale($k)\""; //main
$S_aCss = "style=\"background-image: url($uri)\""; //Side

//$M_aCss = '';
//$S_aCss = '';
?>

<div oh class="<?=$nS3d1?>-w" <?=$W_aCss?>>

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

</div>