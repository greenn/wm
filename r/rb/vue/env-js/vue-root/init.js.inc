var autoAddComponent = true; //nl

<?/* полный процесс инициализаии
    [ устанавливается в начале кода (js-скриптов)
        если хочется поставить в конце (страницы)
            то сначала нужнно сделать
                VueRoot.initApp()
            а в конце уже непосредственно
                VueRoot.mountApp()
    ] */?>
__root.init = function(set){

    __root.initApp(set.decl, set.appName);

    if (set.mount) $(function(){
        __root.mountApp(set);
    })

    return App;
}





__root.initAppV1 = function(decl, appName){
    if (!appName) appName = 'app';

    var AppDecl = RootDecl(decl, appName);

    _saveDecl(appName, AppDecl);

    _log('AppDeclV1', { AppDecl: _clone(AppDecl) })

    App = Vue.createApp(AppDecl);

    //По умолчанию в Vue 3 Concurrent Mode включен  (режим одновременного рендеринга)
    if (0) {
        //"legacy mode" (режим совместимости), который ближе к работе Vue 2,
        App.config.compatConfig = {
            MODE: 2
        };
    }
}

__root.initAppV2 = function(decl, appName){
    if (!appName) appName = 'app';

    //_log('AppDeclV2/0', { decl, _decl: _clone(decl), appName })

    _vue(appName, decl, function(AppDecl){
        //_log('AppDeclV2', { AppDecl: _clone(AppDecl) })

        ////AppDecl = RootDecl(AppDecl, appName);

        AppDecl = _extendDecl(AppDecl, {
            mounted(){
                //_log('mounted-decl', { appName });
                __root.saveComponent(appName, this);
            }
        })

        _saveDecl(appName, AppDecl);

        App = Vue.createApp(AppDecl);

    }, {
        init: true,
        isRoot: true
    })

}
__root.initApp = __root.initAppV2;


__root.mountApp = function(set){

    if (set.router) {
        __root.Router = __root.init_router(set.routes, set.router);
    }

    if (set.use) {
        _.each(set.use, function(plugin, name){
            //_log('use', { name, plugin });
            App.use(plugin);
        })
    }

    __root.mount(set.mount, set.afterMount);
}


__root.mount = function(sr, afterMount){
    if (sr === true) sr = 'BODY';

    //_log('mount')

    $App = App.mount(sr || 'BODY');

    //dbg
    window._App_ = App;
    window._$App_ = $App;

    //после mount: выключаем автоДобавлениеКомпонентов
    autoAddComponent = false;
    //или нет, зачем
    //затем что Оно нормально не вставляется после App.mount
    //и нужно вставлять через decl

    if (afterMount) {
        //_log('afterMount', { __root, $App, App })
        afterMount.apply(__root, [$App, App]);
    }

    return $App;
}

_vue.autoinit = true; //nl