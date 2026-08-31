<?
$Self = _kot::self();
$Self::req_css('target-tpl');

$nT2 = $Self::nc('T2');
_kot::req_vue('ui', 'checkbox', array(), 'ui-checkbox');

?>
<span fxr fxi="b">
    <? if (0) { ?>
        <ui-checkbox :class="[nc]"
            :value="value"
            :label="label"
            :disabled="1"
        ></ui-checkbox>
    <? } else { ?>
        <span class="-pr">{{ label }}</span>
        <span class="-pr">—</span>
        <span class="-pr">{{ value ? 'Да' : 'Нет' }}</span>
    <? } ?>
</span>