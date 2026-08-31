<?
$Self = _kot::self();
$nT2 = $Self::nc('T2');
$Self::req_css('target-tpl');

$_ctx = $Self::tempCtx(array(
	'cfg' => '',
	'cfg-fix' => '',
	'type' => '',
	'nc' => '',
	'def' => '',
	'value0' => '',
));
$prop = $_ctx['cfg'];
$propFix = prop($_ctx, 'cfg-fix', "$prop-fix");

$type = $_ctx['type'];
$nc = $_ctx['nc'];
$def = $_ctx['def'];
$value0 = $_ctx['value0'];
?>
<template v-if="cfg['<?=$propFix?>']">
    <b class="<?=$nT2?>-fix">
        <? if ($type === 'datetime-local') { ?>
            {{ formatDate(cfg['<?=$prop?>'], 'D.M.Y H:i') }}
        <? } else { ?>
           * {{ cfg['<?=$prop?>']<? if ($def) {?> || '<?=$def?>'<? } ?> }}
        <? } ?>
    </b>
</template>
<template v-else>
    <? if ($type === 'select') { ?>
        <ui-field class="<?=$nc?>"
            :value="cfg['<?=$prop?>']"
            :disabled="1"
        ></ui-field>

    <? } else { ?>
        <ui-field class="<?=$nc?>"
            :value="cfg['<?=$prop?>'] || '<?=$value0?>'"
            :disabled="1"
            <? if ($type) { ?>
                :type="'<?=$type?>'"
            <? } ?>
        ></ui-field>
    <? } ?>
</template>
