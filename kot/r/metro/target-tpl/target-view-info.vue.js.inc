<?
$Self = _kot::self();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'))
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            provide: [],
        },

        props: [
            'targets',
            'targetsData',
        ],

        data(){
            return {
                alignedTargets: [],
            }
        },

        methods: {
            //oo kot/r/targets/targets.vue.js.inc::117
            alignTargets(){

                return this.targetsData ? _r('targets', 'prepareItemTargets', this.targetsData) : this.targets

                var list = [];
                _.each(this.targets, function(item){
                    //_log('alignTargets', { item: _cc(item) })
                    if (!item || !item.tpl) return;
                    if (!item.cfg && !item.initData) {
                        item = _cc(item);
                        var _item = item.tpl;
                        delete item.tpl;
                        _item.cfg = item;
                        item = _item;
                    }
                    list.push(item);
                })
                return list;
            }
        },

        watch: {
            alignedTargets(alignedTargets){
                _log('alignedTargets', { alignedTargets })
            },

            targets: {
                deep: true,
                immediate: true,
                handler: function(targets){
                    //this.alignedTargets = this.alignTargets();
                    //_log('c:targets', { targets: _cc(targets), alignedTargets: _cc(this.alignedTargets) });
                }
            },

            targetsData: {
                deep: true,
                immediate: true,
                handler: function(targets){
                    //this.alignedTargets = this.alignTargets();
                }
            },
        },

        mounted() {
            //_log('mounted', { targets: _cc(this.targets) });
        }
    }
})