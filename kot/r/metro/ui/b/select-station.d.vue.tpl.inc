<?
$Self = _kot::self();
$nSS = $Self::nc('select-station');
$Self::req_css('form');
$Self::req_vue('select', array(), 'ui-select');
?>
<div fxc>
    <div>value2: {{ value2 }}</div>
    <div>checkbox2: {{ checkbox2 }}</div>
    <ui-select
        :label="label || 'На станции'"
        :options="options"
        :busy="busy"
        :value="value"
        :checkbox="checkbox"
        @update:value="$emit('update:value', $event)"
        @update:checkbox="$emit('update:checkbox', $event)"

        <? if (0) { ?>
            :value="value2"
            :checkbox="checkbox2"
            @update:value="value2 = $event"
            @update:checkbox="checkbox2 = $event"


            @update:value="$emit('update:value2', $event)"
            @update:checkbox="$emit('update:checkbox2', $event)"


        @input="$emit('update:value', $event.target.value)"
        @change="$emit('update:checkbox', $event.target.checked)"
        <? } ?>
    ></ui-select>
</div>