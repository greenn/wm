<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp('headers');

$oo = gt_on('oo'); //dbg
$v6 = gt_on('v6', true); //by design

$Self = _kot::self();
$n = $Self::nc();
$nT = $Self::nc('tpl');

$nT2 = $Self::nc('T2');
$nT2S = $Self::nc('T2S'); //tpl2-stations
$nT2I = $Self::nc('T2I'); //tpl2-interval
$nT2L = $Self::nc('T2L'); //tpl2-list


$nT3 = $Self::nc('T3');
$nT3F = $Self::nc('T3F'); //tpl3-field
$nT3S = $Self::nc('T3S'); //tpl3-stations
$nT3I = $Self::nc('T3I'); //tpl3-interval

$nPQ = $Self::nc('PQ'); //passes-qy
$nPSF = $Self::nc('P-SF'); //passes--station-freq


$nL = $Self::nc('legend');
$nTW = $Self::nc('TW'); //target-view
$nTWI = $Self::nc('TWI'); //target-view-info

$n_UF = kot('ui', 'nc', 'field');
$n_UB = kot('ui', 'nc', 'button');
$n_UFF = kot('ui', 'nc', 'forecast-field');
$n_USTP = kot('ui', 'nc', 'STP');

$tr = _cssKot('tr0');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>

.<?=$n?>-res {
    margin-bottom: 45px;
}

.<?=$n?>-selecter [submit] {
    margin-top: 15px;
}

<?//                    tpl                   ?>
.<?=$nT?> .<?=$n_UF?>,
.<?=$nT?> [label] {
    margin-right: 10px;
}

.<?=$nT?>-vsep {
    height: 15px;
}

.<?=$nT?>-cmd {
    margin-top: 20px;
}

.<?=$nT?>-cmd .<?=$n_UB?> {
    margin-right: 10px;
}

<?//                    passes                   ?>
.<?=$nT?>.<?=$nPQ?> LABEL {
    display: inline-block;
    min-width: 100px;
}
.<?=$nT?>.<?=$nPQ?> .<?=$n_USTP?>-datefields LABEL {
    min-width: inherit;
}

<?//                    passes-qy                   ?>
.<?=$nPSF?>-line2 {
    margin-top: 20px;
}
.<?=$nPSF?>-line1[fxr].-v1 {
    align-items: center;
    justify-content: space-around;
}

.<?=$nPSF?>-line1 .-cell._1 {
    width: 40%;
    margin-right: 80px;
}
.<?=$nPSF?>-line1 .-cell._2 {

    width: 60%;
}

.<?=$nPSF?>-line1.-v1 .-cell._2 {
    margin-left: 20px;
}



<?//                    legend                   ?>
.<?=$nL?> {
    margin-bottom: 15px;
}
.<?=$nL?>-eg {
    margin-right: 3px;
}
.<?=$nL?>-eg:after {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0; right: 0;
}

.<?=$nL?>-item {
    line-height: 24px;
}

.<?=$nL?>-field {
    padding: 4px 6px;
    border: 1px solid <?=_cssKot('field-border')?>;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
}


<?//                    TPL2 для target-view                ?>


.<?=$nL?>-fix,
.<?=$nT2?>-fix {
    font-weight: 700;
    color: <?=_cssKot('warn-border')?>;
}

.<?=$nT2?>-fix.-warn {
    font-weight: 500;
    font-style: italic;
}

.<?=$nT2?> {}

.<?=$nT2?>.-pt {
    padding-top: 10px;
}

.<?=$nT2?> .-label,
.<?=$nT2?> .-pr {
    margin-right: 10px;
}

.<?=$nT2?>-sep {
    display: inline-block;
    width: 10px;
}

.<?=$nT2?> .<?=$n_UF?> {}

.<?=$nT2?> .<?=$n_UF?> [input] {
    padding: 5px 10px;
}

.<?=$nT2?> .<?=$n_UF?>.-num2 [input] {
    width: 30px;
}

.<?=$nT2?>-forecast {
    margin-bottom: 15px;
}

<?//                    TPL2-list (PL2-stations)                ?>
.<?=$nT2S?>-stations .sep-or {
    padding: 0 15px;
    font-family: monospace;
    display: inline-block;
}

.<?=$nT2L?>-list .comma,
.<?=$nT2S?>-stations .comma {
    display: inline-block;
    width: 8px;
}
<?//                    TPL2-list                ?>



<?//                    TPL2-interval                ?>
.<?=$nT2I?>-dates {
    margin-left: 10px;
}
.<?=$nT2I?>-dates .-sep {
    display: inline-block;
    width: 4px;
}
.<?=$nT2I?>-dates:before {
    content: '('
}
.<?=$nT2I?>-dates:after {
    content: ')'
}



<?//                    target view             ?>

.<?=$nTW?>-title {
    background-color: <?=_cssKot('flash-white')?>;;
    border: 1px solid <?='#e2e2e2'?>;
    padding: 6px 10px;
}
.<?=$nTW?>-item {
    padding: 6px 10px 0;
}

.<?=$nTW?>-busy {
    padding: 30px 0 10px 0;
    text-align: center;
}

.<?=$nTW?>-item-forecast {
    margin-top: 10px;
}

.<?=$nTW?>-forecast {
    margin-top: 10px;
    margin-bottom: 20px;
}
.<?=$nTW?>-forecast .<?=$n_UFF?>-button {}

.<?=$nTW?>-sep {
    height: 30px;
}

<?//                    target view info            ?>

<?//                    TPL3                ?>
.<?=$nT3?> *[title],
.<?=$nT3?>-val {
    cursor: default;
}

.<?=$nT3?> .-label,
.<?=$nT3?> .-pr {
    margin-right: 6px;
}
.<?=$nT3?> .-sp {<?//space?>
    margin-right: 3px;
}

.<?=$nT3?>-sep {
    display: inline-block;
    width: 8px;
}

.<?=$nT3?> .-warn {
    font-style: italic;

}

.<?=$nTWI?>-sep {
    height: 4px;
}

.<?=$nTWI?>-sep:before {
    content: '';
    position: absolute;
    left: 40%; right: 40%;
    top: 50%;
    margin-top: -1px;
    height: 1px;
    background-color: <?=_cssKot('table-border')?>;
}

@media (max-width: <?=_mq(2)?>px) {}