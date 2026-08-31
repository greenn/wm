<?
$Self = _kot::self();
$js =  array();

$Self::req_js('ui.vue-ext');
?>


_vue('ui', function(_log, _cmd){

    return {
        template: ' ',

        _vue: {
            provide: [
                //{ 'app-ext': {} }
            ],
        },

        data(){
            return {

            }
        },

        methods: {

        },


        mounted() {
            //_log('mounted');
        }
    }
})