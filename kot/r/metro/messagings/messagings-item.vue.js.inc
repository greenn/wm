<?
$Self = _kot::self();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            provide: [
                'linkPar',

                { 'linkRel': '<?=_kot::namedUrl('msgs')?>' },

                { 'crud-item': {
                    vuex: _Messagings,
                    rName: 'messagings',
                    routeName: 'messagings-item',

                    methods: {
                        aproove: true,
                        reject: true,
                        copy: true,
                        remove: true,
                        fetchItem: {
                            next: function(item){
                                //_log('fetchItem/s:itemGet/qpr', { uid: this.$route.params.id, item})
                                if (item) { /*[pr] происходит какое-то второе срабатывание поэтому проверка */
                                    this.item = item;
                                }
                            }
                        },
                    },

                } }

            ]
        },

        data(){
            return {
                busy: false,
                item: {}
            }
        },

        methods: {},

        watch: {
            item: function(item){
                //_log('w:item', { item, _item: _cc(item) })
            }
        },

        mounted(){
            _rr.saveComponent('messagings-item', this);
            //_log('mounted.v2', { $route: this.$route, uid: this.$route.params.id })
        },
    }
})