<div fxr>
    ui-field:
    <input
        :value="value"
        @input="$emit('update:value', $event.target.value)"
        <? if (0) { ?>
            @input="$emit('update:value', $event.target.value)"
        <? } ?>
    />
</div>