<?
$Self = _kot::self();
$nI = $Self::nc('Ic');

//$Self::req_vue('tooltip', array(), 'ui-tooltip');
$Self::req_vue('tooltip');
?>
<span class="<?=$nI?>">
    <i class="material-icons">{{ name || defName }}</i>
    <? if (0) { ?>
    <tooltip v-if="tooltip_msg"
        :text="tooltip"
        v-model:show="tooltip_msg" <?/*:show="warnTooltip" @update:show="warnTooltip = $event"*/?>
        :hover="tooltip_hover"
    ></tooltip>
    <? } ?>
</span>