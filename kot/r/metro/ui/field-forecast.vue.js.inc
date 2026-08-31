<?
$Self = _kot::self()
?>
_vue('field-forecast', function(_log, _cmd){
    return {
        _vue: {
            multiInstances: true,
            provide: [],
        },

        props: [
            'value',
            'busy',
            'label',
            'disabled',
        ],
        emits: [
            'onCalc',
        ],

        data: function(){
            return {}
        },

        methods: {},

        mounted(){
            //this._log('mounted')
        },
    }
})