<?
$Self = _kot::self();
$nF = $Self::nc('field');
$nTF = $Self::nc('text-field'); //text-field
$Self::req_css('form');
?>
<div class="<?=$nTF?>" :class="[<?//$attrs.class,?> cssClass]"
     @mouseover="hover = true"
     @mouseleave="hover = false"
     @mousedown="mouse = true"
     @mouseup="mouse = false"
     fxr <?//="fxr !== 0"?>
     fxi="c"
>
    <div class="<?=$nTF?>-label" v-if="label"><label :for="id">{{ label }}</label></div>
    <div fg class="<?=$nTF?>-input">{{ value }}</div>
</div>