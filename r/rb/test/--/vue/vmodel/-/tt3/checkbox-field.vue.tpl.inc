<div>
    <input type="checkbox" :checked="isChecked" @change="_log(11); $emit('update:checked', !isChecked)" />
</div>