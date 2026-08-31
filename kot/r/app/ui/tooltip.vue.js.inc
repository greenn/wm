<?
$Self = _kot::self();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));
?>
_vue('<?=$vueName?>', function(_log, _cmd){


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