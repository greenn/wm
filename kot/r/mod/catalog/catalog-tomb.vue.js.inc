<?
$Self = _kmod::self();
//$n = $Self::nc();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));
?>

_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        _vue: {
            multiInstances: true,
            provide: [
                'toggleValue'
            ],
            store: [
                'viewName',
            ],
            _store: {
                nmPreffix: _aKot.nm,
                nmIndex: function(){
                    return this.$props.id
                }
            }
        },

        props: [
            'id'
        ],

        data(){
            //_log('data');
            var views = [
                { name: 'cmd' },
                { name: 'info' },
                { name: 'view' },
                { name: 'filter' },
            ];
            return {
                viewName: 'filter',
                viewsMenu: views,
                itemData: {},
                loadingData: true,
                busy: {},

                filterList: {},
                /*filterList: {
                    'collection-1': { title: '', value: '', name: 'collection-1' },
                },*/

            }
        },

        methods: {
            //@toggleValue()

            initFilters(){
                var self = this;
                ApiKMod.get('catalog/item-filters', {
                    section: 'tombs',
                    id: this.$props.id,
                }, function(responseData){
                    //_log('item-filters/api', { responseData })
                    self.filterList = responseData.list;

                })
            },


            filterSave(filterName, filterValue){

                ApiKMod.post('catalog/item-filter', {
                    section: 'tombs',
                    id: this.$props.id,
                    'name': filterName,
                    'value': filterValue,
                }, function(responseData, postData, fullResponse){
                    //_log('filterSave/res', { responseData })
                }, {
                    emu: true
                })

            },

            loadData(){
                var self = this;
                this.loadingData = true;
                ApiKMod.get('catalog/item-data', {
                    type: 'tombs',
                    id: this.$props.id,
                }, function(responseData, postData, fullResponse){
                    self.itemData = responseData.item;
                    //_log('loadData/res', { itemData: self.itemData })
                    self.loadingData = false;
                }, {
                    emu: true
                })
            },

            rebuildItem(){
                var self = this;
                self.busy.rebuild = true;
                ApiKMod.post('catalog/item-rebuild', {
                    type: 'tombs',
                    id: this.$props.id,
                }, function(responseData, postData, fullResponse){
                    _log('rebuild/res', { responseData })
                    self.itemData = responseData.item;
                    self.busy.rebuild = false;
                }, {
                    emu: true
                })
            }
        },

        computed: {
            ready(){
                return !_.isEmpty(this.itemData);
            },

            pic(){
                var uri = '<?=_i::uri('catalog/pic/prod-pic-gel.png')?>';
                if (this.ready) {
                    uri = this.itemData['pics-host'] + this.itemData.pics.h200[0];
                }
                return uri;
            },

            info(){

                var item = this.itemData;
                var pics = item.pics &&  _.keys(item.pics);
                var sizes = item.sizes &&  _.keys(item.pricelist);
                var description =  item.description && _.keys(item.description);
                var annotation = item.annotation && _.keys(item.annotation);
                var keywords = item.keywords &&  _.keys(item.keywords);
                var _3d = item._3d && _.keys(item._3d);

                return {
                    pics: pics,
                    sizes: sizes,
                    description: description,
                    annotation: annotation,
                    keywords: keywords,
                    _3d: _3d,
                };
            },
        },

        mounted(){
            //this._log('mounted', { id: this.$props.id });
            this.loadData();
            this.initFilters();
        },
    }
})