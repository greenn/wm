<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp('headers');

$oo = gt_on('oo'); //dbg
$v6 = gt_on('v6', true); //by design

$Self = _kot::self();
$n = $Self::nc();
$nBy = $Self::nc('busy');
$nCS = $Self::nc('CS'); //content-section
$nBA = $Self::nc('BA'); //busy-area


$tr = _cssKot('tr0');
$trq = _cssKot('trq1');

$css = array();
$cssDir = $Self::path(); //same $Self::relDir();
headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    $css['eff'] = "$cssDir/ui-eff.css.inc",
	$css['spinner'] = "$cssDir/ui-spinner.css.inc",
    __FILE__
));

?>

.material-icons.cmd-back {
    <?=pcss('transform', 'translateX(25%)')?>
}
.material-icons.rotate-90 {
    <?=pcss('transform', 'rotate(90deg) translateX(25%)')?>
}

.material-icons.-mr {
    margin-right: 3px;
}

.material-icons.-ot {
    position: relative;
    top: 1px;
}

<?//                        button                     ?>
<?
    $By_s = 24;
    $By_sI = 31;
    $By_oI = ceil(($By_sI - $By_s) / 2);
    $By_m = 6;
    $By_bc = '#eb4d3d';
    $By_bs = 4;
?>
.<?=$nBy?> {
    width: <?=$By_s?>px;
    height: <?=$By_s?>px;
    opacity: 0;
    <?=pcss('transition', "opacity $trq")?>
}

.<?=$nBy?>.-visible {
    opacity: 1;
}

.<?=$nBy?>[left] {
    margin-right: <?=$By_oI + $By_m?>px;
}
.<?=$nBy?>[right] {
    margin-left: <?=$By_oI + $By_m?>px;
}

.<?=$nBy?>-icon {
    top: -<?=$By_oI?>px;
    left: -<?=$By_oI?>px;
    width: <?=$By_sI?>px;
    height: <?=$By_sI?>px;
    border-radius: 50%;
    border-width: <?=$By_bs?>px;
    border-style: solid;
    border-color: <?=$By_bc?>;
    animation: spinner-bulqg1 0.8s infinite linear alternate,
    spinner-oaa3wk 1.6s infinite linear;
}

<?
    $By_s = 18;
    $By_sI = 21;
    $By_oI = ceil(($By_sI - $By_s) / 2);
    $By_bs = 3;
    $By_m = 4;
?>
.<?=$nBy?>[size="2"] {
    width: <?=$By_s?>px;
    height: <?=$By_s?>px;
}
.<?=$nBy?>[size="2"] .<?=$nBy?>-icon {
    top: -<?=$By_oI?>px;
    left: -<?=$By_oI?>px;
    width: <?=$By_sI?>px;
    height: <?=$By_sI?>px;
    border-width: <?=$By_bs?>px;
}
.<?=$nBy?>[size="2"][left] {
    margin-right: <?=$By_oI + $By_m?>px;
}
.<?=$nBy?>[size="2"][right] {
    margin-left: <?=$By_oI + $By_m?>px;
}


<?
    $By_s = 10;
    $By_sI = 12;
    $By_oI = ceil(($By_sI - $By_s) / 1);
    $By_bs = 2;
    $By_m = 2;
?>
.<?=$nBy?>[size="3"] {
    width: <?=$By_s?>px;
    height: <?=$By_s?>px;
}
.<?=$nBy?>[size="3"] .<?=$nBy?>-icon {
    top: -<?=$By_oI?>px;
    left: -<?=$By_oI?>px;
    width: <?=$By_sI?>px;
    height: <?=$By_sI?>px;
    border-width: <?=$By_bs?>px;
}
.<?=$nBy?>[size="3"][left] {
    margin-right: <?=$By_oI + $By_m?>px;
}
.<?=$nBy?>[size="3"][right] {
    margin-left: <?=$By_oI + $By_m?>px;
}

<?//                        content-section                     ?>
.<?=$nCS?> {
    margin-bottom: 16px;
    <?=pcss('box-shadow', '0px 0px 4px rgba(0, 0, 0, 0.4)')?>;
}


.<?=$nCS?>-toggle {
    right: 16px;
    top: 16px;
}

.<?=$nCS?>-toggle .material-icons {
    <?=pcss('transition', "transform $tr")?>
}
.<?=$nCS?>.-closed .<?=$nCS?>-toggle .material-icons {
    <?=pcss('transform', 'rotate(180deg)')?>
}

.<?=$nCS?>-head {
    padding: 14px;
}

.<?=$nCS?>.-closed.-hover .<?=$nCS?>-head {
    background-color: <?=_cssKot('section-head-hover')?>;
}

.<?=$nCS?>-с {
    padding: 14px;
    padding-top: 0px;
}



<?//                busy-area           ?>

.<?=$nBA?> {
    background-color: <?=_cssKot('spinner-bg')?>;
    z-index: 2000;
}

/* content busy-area */
.<?=$nBA?>.-C {
    top: -2px;
    left: -3px;
    right: -3px;
    bottom: -4px;
}

.<?=$nBA?>-spinner {
<?
	$S_s = 40 //spinnes size
?>
    width: <?=$S_s?>px;
    height: <?=$S_s?>px;
    margin-top: -<?=ceil($S_s / 2)?>px;
    border-radius: 50%;
    border-width: 6px;
    border-style: solid;
    border-color: <?=_cssKot('spinner')?>;
    animation: spinner-bulqg1 0.8s infinite linear alternate,
    spinner-oaa3wk 1.6s infinite linear;
}



<? include $css['eff'] ?>

<? include $css['spinner'] ?>