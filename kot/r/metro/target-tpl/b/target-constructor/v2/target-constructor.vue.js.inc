<?
$vueName = basename(__FILE__, '.vue.js.inc');
$Self = _kot::self();
$n = $Self::nc();

$Self::req_vue('tpl-passes-qy'); //$Self::req_vue('tpl2-passes-qy');
$Self::req_vue('tpl-station-freq'); //$Self::req_vue('tpl2-station-freq');
$Self::req_vue('tpl-route-ngpt'); ////$Self::req_vue('tpl2-route-ngpt');
$Self::req_vue('tpl-station-mcd'); ////$Self::req_vue('tpl2-station-mcd');

//js::wreq('wait-list.jq');
js::wreq('wait-list');

?>
_vue('<?=$vueName?>', function(_log, _cmd){

    //_tplInfo

    return {
        _vue: {
            provide: [
                //'regField', 'regButton',
                //'link', 'linkBack',
                //'applyRealParentMethod', 'getRealParent',
                //'getCurrentDateTime'
            ],
        },

        emits: ['onChange', 'onDataInit'],
        //props: ['targets'],

        data(){


            //_log('data');
            return {
                list: [], //котроллеры таргетов

                tplInfo: {},
                selecter: '',
                //selecterOptions: @c,
                selecterBusy: false,
            }
        },



        methods: {

            loadSelecter(){
                var self = this;
                Api.assignData({
                    api: 'targets/tpl-info',
                    responseProp: ['data', 'list'],
                    res: [this, 'tplInfo'],
                    busy: [this, 'selecterBusy'],
                    //dbg: true,
                    cbRes: function(tplInfo){
                        _log('loadSelecter', { tplInfo })
                        //self.add_target_handler('passes-qy');
                        //self.add_target_handler('station-freq');
                        //self.add_target_handler('route-ngpt');
                        //self.add_target_handler('station-mcd');
                    }
                });

            },



            initData: function(targetsList){
                //targetsList - данные из базы
                var self = this;

                //ожидаем прогрзуки данными всех хендлеров
                var wait = makeWaitList(function(){
                    setTimeout(function(){
                        _log('initData/ready');
                        self.$emit('onDataInit')
                    }, 0)
                });

                _.each(targetsList, function(targetItem){
                    //var cfg = targetItem.cfg;
                    //var trgItem = _clone(_clearObject(targetItem));
                    var trgItem = _clearObject(targetItem);
                    var trgCfg = trgItem.cfg; //Контекст данных таргета
                    delete trgItem.cfg;

                    var waitName = wait(); //добавляем в waitList элемент ожидания (просто без имени)

                    trgItem.fetchData = function(){
                        //this ~ target-handler
                        //step: обновляем конфиг хендлера, значениями trgItem.cfg
                        _.merge(this.cfg, trgCfg, function(dataValue, cfgValue) {
                            if (_.isUndefined(cfgValue)) {
                                return dataValue;
                            }
                        });

                        _log('initData/on_mount/q', { trgCfg, trgItem, this: this, 'q/true': self.inReslist(trgItem) })
                        if (!self.inReslist(trgItem)) {
                            self.add_target(trgItem, this.cfg); //#П1-4
                        }

                        wait.resolve(waitName); //завершаем ожидание элемента
                    }

                    self.list.push(trgItem)
                })

            },

            inReslist: function(trgItem){
                //return !!_.find(this.reslist, trgItem);
                return !!_.find(this.list, function(o){
                    return o === trgItem;
                });
            },

            add_target(trgName){
                var trgInfo = this.tplInfo[trgName];
                var trgItem = _clone(trgInfo);
                _log('add_target', { trgItem })

                this.list.push(trgItem)

                this.selecter = ''; //reset selct
            },


            remove_target(trgItem){
                var index = _.findIndex(this.reslist, trgItem);
                _log('remove_target/act', { index })
                delete this.list[index];
            },

            remove_target_popup(trgItem){
                var self = this;
                _r('popup', 'content', {
                    headline: `Шаблон "${trgItem.title}"`,
                    msg: [
                        'Удалить из шаблона?',
                        'Введённые данные будут утеряны.',
                    ].join('<br />'),
                    submit: {
                        title: 'Удалить',
                        click: function(){
                            self.remove_target(trgItem)
                        }
                    }
                })
            },

        },

        watch: {
            list: {
                deep: true,
                handler: function(list){
                    _log('w:list', { list: _cc(this.list) });
                    var targetList = [];
                    _.each(list, function(targetData){
                        var target = targetData && targetData.cfg;
                        if (target) {
                            target.name = targetData.name;
                            targetList.push(target)
                        }
                    })
                    this.$emit('onChange', targetList)
                }
            }
        },

        computed: {
            selecterOptions: function(){
                //_log('c:selecterOptions', { list: _cc(this.list) });
                return _.transform(this.tplInfo, function(list, item, key){
                    if (item) {
                        list.push({ value: key, text: item.title, disabled: item.disabled  })
                    }
                    return list;
                }, [{ value: '', text: '- название темплейта -'}])
            },

        },

        mounted(){
            //_log('mounted', { _tplInfo, selecterOptions: _clearObject(this.selecterOptions) });
            this.loadSelecter()
        },
    }
})