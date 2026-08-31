<div>
    <input :value="value" @input="$emit('update:value', $event.target.value)" />
</div>