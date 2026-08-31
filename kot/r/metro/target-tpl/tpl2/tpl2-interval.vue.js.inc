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
            //'from',
            //'to',
        ],

        data(){
            return {
                from: '', to: '',
                busy: false,
                info: {},
            }
        },

        methods: {
            valueTitle(){
                return _.get(this, ['info', this.value, 'title'], '-');
            },

            //intervalRelValues @provide intervalRelValues
            //setRelValues @provide intervalRelValues
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
                    ///_log('mounted/next', { q1: self.bbb, setRelValues: self.setRelValues })
                    self.setRelValues();
                }
            })
        },
    }
})