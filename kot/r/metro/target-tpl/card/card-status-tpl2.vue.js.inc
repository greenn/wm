<?
$Self = _kot::self();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'))
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [
                'target-tpl2',
            ],
        },

        props: ['cfg'],
        data(){
            //_log('data');
            return {
                /*cfg: @props
                    'value': '',
                */

                info: {},
                busy: false,

                //@provide target-tpl2
                //coverage: false,
                //busyCoverage: false,
            }
        },

        computed: {

            title: function(){
                return _.get(this, ['info', this.cfg.value, 'text'], '-');
            },
        },


        watch: {
            //cfg() @provide target-tpl2 //dbg
        },

        //mounted @provide target-tpl2

        mounted(){
            var self = this;
            _r('ui', 'selectCardStatus_getOptions', {
                busy: [self, 'busy'],
                next: function(options, optionsInfo){
                    //_log('options/res', { optionsInfo })
                    self.info = optionsInfo;
                }
            })
        },

    }
})