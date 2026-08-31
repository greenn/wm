<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp('headers');

$oo = gt_on('oo'); //dbg
$v6 = gt_on('v6', true); //by design

$Self = _kot::self();
$nF = $Self::nc('field');
$nC = $Self::nc('checkbox');
$nTF = $Self::nc('text-field'); //text-field
$nNF = $Self::nc('no-field');
$nFF = $Self::nc('forecast-field');
$nFS = $Self::nc('form-section');
$nTH = $Self::nc('TH'); //table-handler
$nSSs = $Self::nc('select-stations');
$nSS = $Self::nc('select-station');
$nMS = $Self::nc('multi-select');
$nSTP = $Self::nc('STP'); //select-time-preset
$nS = $Self::nc('select');
$nBy = $Self::nc('busy');


$tr = _cssKot('tr0');
$trq = _cssKot('trq1');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>

.<?=$nFS?> {
    <?=pcss('box-shadow', '0px 0px 4px rgba(0, 0, 0, 0.4)')?>
    margin-top: 16px;
    margin-bottom: 18px;
    padding: 14px;
}


<?//                    CHECKBOX                      ?>

.<?=$nC?> {}

<?//                    SELECT                      ?>
.<?=$nS?> [label]{
    margin-right: 5px;
}

.<?=$nS?>.-disabled LABEL {
    color: rgb(170, 170, 170);
}

.<?=$nS?>.-pad {
    padding-top: 20px;
    padding-bottom: 5px;
}

.<?=$nS?> SELECT {
    border: none;
    border-bottom: 1px solid grey;
    outline: none;
}

.<?=$nS?>.-warn SELECT {
    border-bottom-color: <?=_cssKot('warn-border')?>;
}



<?//                    FIELD / INPUT                       ?>

.<?=$nF?>.-pad {
    padding-top: 20px;
    padding-bottom: 5px;
}

.<?=$nF?> [input] {
    width: <?=280 - 7*2?>px;
    padding: 8px 12px;
    border: 1px solid <?=_cssKot('field-border')?>;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
}



.<?=$nF?>[fxr] [label] {
    margin-right: 10px;
}

.<?=$nF?>[fxr] [note] {
    margin-left: 8px;
}

.<?=$nF?>.-num [input] {
    width: 100px;
}
.<?=$nF?>.-num [input] INPUT {
    text-align: center;
}

.<?=$nF?>.-num2 [input] {
    width: 50px;
}
.<?=$nF?>.-num2 [input] INPUT {
    text-align: center;
}

.<?=$nF?>.-short [input] {
    width: 110px;
}


.<?=$nF?>.-station [input] {
    width: 125px;
}

.<?=$nF?>.-datetime [input] {
    width: 150px;
}
.<?=$nF?>.-datetime [input] INPUT {
    text-align: center;
}


.<?=$nF?> [input]:after {
    content: '';
    position: absolute;
    left: 0; right: 0; bottom: 0;
    height: 3px;
    background-color: <?=_cssKot('blue-grey')?>;
    <?=pcss('transition', "opacity $trq")?>

    opacity: 0;
}
.<?=$nF?>.-focus [input]:after {
    opacity: 1;
}


.<?=$nF?> INPUT {
    caret-color: <?=_cssKot('warn-border')?>;
    width: 100%;
}

.<?=$nF?> [checkbox] {
    min-width: 20px;
    /*vertical-align: middle;
    text-align: center;*/
    margin-left: 15px;
}

.<?=$nF?> [checkbox] INPUT {
    position: relative;
    left: -4px;
}

    <?//                    warn                      ?>

.<?=$nF?>.-warn [input] {
    border-color: <?=_cssKot('warn-border')?>;
}
.<?=$nF?>.-warn [input]:after {
    background-color: <?=_cssKot('warn-border')?>;
}


<?//                    No-FIELD                      ?>
.<?=$nNF?>-value {
    margin-left: 10px;
}

<?//                    FORECAST-FIELD                      ?>
.<?=$nFF?>-button {
    margin-right: 10px;
}


<?//                    BLANK-FIELD                      ?>

.<?=$nTF?> {
    width: 100%;
    padding-top: 10px;
    padding-bottom: 5px;
}
.<?=$nTF?>-label {
    margin-right: 12px;
}
.<?=$nTF?>-input {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid <?=_cssKot('field-border')?>;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
}

<?//                    SELECT-TIME-PRESET                      ?>

.<?=$nSTP?> {
    width: 100%;
}
.<?=$nSTP?> .<?=$nF?> [input] {
    width: 185px;
}

.<?=$nSTP?>.-disabled {}

.<?=$nSTP?>-dates {
    margin-left: 5px;
    margin-right: 5px;
}
.<?=$nSTP?>-dates:before {
    content: '('
}
.<?=$nSTP?>-dates:after {
    content: ')'
}
.<?=$nSTP?>-dates > SPAN {
    margin-right: 4px;
}
.<?=$nSTP?>-dates .-first {
    margin-left: 2px;
}
.<?=$nSTP?>-dates .-last {
    margin-right: 2px;
}

<?//                    MULTI-SELECT                    ?>

.<?=$nMS?>-values {
    padding-top: 10px;
}
.<?=$nMS?>-value {
    margin-right: 25px;
}

<?//                    SELECT-STATION                    ?>

.<?=$nSSs?>-sep {
    height: 6px;
}
.<?=$nSS?>-add {
    margin-left: 15px;
}

<?//                table-handler               ?>

.<?=$nTH?> * {
    color: rgba(0, 0, 0, 0.26);
}

.<?=$nTH?> > SPAN,
.<?=$nTH?>-inf > SPAN,
.<?=$nTH?> .material-icons {
    vertical-align: middle;
}

.<?=$nTH?> > * {
    margin-left: 3px;
}

.<?=$nTH?>-cell-select {
    padding-left: 5px;
    padding-right: 10px;
}
.<?=$nTH?>-cell-select LABEL {
    margin-right: 2px;
}


.<?=$nTH?>-inf {
    margin-right: 3px;
}

.<?=$nTH?>-inf > SPAN {
    padding: 0 1px;
}

<?//                table-handler/ui-busy           ?>
.<?=$nTH?>-busy {
    margin-right: 10px;
}
<?
    $By_s = 15;
    $By_sI = 20;
    $By_oI = ceil(($By_sI - $By_s) / 2);
    $By_m = 4;
    $By_bs = 3;
    $By_bc = '#d3d3d3';
?>
.<?=$nTH?> .<?=$nBy?> {
    width: <?=$By_s?>px;
    height: <?=$By_s?>px;
}
.<?=$nTH?> .<?=$nBy?>[left] {
    margin-right: <?=$By_oI + $By_m?>px;
}
.<?=$nTH?> .<?=$nBy?>-icon {
    top: -<?=$By_oI?>px;
    left: -<?=$By_oI?>px;
    width: <?=$By_sI?>px;
    height: <?=$By_sI?>px;
    border-width: <?=$By_bs?>px;
    border-color: <?=$By_bc?>;
}
<?//                                                         ?>


@media (max-width: <?=_mq(2)?>px) {}