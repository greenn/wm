<?
$Self = _kot::self()
?>
_vue('tpl2-checkbox', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [
                'formatDate',
            ],
        },

        //inheritAttrs: false,
        //props: ['set'],
        props: [
            'label',
            'value', 'valueFix',
            'type', 'def',
            'value0', 'nc'
        ],

        data(){
            return {}
        },

        methods: {

        },

        mounted(){
            //this._log('mounted', { props: _cc(this.$props) } )
        },
    }
})