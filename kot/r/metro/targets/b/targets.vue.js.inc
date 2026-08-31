<?
$Self = _kot::self();
//$Self::req_js('targets.v1.vuex');
//$Self::req_js('targets.v2.vuex');
$Self::req_js('targets.vue-ext');

$Self::req_vue('target-list');
$Self::req_vue('target-form');
$Self::req_vue('target-item');
//$Self::req_vue('target-edit');

$js =  array();
$js['create'] = $Self::path('apis/create.js.inc');
$js['update'] = $Self::path('apis/update.js.inc');
$js['remove'] = $Self::path('apis/remove.js.inc');
$js['copy'] = $Self::path('apis/copy.js.inc');
$js['aproove'] = $Self::path('apis/aproove.js.inc');
$js['reject'] = $Self::path('apis/reject.js.inc');
$js['coverage'] = $Self::path('apis/coverage.js.inc');

?>

<?//oo man/vue-env vuex?>
var _Targets = new Vuex.Store(vuexCfg({
    self: function(){ return _Targets },
    logTitle: '_Targets',
    actDelay: 200,
    idnProp: 'uid',
    api: {
        list: 'targets/list',
        item: 'targets/item',
    }
}))

_vue('targets', function(_log, _cmd){

    return {
        template: ' ',

        _vue: {
            routes: function(App, SelfCmpt){
                var root = this;
                //_log('pro vide/routes', { root, App, SelfCmpt, RelCmpt: root.getDecl('target-form') })
                return [
                    {
                        name: 'target-list',
                        path: '<?=_kot::namedUrl('trg')?>',
                        component: root.getDecl('target-list'),
                        meta: {
                            pageTitle: 'Шаблоны таргетов',
                            keepAlive: true
                        }
                    },
                    {
                        name: 'target-add',
                        path: '<?=_kot::namedUrl('trg', 'add')?>',
                        component: root.getDecl('target-form'),
                        meta: {
                            pageTitle: 'Создание шаблона таргета'
                        }
                    },
                    {
                        name: 'target-item',
                        path: '<?=_kot::namedUrl('trg', ":id(\\\\d+)")?>',
                        component: root.getDecl('target-item'),
                        meta: {
                            pageTitle: 'Шаблон таргета',
                            //pageTitle2: function(){ _log( this: this, args: arguments )}
                        }
                    },
                    {
                        name: 'target-edit',
                        path: '<?=_kot::namedUrl('trg', ":id(\\\\d+)/edit")?>',
                        component: root.getDecl('target-form'),
                        meta: {
                            pageTitle: 'Изменение шаблона таргета',
                            //pageTitle2: function(){ _log( this: this, args: arguments )}
                        }
                    }

                ];
            },

            provide: [
                { 'linkRel': '<?=_kot::namedUrl('trg')?>' },
            ],
        },

        data(){
            //_log('data');
            //_log('data-0')
            return {
                list: []
            }
        },

        computed: {
            list2() {
                return _Targets.state.list; // Получение списка из хранилища
            },
            list3() {
                return _Targets.getters.getList;
            }
        },

        methods: {

            <? include $js['remove']; //itemRemove_popup(), itemRemove() ?>

            <? include $js['copy'] //itemCopy_popup(), itemCopy() ?>

            <? include $js['aproove'] //itemAproove_popup(), itemAproove() ?>

            <? include $js['reject'] //itemReject_popup(), itemReject() ?>

            <? include $js['coverage'] //calcCoverage(), calcCoverage_batch() ?>

            <? include $js['create'] //itemCreate() ?>

            <? include $js['update'] //itemUpdate() ?>

            <?/*
                транфсормируем даннын из базы, для использования в target-constructor
                    которые там вставяться через add_handler
                        после меняется reslist
                        дальше активирует @onChange
                        и меняется уже првяззаный fields.targets
            */?>
            prepareItemTargets: function(targets){ //targetsApiData
                var orig_targets = _clone(targets);
                var res =  _.transform(targets, function(list, data){
                    var _item = data.tpl;
                    delete data.tpl;
                    _item.cfg = data; //#P1-8
                    list.push(_item)
                }, [])
                _log('prepareItemTargets', { targetsApiData: orig_targets, targetsResData: _clone(res) })
                return res;
            },
        },


        mounted() {
            //_Targets.dispatch('listLoad');
        }
    }
})