<?
$vueName = basename(__FILE__, '.vue.js.inc');
$Self = _kot::self();
$n = $Self::nc();


//$Self::req_vue('tpl-passes-qy'); //$Self::req_vue('tpl2-passes-qy');
//$Self::req_vue('passes/tpl-station-freq'); //$Self::req_vue('tpl2-station-freq');
//$Self::req_vue('tpl-route-ngpt'); ////$Self::req_vue('tpl2-route-ngpt');
//$Self::req_vue('tpl-station-mcd'); ////$Self::req_vue('tpl2-station-mcd');

$Self::req_vue('passes/station-freq-tpl', array(), 'tpl-passes--station-freq');
$Self::req_vue('passes/passes-qy-tpl', array(), 'tpl-passes--passes-qy');
$Self::req_vue('restore/rebalance-tpl', array(), 'tpl-restore--rebalance');
$Self::req_vue('restore/rebalance-time-tpl', array(), 'tpl-restore--rebalance-time');
$Self::req_vue('restore/rebalance-reason-tpl', array(), 'tpl-restore--rebalance-reason');
$Self::req_vue('write/balance-tpl', array(), 'tpl-write--balance');
$Self::req_vue('topup/time-tpl', array(), 'tpl-topup--time');
$Self::req_vue('topup/sum-tpl', array(), 'tpl-topup--sum');
$Self::req_vue('helpdesk/ticket-tpl', array(), 'tpl-helpdesk--ticket');
$Self::req_vue('sale/sale-tpl', array(), 'tpl-sale--sale');
$Self::req_vue('passenger/acc-tpl', array(), 'tpl-passenger--acc');
$Self::req_vue('passenger/age-tpl', array(), 'tpl-passenger--age');
$Self::req_vue('passenger/reg-tpl', array(), 'tpl-passenger--reg');
$Self::req_vue('passenger/bio-tpl', array(), 'tpl-passenger--bio');
$Self::req_vue('passenger/tech-tpl', array(), 'tpl-passenger--tech');
$Self::req_vue('message/feedback-tpl', array(), 'tpl-message--feedback');
$Self::req_vue('services/usage-tpl', array(), 'tpl-services--usage');
$Self::req_vue('place/transport-tpl', array(), 'tpl-place--transport');
$Self::req_vue('place/equipment-tpl', array(), 'tpl-place--equipment');
$Self::req_vue('place/operation-tpl', array(), 'tpl-place--operation');
$Self::req_vue('card/card-type-tpl', array(), 'tpl-card--card-type');
//$Self::req_vue('card/card-factor-tpl', array(), 'tpl-card--card-factor');
    $Self::req_vue('card-v2/card-factor-tpl', array(), 'tpl-card--card-factor');
$Self::req_vue('card/card-status-tpl', array(), 'tpl-card--card-status');
    //$Self::req_vue('card-v2/card-status-tpl', array(), 'tpl-card--card-status');
$Self::req_vue('card/pers-exist-tpl', array(), 'tpl-card--pers-exist');
$Self::req_vue('card/pers-qy-tpl', array(), 'tpl-card--pers-qy');
$Self::req_vue('card/pers-on-tpl', array(), 'tpl-card--pers-on');
$Self::req_vue('card/pers-off-tpl', array(), 'tpl-card--pers-off');
    $Self::req_vue('card-v2/ticket-type-tpl', array(), 'tpl-card--ticket-type');
    $Self::req_vue('card-v2/ticket-design-tpl', array(), 'tpl-card--ticket-design');
