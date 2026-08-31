<?
$Self = _kmod::self();
$selfPid = 'blank';
$selfUri = kot('hp', 'namedUrl', $selfPid);

$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));

//_kmod::req_vue('blank', 'mod', array(), 'blank-cmd');
$Self::req_vue('main', array(), 'blank-main');

?>

/*
var _SiteMenu = new Vuex.Store(vuexCfg({
    self: function(){ return _SiteMenu },
    logTitle: '_SiteMenu',
    actDelay: 200,
    idnProp: 'uid',
    api: {
        list: 'targets/list',
        item: 'targets/item',
    }
}))
*/

_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        template: ' ',

        _vue: {
            //multiInstances: true,
            provide: [
                ///{ 'linkRel': '<?=$selfUri//kot('hp', 'namedUrl', 'site-menu')?>' }

                /*{ 'crud': {
                    vuex: _Targets,
                    apiBase: 'targets',

                    methods: {
                        remove: true,
                        copy: true,
                        aproove: true,
                        reject: true,
                        coverage: true,
                        create: true,
                        update: true
                    }
                } }*/

            ],

            routes: function(App, SelfCmpt){
                var root = this;
                //_log('routes set');
                //_log('pro vide/routes', { root, App, SelfCmpt, RelCmpt: root.getDecl('target-form') })
                return [

                    {
                        name: '<?=$selfPid?>', //route-name
                        path: '<?=$selfUri?>/:page(.*)*',
                        components: {
                            default: root.getDecl('blank-main'), //vue-tag
                            //cmd: root.getDecl('site-menu-cmd'), //vue-tag
                        },
                        meta: {
                            baseUrl: '<?=$selfUri?>',
                            pageTitle: 'Blank KMod',
                            keepAlive: true
                        }
                    },

                    <? if (0) { ?>

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
	                <? } ?>

                ];
            },
        },

        data(){
            //_log('data');
            return {}
        },

        methods: {},

        mounted(){
            _log('mounted')
        },
    }
})