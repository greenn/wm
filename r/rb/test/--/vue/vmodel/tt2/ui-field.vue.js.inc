_vue('ui-field', function(_log, _cmd){
    return {
        props: ['value'],
        emits: ['update:value'],
        //props: ['value', 'modelValueInput', 'modelValueCheckbox'],
        //emits: ['update:value', 'update:modelValueInput', 'update:modelValueCheckbox']

    }
})