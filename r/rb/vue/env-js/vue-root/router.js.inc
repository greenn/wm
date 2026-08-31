//VueRoot.init_router(App, VueRoot.collectRoutes(AppRoutes));
collectRoutes = function(routesList){
    _log('collectRoutes', { routesList })
    //step: Apply routes /ak @applyCmptRoutes
    var allRoutes = _.reduce(routesList, function(list, set){
        var getRoutes = set[0];
        var cmptName = set[1];
        var cmptDecl = set[2];
        //var routes = getRoutes(); //prev-v2
        var routes = getRoutes.apply(__root, [App, cmptDecl]) // $App ещё нет
        //_log('ADD-ROUTES', cmptName, routes);
        list = list.concat(routes)
        return list
    }, [])
    _log('ROUTES/LIST', allRoutes, _.uniqWith(allRoutes, _.isEqual));
    allRoutes = _.uniqWith(allRoutes, _.isEqual);
    return allRoutes;
}


handleRoutes = function(routes){
    var allRoutes;

    var cmptRoutes = collectRoutes(AppRoutes);

    if (typeof routes === 'function') {
        routes = routes.apply(__root, [App]) // $App ещё нет | allRoutes
    }

    var rehandleRoutes = typeof routes === 'function' ? routes :  false;
    if (rehandleRoutes) {
        allRoutes = rehandleRoutes.call(__root, cmptRoutes) // , AppRoutes, @applyCmptRoutes()
    } else {
        //base way:
        allRoutes = cmptRoutes;
        if (routes) {
            allRoutes = allRoutes.concat(routes)
        }
    }

    return allRoutes;
}

__root.init_router = function(routes, routerOpt) {
    if (!routerOpt) routerOpt = {};
    //debugger;


    var allRoutes = handleRoutes(routes)

    //console.log('init_router', { allRoutes, routerOpt });

    //custom Router build
    //AppRouter = routerOpt.construct.call({ App }, allRoutes, routerOpt)

    //step: собираем/определяем конфиг
    var routerConfig = {
        routes: allRoutes,
        //history: VueRouter.createWebHashHistory(), //hash mode
        //history: VueRouter.createWebHistory(), //no-hash mode
        // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
    };

    //01
    if (routerOpt.config) {
        routerConfig = _.defaults(routerConfig, routerOpt.config);
    }

    if (routerConfig.base === true || routerConfig.base === undefined) {
        //man: https://v3.router.vuejs.org/ru/api/#base
        //routerOpt.base = location.pathname; //prev
        routerConfig.base = routerOpt.baseUri || '/';

        <? if (0) { ?>
            var baseUri = routerOpt.baseUri;
            var baseUri0 = baseUri; //dbg
            if (baseUri) {
                //удаляем слэши с начала и конца строки
                baseUri = baseUri.replace(/^[/\\]+|[/\\]+$/g, '');
            }
            routerConfig.base = routerOpt.baseUriRaw/*01*/ || baseUri || '/';
            _log('routerConfig.base', { 'routerConfig.base': routerConfig.base, baseUri0 })
		<? } ?>
    }

    if (routerOpt.nohashRouter) {
        //_log('routerConfig.history', { createWebHistory: true, routerConfig });
        routerConfig.history = VueRouter.createWebHistory(routerConfig.base);
        //routerConfig.history = VueRouter.createWebHistory();
    } else {
        routerConfig.history = VueRouter.createWebHashHistory(routerConfig.base);
        //routerConfig.history = VueRouter.createWebHashHistory();
    }

    //_log('createRouter', { routerConfig, routerOpt });

    AppRouter = VueRouter.createRouter(routerConfig)


    App.use(AppRouter);
    //__self.Router = AppRouter;

    //dbg
    window._routerConfig_ = routerConfig;
    window._AppRouter_ = AppRouter;



    return AppRouter;

}