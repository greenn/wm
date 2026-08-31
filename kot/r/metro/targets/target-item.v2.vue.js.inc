<?
$Self = _kot::self();
?>
_vue('target-item', function(_log, _cmd){

    return {
        _vue: {
            provide: [
                //'regField', 'regButton',
                'linkPar',
                { 'linkRel': '<?=_kot::namedUrl('trg')?>' },
                //'applyRealParentMethod', 'getRealParent', 'applyParentMethod'

                { 'crud-item': {
                    vuex: _Targets,
                    rName: 'targets',
                    routeName: 'target-item',

                    methods: {
                        calcCoverage: {
                            after: function(){
                                this.$refs.targets.calcCoverage();
                            }
                        },
                        aproove: true,
                        reject: true,
                        copy: true,
                        remove: {
                            before: function(){
                                this.underDelete = this.item.uid;
                            },
                            next: function(){
                                //this.underDelete = false;
                                this.linkPar();
                            },
                        },
                        fetchItem: {
                            next: function(item){
                                //_log('fetchItem/s:itemGet/qpr', { uid: this.$route.params.id, item})
                                if (item) { /*[pr] происходит какое-то второе срабатывание поэтому проверка */
                                    item.targets = _r('targets', 'prepareItemTargets', item.targets);
                                    this.item = item;

                                    this.calcCoverage();
                                }
                            }
                        },
                    },

                } }

            ]
        },

        data(){
            //_r('app', 'iq', 'targets');
            //_log('data');
            return {
                busy: false,
                busyCoverage: false,
                //underDelete: false,
                item: {}
            }
        },

        methods: {},

        computed: {
            //3
            <? if (0) { ?>
            item: function(){
                var uid = this.$route.params.id;
                var underDelete = uid === this.underDelete; //#K2
                _log('c:item/getItem', { uid: uid, params: this.$route.params, busy: this.busy, underDelete: [underDelete, this.underDelete, uid] })

                if (uid && !underDelete) {
                //if (uid && !underDelete) {

                    /*#K2 pr-case после удаление _Targets-триггер срабатывает
                        и происходит повторный getItem
                        с уже удалённм id, и вылазит ошибка API - не такого элемента

                    */
                    var data = _Targets.getters.getItem(uid);
                    this.busy = !data;
                }
                //_log('c:List', { data })
                return data || {};
            }
	        <? } ?>
        },

        watch: {
            item: function(item){
                //_log('w:item', { item, _item: _cc(item) })
            }
        },

        mounted(){
            _rr.saveComponent('target-item', this);
            //_log('mounted.v2', { $route: this.$route, uid: this.$route.params.id })
        },
    }
})