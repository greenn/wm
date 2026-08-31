<?
$Self = _kot::self();
$nC = $Self::nc('checkbox');
$Self::req_css('form');
$Self::req_vue('tooltip', array(), 'ui-tooltip');
?>
<div fxr fxi="c" class="<?=$nC?>"
    :class="[cssClass]"
    @mouseover="hover = true"
    @mouseleave="hover = false"
>
    <span checkbox>
        <input type="checkbox"
            ref="checkbox"
            :id="id"
            :disabled="disabled"
            :checked="value"
            @change="$emit('update:value', $event.target.checked)"
            <?//:value="value" @input="$emit('update:value', $event.target.value)"?>
            @focus="focus = true"
            @blur="focus = false"
        />
        <ui-tooltip
            :text="msgTooltip"
            v-model:show="warnTooltip" <?/*:show="warnTooltip" @update:show="warnTooltip = $event"*/?>
            :hover="warnInput"
        ></ui-tooltip>
    </span>

    <label v-if="label" :for="id">{{ label }}<template v-if="req">*</template></label>
</div>