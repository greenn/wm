<?
$Self = _kot::self();
$nT3 = $Self::nc('T3');
$nT3F = $Self::nc('T3F'); //tpl3-field
?>
<span fxr fxi="b" class="<?=$nT3?>">
    <span class="-label" v-if="label">{{ label }}</span>
    <template v-if="valueFix">
        <b class="<?=$nT3?>-val -fix">{{ value }}</b>
    </template>
    <template v-else>
        <b class="<?=$nT3?>-val -nofix"><?=_pro('tpl3-nofix')?></b>
    </template>
</span>