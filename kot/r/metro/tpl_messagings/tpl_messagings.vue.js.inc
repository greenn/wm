<?
$Self = _kot::self();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));

//$Self::req_js('targets.vue-ext');

$Self::req_vue('tpl_messagings-list');
$Self::req_vue('tpl_messagings-form');
$Self::req_vue('tpl_messagings-item');
?>

<?//oo man/vue-env vuex?>
var _TtpMessagings = new Vuex.Store(vuexCfg({
    self: function(){ return _TtpMessagings },
    logTitle: '_TtpMessagings',
    actDelay: 200,
    idnProp: 'uid',
    api: {
        list: 'tpl_messagings/list',
        item: 'tpl_messagings/item',
    }
}))

_vue('<?=$vueName?>', function(_log, _cmd){

    return {

        _vue: {

            provide: [
                { 'linkRel': '<?=_kot::namedUrl('tmsgs')?>' },

                { 'crud': {
                    vuex: _TtpMessagings,
                    apiBase: 'tpl_messagings',

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
                //_log('pro vide/routes', { root, App, SelfCmpt, RelCmpt: root.getDecl('tpl_messagings-form') })
                return [
                    {
                        name: 'tpl_messagings-list',
                        path: '<?=_kot::namedUrl('tmsgs')?>',
                        component: root.getDecl('tpl_messagings-list'),
                        meta: {
                            pageTitle: 'Шаблон рассылки пассажирам',
                            keepAlive: true
                        }
                    },
                    {
                        name: 'tpl_messagings-add',
                        path: '<?=_kot::namedUrl('tmsgs', 'add')?>',
                        component: root.getDecl('tpl_messagings-form'),
                        meta: {
                            pageTitle: 'Создание шаблона рассылки пассажирам'
                        }
                    },
                    {
                        name: 'tpl_messagings-item',
                        path: '<?=_kot::namedUrl('tmsgs', ":id(\\\\d+)")?>',
                        component: root.getDecl('tpl_messagings-item'),
                        meta: {
                            pageTitle: 'Шаблона рассылки пассажирам',
                            //pageTitle2: function(){ _log( this: this, args: arguments )}
                        }
                    },
                    {
                        name: 'tpl_messagings-edit',
                        path: '<?=_kot::namedUrl('tmsgs', ":id(\\\\d+)/edit")?>',
                        component: root.getDecl('tpl_messagings-form'),
                        meta: {
                            pageTitle: 'Изменение шаблона рассылки пассажирам',
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
            //_log('mounted');
        }
    }
})