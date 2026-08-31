<?
$Self = _kot::self();
$nT2 = $Self::nc('tpl3');
$nPQ = $Self::nc('PQ'); //passes-qy
//$Self::req_css('target-tpl');

?>
<div fxr fxw fxi="b" class="<?=$nT3?>" :name1="name1">
    <span>Проходы более</span>
    <?=$Self::tpl('tpl2-field', array('cfg' => 'passes_min', 'nc' => '-num2'))?>
    <span>в период от</span>
	<?=$Self::tpl('tpl2-field', array('cfg' => 'from', 'type' => 'datetime-local', 'nc' => '-datetime'))?>
    <span>до</span>
	<?=$Self::tpl('tpl2-field', array('cfg' => 'to', 'type' => 'datetime-local', 'nc' => '-datetime'))?>
</div>