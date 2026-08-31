<?
$Self = _kot::self();
//$n = $Self::nc();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            //multiInstances: true,
            provide: [],
        },

        props: [
            'label',
            'type',
        ],
        data(){
            //_log('data');
            return {
                cssClass: {},
                focus: false,
                input: '',
            }
        },

        methods: {
            shake(){
                var self = this;
                self.cssClass['shake-404'] = true;
                setTimeout(function(){
                    self.cssClass['shake-404'] = false;
                }, 600)

            }
        },

        watch: {
            //value: @provide ui/field/validate
            //?relValid: @provide ui/field/validate

            focus: function (state) {
                this.cssClass['-focus'] = state;
            },
        },

        mounted(){
            //_log('mounted')
        },
    }
})