$Self::req_vue('passes/route-ngpt-tpl', array(), 'tpl-passes--route-ngpt');
$Self::req_vue('passes/station-mcd-tpl', array(), 'tpl-passes--station-mcd');
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

        emits: [
            'onChange',
            //'onDataInit'
        ],
        props: [
            'waitData', //флаг ожидания данных, без него не сработает onChange
            'mode',
        ],

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
                        //[ob] только при create / при edit будут проблемы

	                    <? if (gt_on('new')) { ?>
                        if (self.mode === 'create') {

                            //self.add_target('card/pers-exist', {});

                            self.add_target('card/pers-exist', { initData: { flag: true } });


                            if (0) self.add_target('passes/route-ngpt', { initData: {
                                interval: 'today',
                                list: [
                                    { "type": "1", "id": "2", "passes": "5" },
                                    { "type": "2", "id": "3", "passes": "4" }
                                ]
                            } });


                            //self.add_target('card/card-status', {});

                            /*if (1) {
                                self.add_target('card/pers-exist', {});
                                self.add_target('card/pers-qy', {});
                                self.add_target('card/pers-on', {});
                                self.add_target('card/pers-off', {});
                            }
                            self.add_target('card/ticket-type', {});
                            self.add_target('card/ticket-design', {});*/
                        }
	                    <? } ?>


	                    <? if (gt_on('one3')) { ?>
                        if (self.mode === 'create') {

                            self.add_target('passenger/tech', {});
                        }
	                    <? } ?>


                        <? if (gt_on('one2')) { ?>
                        if (self.mode === 'create') {

                            self.add_target('place/equipment', {initData: {list: ['1', '2']}});
                            self.add_target('passenger/bio', { initData: { value: '4' } });
                        }
	                    <? } ?>

                        <? if (gt_on('one')) { ?>
                        if (self.mode === 'create') {
                            self.add_target('passes/passes-qy', { initData: { qy: 10, interval: 'today' } });
                            self.add_target('place/transport', {initData: {list: ['1']}});
                            self.add_target('place/equipment', {initData: {list: ['1']}});
                            self.add_target('passenger/bio', { initData: { value: '4' } });
                        }
                        <? } ?>

                        <? if (gt_on('all')) { ?>
                        if (self.mode === 'create') {
                            self.add_target('passenger/reg', { initData: { flag: true, interval: 'today' } })
                            self.add_target('passenger/bio', { initData: { value: '4' } });
                            self.add_target('passenger/age', { initData: { numFrom: 18, numTo: 30 } });
                            self.add_target('passenger/tech', { initData: { list: ['3', '4'] } });
                            self.add_target('passenger/acc', { initData: { interval: 'today' } });

                            self.add_target('card/card-type', { initData: { list: ['1'] } });
                            self.add_target('card/card-factor', { initData: { list: ['1'] } });
                            self.add_target('card/card-status', { initData: { value: '1' } });
                            self.add_target('card/pers-exist', { initData: { flag: 1 } });
                            self.add_target('card/pers-qy', { initData: { numFrom: 2, numTo: 10 } });
                            self.add_target('card/pers-on', { initData: { interval: 'today' } });
                            self.add_target('card/pers-off', { initData: { interval: 'today' } });
                            self.add_target('card/ticket-type', { initData: { list: ['1'] } });
                            self.add_target('card/ticket-design', { initData: { list: ['2'] } });

                            self.add_target('sale/sale', { initData: { interval: 'today' } });

                            self.add_target('place/transport', { initData: { list: ['1', '2'] } });
                            self.add_target('place/equipment', { initData: { list: ['1', '2'] } });
                            self.add_target('place/operation', { initData: { list: ['437', '610'] } });

                            self.add_target('passes/passes-qy', { initData: { qy: 10, interval: 'today' } });
                            self.add_target('passes/station-freq', { initData: {
                                interval: 'today',
                                list: [
                                    { "id": "51", "passes": "5" },
                                    { "id": "180", "passes": "4" }
                                ]
                            } });
                            self.add_target('passes/route-ngpt', { initData: {
                                interval: 'today',
                                list: [
                                    { "type": "1", "id": "2", "passes": "5" },
                                    { "type": "2", "id": "3", "passes": "4" }
                                ]
                            } });
                            self.add_target('passes/station-mcd', { initData: {
                                interval: 'today',
                                list: [
                                    { "id": "1", "passes": "2" },
                                    { "id": "2", "passes": "6" }
                                ]
                            } });

                            self.add_target('restore/rebalance', { initData: { interval: 'today' } });
                            self.add_target('restore/rebalance-time', { initData: { interval: 'today' } });
                            self.add_target('restore/rebalance-reason', { initData: { flag: 1 } });

                            self.add_target('write/balance', { initData: { interval: 'today' } });

                            self.add_target('topup/time', { initData: { interval: 'today' } });
                            self.add_target('topup/sum', { initData: { numFrom: 200, numTo: 500 } });

                            self.add_target('helpdesk/ticket', { initData: { interval: 'today' } });

                            self.add_target('services/usage', { initData: { list: ['1', '2'], interval: 'today' } });

                            self.add_target('message/feedback', { initData: { interval: 'today', numFrom: 1, numTo: 10 } });

                        }
                        <? } ?>

                    }
                });

            },

            //вызвать calcCoverage у каждого таргета
            calcCoverage(){
                //_log('calcCoverage', { list: _cc(this.list) })
                _.each(this.list, function(item){
                    if (item && item.ref) item.ref.calcCoverage();
                })
            },

            initData: function(targetsList, next){
                //targetsList - данные из базы / targetsData
                var self = this;

                //ожидаем прогрзуки данными всех хендлеров
                var _wait = makeWaitList(function(){
                    setTimeout(function(){
                        //_log('initData/ready');
                        next()
                    }, 0)
                });

                _.each(targetsList, function(targetItem){
                    //var cfg = targetItem.cfg;
                    //var trgItem = _clone(_clearObject(targetItem));
                    var trgItem = _clearObject(targetItem);
                    var trgCfg = trgItem.cfg; //данные таргета / Контекст данных таргета
                    //_log('initData/target', { trgItem, trgCfg, targetItem })

                    var idWaitName = _wait(); //добавляем в waitList элемент ожидания (просто без имени, получаем idName)

                    //добавляем контроллер-таргета в список с доп. параметрами (initData)
                        //initData - фетчит данные внутри контроллера
                    self.add_target(trgItem.name, {
                        //initData: trgCfg,
                        initData: function(){
                            this.fetchData(trgCfg);
                            this.calcCoverage()
                            _wait.resolve(idWaitName); //завершаем ожидание элемента
                        }
                    });

                })

            },


            add_target(trgName, ctx){

                var trgInfo = this.tplInfo[trgName]; //getTplInfo(trgName)
                var trgItem = _.merge({}, trgInfo, ctx); //ak newItem

                //_log('add_target', { trgItem, trgName, trgInfo: _cc(trgInfo), ctx: _cc(ctx) })

                this.list.push(trgItem)

                this.selecter = ''; //reset select
            },


            remove_target(index){
                //var index = _.findIndex(this.reslist, trgItem);
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

            onTargetUpdate(index, data){
                if (!1) _log('onTargetUpdate', { index,
                    'cfg.update': _cc(data),
                    item: _cc(this.list[index])
                })
                //var res = _.merge(this.list[index], { cfg: data })
                this.list[index].cfg = _cc(data);
                //_log('targetUpdate2', { res, _res: _cc(res), item: this.list[index], _item: _cc(this.list[index]) })
            },

            validate: function(){
                var resList = [];
                var itemRes;
                var setFocus = true;
                //_log('validate/0', { list: _cc(this.list) })
                _.each(this.list, function(item, index){
                    //_log(`validate/each/${index}`, { name: item && item.name, ref: item && _cc(item.ref), id: item && item.cfg && item.cfg.id, cfg: _cc(item && item.cfg), _item: _cc(item) })
                    if (!item) return; //case: удалённый элемент
                    //_log('validate/each', { _item: _cc(item), _ref: _cc(item.ref), validate: item.ref && item.ref.validate })

                    if (item.ref.validate) {
                        itemRes = item.ref.validate(); //есть setFocus
                        if (!itemRes && setFocus) setFocus = false; //фокус уже проставился
                        resList.push(itemRes);

                    } else {
                        _log('miss validate for', { item, index } )
                    }
                })
                var res = _.every(resList);
                _log('validate', { res, resList })
                return res;
            }
        },

        watch: {
            list: {
                deep: true,
                handler: function(list){
                    //_log('w:list', { list: _cc(this.list) });
                    var targetList = [];
                    _.each(list, function(targetData){
                        var target = targetData && targetData.cfg;
                        if (target) {
                            target.name = targetData.name;
                            targetList.push(target)
                        }
                    })
                    //_log('onChange', { targetList: _cc(targetList) })
                    //return;
                    this.$emit('onChange', targetList)
                }
            }
        },

        computed: {
            selecterOptions: function(){
                //_log('c:selecterOptions', { list: _cc(this.list) });
                var cats = {};
                return _.transform(this.tplInfo, function(list, item, key){
                    if (item) { //qt
                        var catIndex = 1;
                        var catName = item.sectionTitle;

                        if (!cats[catName]) {
                            cats[catName] = catIndex++;
                            list.push({ value: `cat-${catIndex}`, text: `- ${catName} -`, disabled: true })
                        }

                        list.push({ value: key, text: item.title, disabled: item.disabled  })
                    } else {//qt-q
                        _log('selecterOptions', 'q-такое-бывает', { list, item, key })
                    }
                    return list;
                }, [{ value: '', text: '- название темплейта -'}])
            },

        },

        mounted(){
            this.loadSelecter()
        },
    }
})