<div fxr>
    ui-custom:
    <ui-field
        :value="value"
        @input="$emit('update:value', $event.target.value)"
        <? if (0) { ?>
            @input="$emit('update:value', $event.target.value)"
        <? } ?>
    ></ui-field>
</div>