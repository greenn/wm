<?
    $Self = _kot::self()
?>
_vue('side-head', function(_log, _cmd){

    return {
        _vue: {
            provide: [
                'link', 'linkTitul',
            ],
        },

        emits: ['toggle-click'],

        data(){
            //_log('data');
            return {}
        },

        methods: {
            toggleButton: function(){
                this.$emit('toggle-click')
                //this.$parent.toggleSide();
                //rc('app', 'toggleSide');
            }
        },

        mounted(){
            //_log('mounted')
        },
    }
})