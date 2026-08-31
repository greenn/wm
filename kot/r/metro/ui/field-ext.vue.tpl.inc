<?
$Self = _kot::self();
$nF = $Self::nc('field');
$Self::req_css('form');
/*
    [**]
        если props: modelValue
        то биднить надо черех cebab-case: <ui-input v-model:model-value="fields.title"></ui-input>
*/
?>
<div fxr fxi="c" class="<?=$nF?>" :class="[cssClass, { '-pad': true }]">
    <div label v-if="label"><label :for="id">{{ label }}</label></div>
    <div input r><input rst="input"
        :id="id"
        :type="type || 'text'"
        <?//jj v-model="value" //v-model это "внешняя"(parent) фича?>
        :value="value" @input="$emit('update:value', $event.target.value)"
        @focus="focus = true"
        @blur="focus = false"
        @mouseover="hover = true"
        @mouseleave="hover = false"
        :disabled="disabled"
    ></div>
    <div checkbox v-if="checkbox !== undefined">
        <input type="checkbox" :checked="checkbox" @change="$emit('update:checkbox', $event.target.checked)" />
    </div>
    <div msg v-if="show_msg" v-html="msg"></div>
</div>