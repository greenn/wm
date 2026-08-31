<?
$Self = _kot::self();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));

//$Self::req_js('targets.vue-ext');

$Self::req_vue('messagings-list');
$Self::req_vue('messagings-form');
$Self::req_vue('messagings-item');
?>

<?//oo man/vue-env vuex?>
var _Messagings = new Vuex.Store(vuexCfg({
    self: function(){ return _Messagings },
    logTitle: '_Messagings',
    actDelay: 200,
    idnProp: 'uid',
    api: {
        list: 'messagings/list',
        item: 'messagings/item',
    }
}))

_vue('<?=$vueName?>', function(_log, _cmd){

    return {

        _vue: {

            provide: [
                { 'linkRel': '<?=_kot::namedUrl('msgs')?>' },

                { 'crud': {
                    vuex: _Messagings,
                    apiBase: 'messagings',

                    methods: {
                        remove: true,
                        copy: true,
                        aproove: true,
                        reject: true,
                        ///coverage: true,
                        create: true,
                        update: true
                    }
                } }
            ],

            routes: function(App, SelfCmpt){
                var root = this;
                //_log('pro vide/routes', { root, App, SelfCmpt, RelCmpt: root.getDecl('messagings-form') })
                return [
                    {
                        name: 'messagings-list',
                        path: '<?=_kot::namedUrl('msgs')?>',
                        component: root.getDecl('messagings-list'),
                        meta: {
                            pageTitle: 'Рассылки пассажирам',
                            keepAlive: true
                        }
                    },
                    {
                        name: 'messagings-add',
                        path: '<?=_kot::namedUrl('msgs', 'add')?>',
                        component: root.getDecl('messagings-form'),
                        meta: {
                            pageTitle: 'Создание рассылки пассажирам'
                        }
                    },
                    {
                        name: 'messagings-item',
                        path: '<?=_kot::namedUrl('msgs', ":id(\\\\d+)")?>',
                        component: root.getDecl('messagings-item'),
                        meta: {
                            pageTitle: 'Рассылка пассажирам',
                            //pageTitle2: function(){ _log( this: this, args: arguments )}
                        }
                    },
                    {
                        name: 'messagings-edit',
                        path: '<?=_kot::namedUrl('msgs', ":id(\\\\d+)/edit")?>',
                        component: root.getDecl('messagings-form'),
                        meta: {
                            pageTitle: 'Изменение рассылки пассажирам',
                            //pageTitle2: function(){ _log( this: this, args: arguments )}
                        }
                    }

                ];
            },
        },

        data(){
            return {
                list: []
            }
        },

        methods: {
            <?/*
                транфсормируем даннын из базы, для использования в target-constructor
                    которые там вставяться через add_handler
                        после меняется reslist
                        дальше активирует @onChange
                        и меняется уже првяззаный fields.targets
            */?>
            //00
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
            _log('mounted');
        }
    }
})