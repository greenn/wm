<?
$Self = _kot::self();
$n = $Self::nc();
$nC = $Self::nc('content');
$nTC = $Self::nc('top-cmd');

$tr = _cssKot('tr0');

$trSide = '400ms cubic-bezier(0.25, 0.8, 0.25, 1)';
$wSide = 416;
?>

BODY {
    background-color: <?=_cssKot('main-bg')?>;
}

.<?=$n?> {
    min-height: 100%;
}


.<?=$n?>-overlay {
    display: none;
    z-index: 2200;
    background-color: rgba(0,0,0,.2);
}
.<?=$n?>-overlay.-on {
    display: block;
}

.<?=$n?>-side {
    width: <?=$wSide?>px;
    padding-top: 90px;

<?=pcss('box-shadow', array(
	'0px 3px 5px -1px rgba(0, 0, 0, 0.2)',
	'0px 5px 8px 0px rgba(0, 0, 0, 0.14)',
	'0px 1px 14px 0px rgba(0, 0, 0, 0.12)'
))?>
<?=pcss('transition', "left $trSide")?>
    background-color: <?=_cssKot('side-bg')?>;
}

.<?=$n?>.-min .<?=$n?>-side {
    left: -<?=$wSide?>px;
}


.<?=$n?>-side-head {
    height: 90px;
}

.<?=$n?>-side-pane {
    height: 100%;
}


.<?=$n?>-main {
    margin-left: 420px;
    background-color: <?=_cssKot('main-bg')?>;
    padding: 16px 25px;
    min-height: calc(100% - 34px);
    <?=pcss('transition', "margin-left $trSide")?>
}

.<?=$n?>-main-c {
    /*min-height: 180px;*/
    min-height: calc(100vh - 66px);
    /*min-width: calc(100vw - 490px);*/
    width: 100%;

    padding: 17px 10px;
    background-color: <?=_cssKot('content-bg')?>;

<?=pcss('border-radius', "4px")?>
<?=pcss('box-shadow', array(
	'0px 2px 1px -1px rgba(0, 0, 0, 0.2)',
	'0px 1px 1px 0px rgba(0, 0, 0, 0.14)',
	'0px 1px 3px 0px rgba(0, 0, 0, 0.12)',
))?>
<?=pcss('transition', array(
	"background-color $tr"
))?>

}

.<?=$nC?>-h1 {
    padding: 0 16px;
    margin-bottom: 12px;
}

.<?=$n?>.-min  .<?=$n?>-main {
    margin-left: 0px;
}

<?//                top-cmd                     ?>
.<?=$nTC?> {
    margin-bottom: 6px;
}

.<?=$nTC?> .<?=$B_n?> {
    margin-right: 10px;
    margin-bottom: 10px;
}