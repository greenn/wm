<div>
	<?//<input :value="value" @input="$emit('input', $event.target.value)" />?>
    <input :value="value" @input="$emit('update:value', $event.target.value)" />
</div>