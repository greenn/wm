<?
$Self = _kmod::self();
$selfPid = 'guzzler';
$selfUri = kot('hp', 'namedUrl', $selfPid);

$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));

//_kmod::req_vue('blank', 'mod', array(), 'blank-cmd');
$Self::req_vue('main', array(), 'guzzler-main');

?>

_vue('<?=$vueName?>', function(_log, _cmd){

    return {
        template: ' ',

        _vue: {
            //multiInstances: true,
            provide: [],

            routes: function(App, SelfCmpt){
                var root = this;
                //_log('routes set');
                //_log('pro vide/routes', { root, App, SelfCmpt, RelCmpt: root.getDecl('target-form') })
                return [

                    {
                        name: '<?=$selfPid?>', //route-name
                        path: '<?=$selfUri?>/:page(.*)*',
                        components: {
                            default: root.getDecl('guzzler-main'), //vue-tag
                            //cmd: root.getDecl('site-menu-cmd'), //vue-tag
                        },
                        meta: {
                            baseUrl: '<?=$selfUri?>',
                            pageTitle: 'Guzzler',
                            //pageSubTitle: 'Поедатель данных',
                            pageSubTitle: function(route){
                                var subTitle = 'Поедатель данных';
                                //_log('pageSubTitle', { route })
                                var pageName = route.params.page;

                                return pageName ? `${subTitle} / ${pageName}` : subTitle;
                            },
                            keepAlive: true
                        }
                    },

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