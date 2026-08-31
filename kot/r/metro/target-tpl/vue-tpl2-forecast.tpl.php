<?
$Self = _kot::self();
$nT2 = $Self::nc('T2');
$Self::req_css('target-tpl');

$_ctx = $Self::tempCtx(array(
    //'nc' => $Self::nc('tpl') //$nT
));
//$nc = $_ctx['nc'];
?>
<? if (0) { ?><span>coverage: {{ coverage }}</span><? } ?>
<field-forecast class="<?=$nT2?>-forecast"
	<?//:disabled="!hasTargets"?>
    :value="coverage === false ? '-' : coverage"
    @onCalc="calcCoverage"
    :busy="busyCoverage"
></field-forecast>
