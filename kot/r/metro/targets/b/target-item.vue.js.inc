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
            ]
        },

        data(){
            _r('app', 'iq', 'targets');
            //_log('data');
            return {
                busy: false,
                busyCoverage: false,
                //item: @c
                    //underDelete: false,
                item: {}
            }
        },

        methods: {
            calcCoverage: function(){
                _r('targets', 'calcCoverage', this.item.uid, {
                    busy: [this, 'busyCoverage'],
                    //next: function(){}
                })

                this.$refs.targets.calcCoverage();
            },

            aproove: function(){
                var self = this;
                _log('aproove', { item: this.item });
                _r('targets', 'itemAproove_popup', this.item, {
                    busy: [self, 'busy'], //показать свою крутилку
                    next: function(response){
                        self.fetchItem(); //#K9
                    }
                });
            },

            reject: function(){
                var self = this;
                _log('reject', { item: this.item });
                _r('targets', 'itemReject_popup', this.item, {
                    busy: [self, 'busy'], //показать свою крутилку
                    next: function(response){
                        self.fetchItem(); //#K9
                    }
                });
            },

            copy: function(){
                var self = this;
                _log('copy', { item: this.item });
                _r('targets', 'itemCopy_popup', this.item, {
                    busy: [self, 'busy'], //показать свою крутилку
                    next: function(response){
                        _log('copy/response', { response });
                        self.linkRel(response.data['new-id']);
                    },
                });
            },

            remove: function(){
                var self = this;
                _log('remove', { item: this.item });
                this.underDelete = this.item.uid;
                _r('targets', 'itemRemove_popup', this.item, {
                    busy: [self, 'busy'], //показать свою крутилку
                    next: function(){
                        _log('remove/api/linkPar')
                        self.linkPar();
                        //self.underDelete = false;
                    }
                });


            },

            fetchItem: function(){

                var self = this;
                var id = this.$route.params.id;
                _log('fetchItem', { id, route: this.$route });

                <?/*
                    vuex/itemGet  kot/r/targets/targets.v2.vuex.js.php:124
                    vuex/itemLoad  kot/r/targets/targets.v2.vuex.js.php:93
                */?>
                _Targets.dispatch('itemGet', {
                    uid: id,
                    busy: [this, 'busy'],
                    next: function(item){
                        //_log('fetchItem/s:itemGet/qpr', { uid: self.$route.params.id, item})
                        if (item) { /*[pr] происходит какое-то второе срабатывание поэтому проверка */
                            item.targets = _r('targets', 'prepareItemTargets', item.targets);
                            self.item = item;

                            self.calcCoverage();
                        }
                    },
                });
            }
        },

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
            $route: function(route){
                //_log('w:route', { route })
                if (route.name === "target-item") {
                    this.fetchItem();
                }
            },
            item: function(item){
                _log('w:item', { item, _item: _cc(item) })
            }
        },

        mounted(){
            var self = this;
            //_log('mounted', { $route: this.$route, uid: this.$route.params.id })

            this.fetchItem();
        },
    }
})