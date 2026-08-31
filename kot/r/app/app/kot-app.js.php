<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp(
	'headers'//,
    //'dirUrl'
);
$Self = _kot::self();
$n = $Self::nc();

$baseUri = gt('base', '/');

if(0) headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra($baseUri),
	__FILE__
), SITE_CACHE);

//$Self::req_js(1, 'app-env');


############# content
//$Self::req_vue('error/http-403', array(), 'http-403');
$Self::vue_req('http-403', 'error/http-403');
$Self::vue_req('http-404', 'error/http-404');




_kot::req_vue('app-titul', 'titul-test', array(), 'titul-test');


//Bad? _kot::req_vue(-1, 'admin-r', 'admin-r-root');
_kot::req_vue(-1, 'admin-r', array(), 'admin-r-root');
//_kot::req_vue(-1, 'admin-pages', 'admin-pages-root');

//подгрузка модулей на страницу
//_kmod::req_vue(-1, 'site-menu', 'site-menu', array(), 'site-menu');
_kmod::req_vue(-1, 'site-menu');
_kmod::req_vue(-1, 'company-titul');
_kmod::req_vue(-1, 'blank');
_kmod::req_vue(-1, 'body-bg');
_kmod::req_vue(-1, 'site-logo');

_kmod::req_vue(-1, 'guzzler');
_kmod::req_vue(-1, 'catalog');



############# /content
?>
_aKot.vue.init({
    mount: true,

    use: {
        'vuetify': Vuetify.createVuetify(), <?// tooltip ?>
        //'vue-material': VueMaterial
    },


    decl: function(_log){
        return {
            _vue: {
                provide: [
                    'link'
                ],
            },

            data(){
                return {
                    iqs: {},
                    busy: false,
                    appBusy: true,

                    minSide: false,
                    pageTitle: '…',
                    pageSubTitle: '',
                    access_token: '',
                }
            },

            methods: {
                iq: function(cmptName, state){
                    this.iqs[cmptName] = state === undefined ? true : state;
                },

                checkContentHeight: function(){

                    var $body = $('BODY');
                    var $html = $('HTML');

                    var contentNode = $('.<?=$n?>-main')[0];

                    var contentHeight = contentNode.scrollHeight;
                    var windowHeight = window.innerHeight;

                    if (1) _log('checkContentHeight', windowHeight, [
                        contentHeight,
                        contentNode.scrollHeight,
                        contentNode.clientHeight,
                        contentNode.offsetHeight
                    ])

                    if (contentHeight > windowHeight) {
                        $html.addClass('h-overflow');
                        $body.addClass('h-overflow');
                    } else {
                        $html.removeClass('h-overflow');
                        $body.removeClass('h-overflow');
                    }
                }
            },

            computed: {
                ncApp: function(){
                    return {
                        '-min': this.minSide,
                    }
                },
                isLogined(){
                    return this.access_token;
                }
            },
            //watch: {},


            mounted(){
                //window.onload = this.checkContentHeight;
                //window.onresize = this.checkContentHeight;

                var self = this;
                BusKot.on('AccessToken', function(token){
                    self.access_token = token;
                });

                ApiKot.get('app/access-token', {}, function(responseData){
                    self.access_token = responseData.access_token;
                    //_log('mounted/access', { response, access_token: self.access_token });
                    self.appBusy = false;
                }, { emu: true })


            }

        }
    },

    router: {
        nohashRouter: true,
        baseUri: '<?=urldecode($baseUri)?>',
    },

    routes: function(App){
        var E404 = this.getDecl('http-404');
        var E403 = this.getDecl('http-403');
        //var Titul = this.getDecl('titul');
        var Titul = this.getDecl('titul-test');
        //_log('routes', { Titul });
        var self = this;

        var baseRoutes = [
            { path: '/logout', component: {
                template: '',
                beforeRouteEnter(to, from, next) {
                    ApiKot.post('login/logout', {}, function(responseData){
                        _log('logout/response', { 'self.router': self.router, self });
                        BusKot.emit('AccessToken', responseData.access_token);
                        self.Router.push('/');
                    }, { emu: true })
                    next();
                },
            }},
            { path: '/', component: Titul, name: 'titul', meta: { pageTitle: 'Титульная', clearOutput: true } },
            { path: '/:page(.*)*', component: E403, name: '403', meta: { pageTitle: 'HTTP 403 Forbidden' } },
            { path: '/:page(.*)*', component: E404, name: '404', meta: { pageTitle: 'HTTP 404 Not Found' } },
        ];

        return baseRoutes;

        <?/*
        //возможно ручная переработка внутренних путей
        return function routesRehandler(cmptRoutes){
            return baseRoutes.concat(cmptRoutes); //same way
            //_log('app/routes/rehandler', { root: this, App, baseRoutes, cmptRoutes })
        };
        */?>
    },

    afterMount: function($App){ //$App ~ смонтированное vue-приложение
        //this = _aKot.root (VueRoot.root)

        this.Router.beforeEach(function (newRoute, prevRoute, next) {
            //_log('~route', { newRoute, prevRoute });

            if (newRoute.meta) {
                var pageTitle = newRoute.meta.pageTitle;
                var pageSubTitle = newRoute.meta.pageSubTitle;
                var contentTitle = newRoute.meta.contentTitle || pageTitle;
                //_log('app/pageTitle', { title: newRoute.meta.pageTitle, pageSubTitle, pageSubTitleType: typeof pageSubTitle });

                WebKot.pageTitle(pageTitle)
                $App.pageTitle = contentTitle;
                $App.pageSubTitle = typeof pageSubTitle === 'function' ? pageSubTitle(newRoute) : pageSubTitle;
            }

            if (_aKot.routerDelay) {
                $App.busy = true;
                _delay(_aKot.routerDelay, function(){
                    $App.busy = false;
                    next();
                }, this)
            } else {
                next();
            }

        });
    }

});