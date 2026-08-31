<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _lay::self();
$nS3d2 = $Self::nc('S3d-2');

$tr = _css('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>

.<?=$nS3d2?>-w {
    perspective: 125vmin;
}

.<?=$nS3d2?> {
    top: 50%;
    left: calc(50% - .5*var(--dx)*85vmin);
    transform: rotatey(35deg);
    position: relative;
    transform-style: preserve-3d;
}

.<?=$nS3d2?>-panel {
    --mid: calc((var(--p) + var(--k)*0.25)*85vmin);
    transform: translate3d(calc(var(--dx)*85vmin), 0, calc(var(--dz)*85vmin));
}
.<?=$nS3d2?>-panel-before, .<?=$nS3d2?>-panel-after {
    position: absolute;
    margin: -32.5vmin -42.5vmin;
    width: 85vmin;
    height: 65vmin;
    <?//background: url("e2/bg_sq_halloween_0.jpg") 50%/cover;?>
}
.<?=$nS3d2?>-panel-before {
    transform-origin: var(--mid);
    transform: rotatey(-90deg);
    -webkit-clip-path: inset(0 calc(100% - var(--mid)) 0 calc(var(--p)*100%));
    clip-path: inset(0 calc(100% - var(--mid)) 0 calc(var(--p)*100%));
    filter: brightness(0.4);
}
.<?=$nS3d2?>-panel-after {
    -webkit-clip-path: inset(0 calc(100% - (var(--p) + var(--k))*85vmin) 0 var(--mid));
    clip-path: inset(0 calc(100% - (var(--p) + var(--k))*85vmin) 0 var(--mid));
}

