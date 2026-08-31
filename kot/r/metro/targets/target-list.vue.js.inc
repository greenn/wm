<?
$Self = _kot::self();
?>
_vue('target-list', function(_log, _cmd){

    return {
        _vue: {
            provide: [
                { 'linkRel': '<?=_kot::namedUrl('trg')?>' },
            ],

        },

        data(){
            //_r('app', 'iq1', 'targets');
            _r('app', 'iq', 'targets');

            return {
                busy: false,
                //forecastBusy: false,
            }
        },

        computed: {
            list() {
                //return _Targets.state.list; // Получение списка из хранилища
                return _Targets.getters.getList;
            }
        },

        watch: {
            list(list) {
                //_log('w:list', { list })
            }
        },

        methods: {

                onDelete: function(item){
                    _log('onDelete33', { item });
                    _Targets.dispatch('listRemove', {
                        item: item,
                        busy: [this, 'busy']
                    });
                },


            calcCoverage(){
                var Table = this.$refs.Table;
                var id_list = _.map(this.list, 'uid');
                _r('targets', 'calcCoverage_batch', id_list, {
                    busy: [Table, 'forecastBusy'],
                    //next: function(){}
                })
            }
        },

        mounted(){
            var self = this;

            //_log('mounted > listLoad');

            _Targets.dispatch('listLoad', {
                //busy: function(state){ self.busy = state }
                busy: [this.$refs.Table]
            });

            //_log('mounted', { Targets: _r.vue.getDecl('targets'), _Targets })

        },
    }
})