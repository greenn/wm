<?
$Self = _kot::self()
?>
_vue('ui-tooltip', function(_log, _cmd){


    return {
        _vue: {
            multiInstances: true,
            provide: [],
        },

        inheritAttrs: false,

        props: [
            'show',
            'side',
            'text',
            'hover',
            'modelValue',
        ],
        emits: [
            //'update:value', 'update:checkbox',
            //'update:modelValue',
            //'update:model-value',
            'update:show',
        ],

        data () {
            return {
                //show: false,
            }
        },

        methods: {
            updateValue(state){
                if (this.hover === false) {
                    //case: decline show the tooltip
                    if (state) return;
                }
                this.$emit('update:show', state); //передаём наверз обновление v-model:show
            }
        }

    }
})