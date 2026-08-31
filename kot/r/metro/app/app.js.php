<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp(
	'headers',
    'dirUrl'
);
$Self = _kot::self();
$n = $Self::nc();

$js = array();
headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra(),
	//$js['parallax'] = $Self::path('parallax', 'js.inc'),
	__FILE__
), SITE_CACHE);

$Self::req_vue('http-403');
$Self::req_vue('titul');


//_kot::req_vue('targets', 'targets-list');


$Self::req_js('app.vue-ext');

source::req_name('vuetify');
//source::req_name('vue-material');

?>
var _log = Log.for('DBG');

const _r = VueRoot;
const _rr = _r.root;
const _rp = _r.pick;
_r.routerDelay = 100;
_r.apiDelay = 380;
_r.msgTimeout = 2500;
_r.titulRelRoute = '<?=_kot::namedUrl('clear-rn')?>';
//_r.titulRelRoute = '<?=_kot::namedUrl('trg-par')?>';
//_r.titulRelRoute = '<?=_kot::namedUrl('trg')?>';

const Api = WebApi({
    baseUri: '<?=hostUrl?>/api/kot',
    baseEmuUri: '<?=hostUrl?>/api/%method/kot',
    delay: _r.apiDelay,
    fallback: function(ctx){
        _r.vue.log('API/fail', ctx);
        _r('sys-msg', 'showError', ctx.title, ctx.msg)
    },
    onError: function(ctx){
        _r.vue.log('API/error', ctx);
        _r('sys-msg', 'showError', ctx.title, ctx.msg)
    },
});

const Web = WebHelper({
    'page-title': {
        'suffix': '<?=_pro('page-title-suffix')?>',
        'glue': '<?=_pro('page-title-glue')?>',
    }
});

_r.vue.init({
    mount: true,

    use: {
        'vuetify': Vuetify.createVuetify(),
        //'vue-material': VueMaterial
    },


    decl: function(_log){
        return {
            props: [
                //'pane'
            ],

            data(){
                var sideState = <?=_s(false, $Self::$nsSideState, true) ? 'true' : 'false'?>;
                //_log('data', { sideState })

                return {
                    busy: false,
                    overlay: false,
                    minSide: !sideState,
                    pageTitle: 'Demo',
                    iq_list: [],
                    iqs: {},
                }
            },
            methods: {
                iq: function(cmptName, state){
                    this.iqs[cmptName] = state === undefined ? true : state;
                },
                iq1: function(cmptName, act){
                    var self = this;
                    var _has = function(cmpt){
                        return !!_.find(self.iq_list, cmpt);
                    }
                    var _add = function(cmpt){
                        if (!_has(cmpt)) {
                            self.iq_list.push(cmpt)
                        }
                    }
                    var _del = function(cmpt){
                        var index = _.findIndex(self.iq_list, cmpt);
                        if (index !== -1) self.iq_list.splice(index, 1);
                    }
                    var _get = function(cmptName){
                        return _rr.getDecl(cmptName)
                    }

                    var _cmpt = _get(cmptName);
                    //_log('iq', { cmptName, _cmpt })
                    if (arguments.length === 1) {
                        _add(_cmpt);
                    } else {
                        if (act === false) {
                            _del(_cmpt);
                        }
                    }

                },
                iq_has: function(cmpt){
                    return !!_.find(this.iq_list, cmpt);
                },
                iq_add: function(cmpt){
                    if (!this.jq_has(cmpt)) {
                        this.iq_list.push(cmpt)
                    }
                },
                iq_del: function(cmpt){
                    var index = _.findIndex(this.iq_list, cmpt);
                    if (index !== -1) this.iq_list.splice(index, 1);
                },


                toggleSide: function(){
                    var oppositeValue = !this.minSide;

                    this.minSide = oppositeValue;

                    Api.request.post('app/side-toggle', { tmp: moment().unix() });
                    //Api.request.post('app/side-toggle', { tmp: moment().unix() }, function(response){ _log('toggleSide', { response }) });
                }
            },
            computed: {
                ncApp: function(){
                    return {
                        '-min': this.minSide,
                    }
                }
            },
            watch: {
            <?/*
                $route: function(route, prevRoute){
                    _log('~route', {
                        newRoute: route, prevRoute,
                        'route.name': route.name,
                        $route: _clearClone(this.$route),

                        viewName: this.viewName,

                        '_.isEqual': _.isEqual(route, prevRoute),
                        '_isEqual': JSON.stringify(route) === JSON.stringify(prevRoute),
                    });
                }
            */?>

            },
            mounted(){
                //_log('mounted-r', { router: this.router })
            }
        }
    },

    router: {
        nohashRouter: true,
        baseUri: '/kot',
    },

    routes: function(App){ //= routes ()
        //_log('app/routes', { root: this, App })

        //var DefContent = this.getDecl('def-content');
        var DefContent = this.getDecl('http-403');


        //_log('decl', { _decl: _r._decl })
        var baseRoutes = [
            //{ path: '/dashboard', component: Dashboard },
            //{ path: '/informirovanie/passazhiry/rassylki/shablony-targetov/:page(.*)*', component: this.getDecl('targets-list') },
            //{ path: '<?=_kot::namedUrl('trg', '/:page(.*)*')?>', component: this.getDecl('targets-list') },
            { path: '/:page(.*)*', component: DefContent, name: '403', meta: { pageTitle: 'HTTP 403 Forbidden' } },
        ];

        return function routesRehandler(cmptRoutes){
            return baseRoutes.concat(cmptRoutes); //same way
            //возможно ручная переработка внутренних путей
            //_log('app/routes/rehandler', { root: this, App, baseRoutes, cmptRoutes })
            return baseRoutes;
        };
    },

    afterMount: function($App){
        //this = VueRoot

        this.Router.beforeEach(function (newRoute, prevRoute, next) {
            //_log('~route', { newRoute, prevRoute });

            if (newRoute.meta) {
                var pageTitle = newRoute.meta.pageTitle;
                var contentTitle = newRoute.meta.contentTitle || pageTitle;
                //_log('app/pageTitle', { title: newRoute.meta.pageTitle });

                Web.pageTitle(pageTitle)
                $App.pageTitle = contentTitle;
            }

            $App.busy = true;
            _delay(_r.routerDelay, function(){
                $App.busy = false;
                next();
            }, this)


        });
    }


});