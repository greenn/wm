<?//v3 wrapper для vue-приложения ?>

<?$js;?>

<? include $js['vue_root/vue-decl']; /*
    VueDecl {
        extend
        provideMethod
    }
*/?>

var VueRoot = (function(){ //AppRoot
    var App; //vue-декла  / RootCmpt; VueRoot; cmptRoot; VueApp
    var $App; //смонтированный vue-объект / _App
    var AppRouter;

    var _log = Log.for('VUEROOT'); //VueRoot
    l.vr_dbg = 0; //VueRootDbg
    l.vr_router = 0; //VueRootRouter

    _log.set('addComponent-0', l.vr_dbg);
    _log.set('addComponent', 0&&l.vr_dbg||0);
    _log.set('saveComponent', l.vr_dbg||1);
    _log.set('getComponent', l.vr_dbg||0);
    _log.set('saveDecl', l.vr_dbg||0);
    _log.set('init_router', l.vr_router||0);
    _log.set('collectRoutes', l.vr_router||0);
    _log.set('ROUTES/LIST', l.vr_router||0);


    var __root = {} //self* methods

    var _decl = {} //decl list

    var _list = {} //mounted cmpt list

    __root.log = _log;

    //dbg
    __root._list = _list;
    __root._decl = _decl;

    var __self = function(...args){
        return __root.componentCall.apply(__root, args);
    };

    var __self1 = function(cmptName, propName, arg1, argN){
        return __root.componentCall.apply(__root, arguments);
    };

    //указывает иницилятор для _vue-деклараций
    _vue.defInit = function(decl, _cmd, name){
        //_log('_vue::init', { name, decl });

        //step: пронизываем все компоненты "ресурсной" функцией
        VueDecl.extend(decl, {
            methods: {
                _r: __self //ak _aRipr()|_aSite()
            }
        })

        _saveDecl(name, decl);

        if (autoAddComponent) {
            __root.addComponent(name, decl);
        }
    }


    <? include $js['vue_root/decl']; /*
        @_saveDecl(), @_extendDecl()
        __root.getDecl(), __root.cloneDecl()
    */?>

	<? include $js['vue_root/root-decl']; //RootDecl ?>

	<? include $js['vue_root/api']; /* @_Api, @_api - внутренее (VueRoot) Api */ ?>

    <? include $js['vue_root/component']; /*
        __root.getComponent(), __root.saveComponent()
        __root.addComponent()
        __root.loadComponent()
        __root.componentCall()
    */?>

    <? include $js['vue_root/init']; /*
        __root.init()
        __root.initApp()
            :: _vue.defInit
        __root.mountApp()
        __root.mount()
    */?>

	<? include $js['vue_root/router']; /*
        __root.collectRoutes()
        __root.init_router()
    */ ?>


    <?/*
        //step: перености ___root в __self
        _.each(__root, function(method, name){
            __self[name] = method;
            //pr а например __root.Router - здесь не будет, т.к. его пока здесь нету
        })
        //sol: вынесем __root сюда, а в __self можно скопировать определённый методы
        //oo man/vue-root :: VueRoot.vue
    */?>

    __self.vue = __root; //L
    __self.root = __root;
    __self.getRouter = function(){
        return AppRouter;
    };


    <? include $js['vue_root/dbg']; ?>


    return __self;
})();