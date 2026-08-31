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
                'getCurrentDateTime'
            ],
        },

        emits: ['onChange', 'onDataInit'],
        //props: ['targets'],

        data(){


            //_log('data');
            return {
                list: [], //котроллеры таргетов
                reslist: [], //this.$props.targets,

                tplInfo: {},
                selecter: '',
                //selecterOptions: @c,
                busySelecter: false,
            }
        },

        computed: {
            selecterOptions: function(){
                return _.transform(this.tplInfo, function(list, item, key){
                    //list.push(_.extend({}, item, { value: key }))
                    list.push({ value: key, text: item.title, disabled: item.disabled  })
                    return list;
                }, [{ value: '', text: '- название темплейта -'}])
            }
        },

        methods: {

            reg_target_handler(){
                _log('reg_target_handler', arguments)

            },

            //убрать tpl-конфигуратор
            remove_target_handler(listItem){
                var self = this;
                var _act = function(){
                    var index = _.findIndex(self.list, listItem);
                    //self.list.splice(index, 1);
                    delete self.list[index];
                }
                _act()
            },

            add_target_handler(trgName){
                var trgInfo = _clone(this.tplInfo[trgName]);
                var trgItem = _clone(trgInfo);
                _log('add_target_handler', { trgInfo, trgItem })

                this.list.push(trgItem)

                this.selecter = '';
            },

            add_target(trgItem, trgData){
                _log('add_target', { trgItem: _cc(trgItem), trgData: _cc(trgData) });


                this.reslist.push(_.extend(trgItem, {
                    cfg: trgData,
                    saved: true
                }));

                //this.close_target(trgInfo);
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
                })

                _.each(targetsList, function(targetItem){
                    //var cfg = targetItem.cfg;
                    //var trgItem = _clone(_clearObject(targetItem));
                    var trgItem = _clearObject(targetItem);
                    var trgCfg = trgItem.cfg;
                    delete trgItem.cfg;

                    var waitName = wait(); //добавляем в waitList элемент ожидания (просто без имени)

                    trgItem.on_mount = function(){
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

                    trgItem.saved = true;
                    self.list.push(trgItem)
                })

            },

            inReslist: function(trgItem){
                //return !!_.find(this.reslist, trgItem);
                return !!_.find(this.reslist, function(o){
                    return o === trgItem;
                });
            },

            remove_target(trgItem, usePopup){
                var self = this;
                var _act = function(){
                    var index = _.findIndex(self.reslist, trgItem);
                    _log('remove_target/act', { index })
                    self.reslist.splice(index, 1);
                    //delete self.reslist[index];

                    self.remove_target_handler(trgItem)
                }

                if (usePopup) {
                    _r('popup', 'content', {
                        headline: `Шаблон "${trgItem.title}"`,
                        msg: [
                            'Удалить из шаблона?',
                            'Введённые данные будут утеряны.',
                        ].join('<br />'),
                        submit: {
                            title: 'Удалить',
                            click: _act
                        }
                    })
                } else {
                    _act()
                }
            },


        },

        watch: {
            reslist: {
                deep: true,
                handler: function(list){
                    //_log('c:reslist', { list: _cc(list) });
                    var targetList = [];
                    _.each(list, function(targetData){
                        var target = targetData.cfg;
                        target.name = targetData.name;
                        targetList.push(target)
                    })
                    this.$emit('onChange', targetList)
                }
            }
        },

        mounted(){
            //_log('mounted', { _tplInfo, selecterOptions: _clearObject(this.selecterOptions) });
            var self = this;
            Api.assignData({
                api: 'targets/tpl-info',
                responseProp: ['data', 'list'],
                res: [this, 'tplInfo'],
                busy: [this, 'busySelecter'],
                //dbg: true,
                cbRes: function(){
                    //self.add_target_handler('passes-qy');
                    //self.add_target_handler('station-freq');
                    //self.add_target_handler('route-ngpt');
                    //self.add_target_handler('station-mcd');
                }
            });

        },
    }
})