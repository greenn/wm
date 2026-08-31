<?
$vueName = basename(__FILE__, '.vue.js.inc');
$Self = _kot::self();
$n = $Self::nc();
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            provide: [
                //'link', 'linkBack',
            ],
        },

        data(){
            //_log('data');
            return {
                target1: {
                    'list': '',
                    'name': 'card/card-factor'
                },

                target2: {
                    'list': '',
                    'name': 'card/card-factor'

                }
            }
        },

        methods: {

            update(targetProp, data){
                this[targetProp] = data;
            },

        },

        mounted(){
            //var target1 = this.$refs.target1;
            //_log('mounted', { target1: target1, 'target1.validate': target1.validate })
        },
    }
})