AppRouter; AppRoutes;
App; opt;


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

//step: собираем/определяем конфиг
var routerConfig = {
    routes: allRoutes,
    history: VueRouter.createWebHashHistory(),
    // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
};

var routerOpts = opt.routing;
if (routerOpts) {
    if (routerOpts.base === true) {
        //man: https://v3.router.vuejs.org/ru/api/#base
        routerOpts.base = location.pathname;
    }
    routerConfig = _.defaults(routerConfig, routerOpts);
}

//_log('initRouter', { routerConfig: routerConfig });
AppRouter = VueRouter.createRouter(routerConfig)
App.use(AppRouter);


//var allRoutes = VueRoot.collectRoutes(AppRoutes)
//VueRoot.init_router(App, allRoutes)
