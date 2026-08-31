<?
$Self = _kot::self();
$nNF = $Self::nc('no-field');
$Self::req_css('form');
_kot::req_vue('ui', 'busy', array(), 'ui-busy');
?>

<div <?//fxr fxi="c"?> class="<?=$nNF?>">
    <span class="<?=$nNF?>-label">{{ label }}:</span>
    <span class="<?=$nNF?>-value" :class="[ncValue]">{{ value }}</span>
    <ui-busy size="2" right :visible="busy"></ui-busy>
</div>
