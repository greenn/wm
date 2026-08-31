<?
$Self = _kot::self();
$nT = $Self::nc('tpl');
$Self::req_css('target-tpl');

$_ctx = $Self::tempCtx(array(
    //'nc' => $Self::nc('tpl') //$nT
));
//$nc = $_ctx['nc'];
?>
<field-forecast class="<?=$nT?>-forecast"
	<?//:disabled="!hasTargets"?>
    :value="coverage === false ? '-' : coverage"
    @onCalc="validate() && calcCoverage()"
    :busy="busyCoverage"
></field-forecast>
<div class="<?=$nT?>-vsep"></div>
