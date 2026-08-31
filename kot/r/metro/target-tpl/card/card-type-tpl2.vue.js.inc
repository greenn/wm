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
                    'list': '',
                */

                info: {},
                busy: false,

                //@provide target-tpl2
                //coverage: false,
                //busyCoverage: false,
            }
        },

        methods: {
            //calcCoverage() @provide target-tpl2

            loadInfo(){
                var self = this;
                _r('ui', 'selectCardType_getOptions', {
                    busy: [self, 'busy'],
                    next: function(options, optionsInfo){
                        //_log('loadData', { options, optionsInfo })
                        self.info = optionsInfo;
                    }
                })
            }
        },

        watch: {
            //cfg() @provide target-tpl2 //dbg
        },

        //mounted @provide target-tpl2

        mounted(){
            this.loadInfo();
        },

    }
})