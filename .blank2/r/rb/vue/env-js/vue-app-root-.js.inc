<?//v2 wrapper для vue-приложения ?>
<?$js;?>

/*
//var AppRoot;
var _Root = (function(){
    var _root = {}
    var _list = {}

    _root.addComponent = function(){

    }

    return _root;
})();
*/


<? include $js['vue_app_root/decl'] ?>

function vue_app_root(_decl) { //declf
    //var _log = vue_app_root.log;

    //создаём экземпляр приложения
    var App = Vue.createApp(_decl || _Root);
    //_log('INIT1', { App });

    return App;
}

vue_app_root.appName = 'root';
vue_app_root.log = Log.for('ROOT');


function vue_app_root_init(App, readyc, opt) {
    if (!opt) opt = {}
    //var _log = vue_app_root.log;
    //_log('MOUNT0', { App });

    _vue.init_directive.solve(function(name, directive){
        App.directive(name, directive);
    })


    //App.use(vuejsStorage);

    //компоненты с авто-инитом
    _vue.init_cmpt.solve(function(name, _decl){
        //dlog('#1', { 'q App.addComponent': App.addComponent })
        var cmpt = App.component(name, _decl); //инстанс(экземпляр)
        _root[name] = cmpt;
    })

	<? include $js['vue_app_root/routing']; ?> //::routing

    $(function(){
        //_log('DOMREADY');

	    <? //include $js['vue_app_root/routing']; ?> //::routing

        var sr = opt.sr || 'BODY';

        var $App = _App.mount(sr);

        readyc($App)
    })

}

