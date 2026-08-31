<?
$Self = _kot::self();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [],
        },

        props: [
            'value',
            'mcd'
        ],

        data(){
            return {
                types: {},
                typesData: {},
                busy: false,
            }
        },

        methods: {
            typeTitle(item){
                return _.get(this, ['types', item.type, 'text'], '-');
            },
            valueTitle(item){
                var options = _.get(this, ['typesData', item.type]);
                //_log('valueTitle', { _item: _cc(item), options: _cc(options) });
                return _.get(options, [item.id, 'text'], '-');
            }
        },

        mounted(){
            var self = this;
            //_log('mounted', { value: this.value });

            _r('ui', 'selectNgpt_getOptions', {
                busy: [this, 'busy'],
                next: function (options, info) {
                    //_log('load/Ngpt/res', { options, info });
                    self.types = info;
                }
            })

            _r('ui', 'selectNgptStation_getOptions', {
                busy: [this, 'busy'],
                next: function (options, info) {
                    //_log('load/NgptStation/res', { options, info });
                    self.typesData = info;
                }
            })

        },
    }
})