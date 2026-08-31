<?
$Self = _kmod::self();
$selfUri = kot('hp', 'namedUrl', 'company-titul');

$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));

_kmod::req_vue('company-titul', 'edit', array(), 'company-titul-editor');
_kmod::req_vue('company-titul', 'cmd', array(), 'company-titul-editor-cmd');


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

                return [
                    {
                        name: 'company-titul', //route-name
                        path: '<?=$selfUri?>',
                        components: {
                            default: root.getDecl('company-titul-editor'),
                            cmd: root.getDecl('company-titul-editor-cmd'),
                        },
                        meta: {
                            pageTitle: 'О компани',
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