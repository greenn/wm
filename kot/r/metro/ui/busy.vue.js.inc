<?
$Self = _kot::self()
?>
_vue('ui-busy', function(_log, _cmd){
    return {
        _vue: {
            multiInstances: true,
        },

        props: ['visible'],

        data(){
            return {}
        },

        methods: {
            //012

            on: function(state){
                this.visible = true;
            },
            off: function(state){
                this.visible = false;
            },
        },

        mounted(){
            //this._log('mounted')
        },
    }
})