<?
$Self = _kot::self();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            provide: [
                { 'linkRel': '<?=_kot::namedUrl('tmsgs')?>' },
            ],

        },

        data(){
            //_r('app', 'iq', 'tpl_messagings');

            return {
                busy: false,
            }
        },

        computed: {
            list() { // Получение списка из хранилища
                return _TtpMessagings.getters.getList;
                //return _TtpMessagings.state.list;
            }
        },

        watch: {
            list(list) {
                //_log('w:list', { list })
            }
        },

        methods: {

            /*
            calcCoverage(){
                var Table = this.$refs.Table;
                var id_list = _.map(this.list, 'uid');
                _r('tpl_messagings', 'calcCoverage_batch', id_list, {
                    busy: [Table, 'forecastBusy'],
                    //next: function(){}
                })
            }
            */

        },

        mounted(){
            var self = this;

            //_log('mounted > listLoad');

            _TtpMessagings.dispatch('listLoad', {
                //busy: function(state){ self.busy = state }
                busy: [this.$refs.Table]
            });

            //_log('mounted', { Messagings: _r.vue.getDecl('tpl_messagings'), _TtpMessagings })
        },
    }
})