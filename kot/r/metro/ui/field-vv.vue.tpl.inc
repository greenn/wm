<?
$Self = _kot::self();
$nF = $Self::nc('field');
$Self::req_css('form');
/*
    [**]
        если props: modelValue
        то биднить надо черех cebab-case: <ui-input v-model:model-value="fields.title"></ui-input>
*/
$Self::req_vue('tooltip', array(), 'ui-tooltip');
?>
<div fxc class="<?=$nF?>" :class="[cssClass]">
    <div fxr fxi="c">
        <div label v-if="label">
            <label :for="id">{{ label }}<template v-if="req">*</template></label>
        </div>
        <div input r>
            <input rst="input"
                ref="input"
                :id="id"
                :type="type || 'text'"
                <?//jj v-model="value" //v-model это "внешняя"(parent) фича?>
                :value="value" @input="$emit('update:value', $event.target.value)"
                @focus="focus = true"
                @blur="focus = false"
                @mouseover="hover = true"
                @mouseleave="hover = false"
                :disabled="disabled"
            />
            <ui-tooltip
                :text="msgTooltip"
                v-model:show="warnTooltip" <?/*:show="warnTooltip" @update:show="warnTooltip = $event"*/?>
                :hover="warnInput"
            ></ui-tooltip>
        </div>
    </div>
    <div fxr checkbox v-if="checkbox !== undefined">
        <span>зафиксировать</span>
        <input type="checkbox" :checked="checkbox" @change="$emit('update:checkbox', $event.target.checked)" />
    </div>

    <div msg v-if="show_msg" v-html="msg"></div><?//01?>
</div>