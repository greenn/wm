<?
$Self = _kot::self();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [
                //'formatDate',
                'intervalRelValues',
            ],
        },

        //inheritAttrs: false,
        //props: ['set'],
        props: [
            'value',
            //'from', 'to',
            'busySize'
        ],

        data(){
            return {
                //from: '', to: '', //@provide intervalRelValues
                busy: false,
                info: {}
            }
        },

        methods: {
            //@provide intervalRelValues
                //intervalRelValues
                //setRelValues
        },

        computed: {
            valueTitle(){
                return _.get(this, ['info', this.value, 'title'], '-');
            },
            datesTitle(){
                return ['c', this.from, 'по', this.to, ].join(' ');
            }
        },

        watch: {
            //value @provide intervalRelValues
        },

        mounted(){
            var self = this;
            _r('ui', 'selectTimePreset_getOptions', 'date', {  //'date', 'datetime-local'
                busy: [this, 'busy'],
                next: function(options, optionsInfo){
                    //_log('loaded', { options: _cc(options), optionsInfo: _cc(optionsInfo), })
                    self.info = optionsInfo;
                    self.setRelValues();
                }
            })
        },
    }
})