_vue('ui-input', function(_log, _cmd){
    return {
        props: ['value', 'modelValueInput', 'modelValueCheckbox'],
        emits: ['update:value', 'update:modelValueInput', 'update:modelValueCheckbox']
        /*model: {
            prop: 'value',
            event: 'input'
        }*/
    }
})