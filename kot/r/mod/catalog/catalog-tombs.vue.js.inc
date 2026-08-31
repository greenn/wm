<?
$Self = _kmod::self();
$Catalog = _site::name('catalog');

//$n = $Self::nc();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));
?>

_vue('<?=$vueName?>', function(_log, _cmd){

    var nSkip = []; //::opt('listOfSkippedId'
    return {
        _vue: {
            store: [
                'n',
                'filters'
            ],
            _store: {
                //reset: ['n']
                //reset: ['filters']
            },
        },

        data(){
            //_log('data');
            
            var nData = {
                min: 1,
                max: 532,
                start: 1,
                cur: 10,
                plus: 10,
                only: '',
                onlyLock: '',
                //plusTitle: _.sample(['Добавить', 'Загрузить', 'Ещё']),
            };
              
            
            return {
                busy: {},
                n: nData,

                filters: {},
                viewNames: ['cmd', 'info', 'view', 'filter'],
            }
        },

        /*
            $refs: {
                list: []
            }
        */

        methods: {
            nAdd(){
                var newCur = this.n.cur + this.n.plus;
                //_log('n.add', { newCur, plus: this.n.plus });
                if (newCur >= this.n.max) newCur = this.n.max;
                if (newCur < this.n.min) newCur = this.n.min;
                this.n.cur = newCur;
            },
            
            updateAll(){
                var self = this;
                _.each(this.nList, function(num){
                    var Item = self.$refs[`item-${num}`];
                    //_log(`/updateAll/${num}`, { Item: _cc(Item) })
                    Item.rebuildItem();
                })
            },

            initFilters(){
                var self = this;
                ApiKMod.get('catalog/item-filters', {
                    section: 'tombs'
                }, function(responseData){
                    //_log('item-filters/api', { responseData })
                    self.filters = _.each(responseData.list, function(item){
                        item.value = true;
                    });
                })
            },

            setFilter(name, value){
                _log('setFilter', { name, value, items: _cc(this.nList) });
                var self = this;
                _.each(this.nList, function(num){
                    var Item = self.$refs[`item-${num}`];
                    //_log(`/updateAll/${num}`, { Item: _cc(Item) })
                    Item.filterList[name].value = value;
                    Item.filterSave(name, value);
                })
            },

            setView(viewName) {
                this.nList.forEach(num => {
                    const Item = this.$refs[`item-${num}`];
                    Item.viewName = viewName;
                });
            }

        },

        computed: {
            nList() {
                let range = [];
                if (this.n.onlyLock) {
                    var val = this.n.only;
                    _log('onlyLock', { val })
                    if (typeof val === 'string') {
                        var vals =  this.n.only.match(/\d+/g);
                        //let numbers = vals.map(Number);
                        //range.push(...numbers);
                        range = vals.map(Number)
                    } else {
                        range.push(val)
                    }
                } else {
                    if (this.n.start < this.n.min) this.n.start = this.n.min;
                    if (this.n.cur > this.n.max) this.n.cur = this.n.max;
                    _log('nList', { n: _cc(this.n) });

                    for (let i = this.n.start; i <= this.n.cur; i++) {
                        if (nSkip.indexOf(i) === -1) {
                            range.push(i);
                        }
                    }
                }

                this.$nextTick(() => { // Появление обновленных $ref-ссылок
                    //this._log('nList', { range, $refs: _cc(this.$refs) })
                });

                return range;
            }
        },

        mounted(){
            //_log('mounted')

            this.initFilters();
        },
    }
})