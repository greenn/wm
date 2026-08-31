<?//v1 wrapper для vue-приложения ?>
function vue_app(construct, _init, appName = 'app') {
    var _log = Log.for(appName);
    _log.set('ENV_APP-INIT', l.loading);
    _log.set('DOMREADY', l.loading);
    _log.set('APP-INIT', l.loading);

    //_log(111);

    _vue(appName, function(_log, _cmd){
        _cmd.isApp = true;

        //_log('.. _vue app I');

        return construct(_log)

    }, function(decl, _cmd){
        _log('.. _vue app II', { decl, declClone: _.cloneDeep(decl) });
        _log('ENV_APP-INIT', { _cmd, decl });

        _App = Vue.createApp(decl)

        /*
            выполняется перед добавлением и парсингорм компонент
            _log('AppDirectives', { AppDirectives, here: _clearClone(AppDirectives) });
            if (0) _.each(AppDirectives, function(directive, name){
                _log('setDirective+', { name, directive });
                _App.directive(name, directive);
            })
        */

        _vue.init_directive.solve(function(name, directive){
            //_log('_vue.init_cmpt', { name, decl, arguments });
            //_log('setDirective++', { name, directive });
            _App.directive(name, directive);
        })


        //_App.use(vuejsStorage);

        //result: Все компоненты добавлены в vue-приложение
        // но они ещё не смонтированы (не вставлены в DOM)
        if (0) emittery.on('vue-cmpt', function(set){
            var name = set[0];
            var decl = set[1];
            //_log('ADD/CMPT', name, decl);
            var _res = _App.component(name, decl)
        })

        _vue.init_cmpt.solve(function(name, decl){
            //_log('_vue.init_cmpt', { name, decl, arguments });
            if (l.cmpt) _log('init_cmpt/solve', { name: name });
            var _res = _App.component(name, decl)
            if (l.cmpt) _log('_vue.init_cmpt', { name, decl, arguments, '_App.component()': _res });

            //qq rb/vue/env-js/_vue/decl-mounted.js.inc
        })


        $(function(){
            _log('DOMREADY');

            if (_cmd.useRouter) {
                //step: Apply routes
                var allRoutes = _.reduce(AppRoutes, function(list, set){
                    var getRoutes = set[0];
                    var cmptName = set[1];
                    var routes = getRoutes();
                    //_log('ADD-ROUTES', cmptName, routes);
                    list = list.concat(routes)
                    return list
                }, [])
                //_log('ROUTES/LIST', allRoutes, _.uniqWith(allRoutes, _.isEqual));
                allRoutes = _.uniqWith(allRoutes, _.isEqual);


                var routerConfig = {
                    routes: allRoutes,
                    history: VueRouter.createWebHashHistory(),
                        // 4. Provide the history implementation to use. We are using the hash history for simplicity here.

                };
                var routerOpts = decl._vue && decl._vue.routerOpts;
                if (routerOpts) {
                    if (routerOpts.base === true) {
                        //man: https://v3.router.vuejs.org/ru/api/#base
                        routerOpts.base = location.pathname;
                    }
                    routerConfig = _.defaults(routerConfig, routerOpts);
                }

                //_log('initRouter', { routerConfig: routerConfig });
                AppRouter = VueRouter.createRouter(routerConfig)
                _App.use(AppRouter);
            }

            //_log('4', { _init });

            if (typeof _init == 'string') {
                var srApp = _init;
                _init = { sr: srApp }
            }



            if (typeof _init == 'function') {
                _init = {
                    mount: _init
                }
            } else if (!_init.mount) {
                //if (!_init.hasOwnProperty('AppName')) _init.AppName = 'App';
                //if (!_init.hasOwnProperty('_App')) _init._App = _App; //ak AppDecl
                _init.mount = function(){
                    App = _App.mount(_init.sr);
                    //window[this.AppName] = this._App.mount(this.sr);
                }

            }

            //_log('5', { _init });

            if (_init.beforeMount) _init.beforeMount(_log, _cmd)
            if (_init.mount) _init.mount(_log, _cmd)
            if (_init.after) _init.after(_log, _cmd)
        })

    }, {
        isRoot: true
    })


}