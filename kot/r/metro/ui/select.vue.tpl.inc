<?
$Self = _kot::self();
$nS = $Self::nc('select');
$Self::req_css('form');
$Self::req_vue('busy', array(), 'ui-busy');
$Self::req_vue('tooltip', array(), 'ui-tooltip');
?>
<div fxr fxi="c" class="<?=$nS?>" :class="[cssClass]">
    <div label v-if="label"><label :for="id">{{ label }}</label></div>
    <div select r>
        <select
            ref="select"
            req="true"
            :id="id"
            <?//jj v-model="selected" //v-model это "внешняя"(parent) фича?>
            :value="value" @change="$emit('update:value', $event.target.value)"
            @click="clickUpdate && $emit('update:value', $event.target.value)"
            @focus="focus = true; $emit('onFocus')"
            @blur="focus = false; $emit('onBlur')"
            @mouseover="hover = true"
            @mouseleave="hover = false"
            :multiple="multiple"
            :disabled="disabled"
        >
            <option v-for="option in optionsData"
                :value="option.value"
                :disabled="option.disabled"
                :style="option.style"
            >
                {{ option.text }}
            </option>
        </select>
        <ui-tooltip
            :text="msgWarn || msgWarnDef"
            v-model:show="warnTooltip" <?/*:show="warnTooltip" @update:show="warnTooltip = $event"*/?>
            :hover="warnInput"
        ></ui-tooltip>
    </div>
    <div checkbox v-if="checkbox !== undefined">
        <input type="checkbox" :checked="checkbox" @change="$emit('update:checkbox', $event.target.checked)" />
    </div>
    <ui-busy size="2" right :visible="busy" v-show="hideBusy ? busy : true"></ui-busy>
    <div msg v-if="show_msg" v-html="msg"></div>
</div>
