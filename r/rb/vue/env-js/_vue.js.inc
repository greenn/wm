<? $js; ?>
var __log = Log.for('VUE-ENV');

//_AppDirectives - магазин директив
<? include $js['vue-directives'] ?> //_AppDirectives

//002
var KeepAlive = Vue.KeepAlive;
var Teleport = Vue.Teleport;
var Transition = Vue.Transition;
var TransitionGroup = Vue.TransitionGroup;


//#1.2.5 - vue-рафинад
function _vue(name, construct, _init, opt){
    //opt: init
    //_Log('_vue()', { name, opt });



    if (typeof opt === 'undefined') opt = _vue.autoinit;
    if (opt === true || opt === false) opt = { init: opt }
    if (_.isBoolean(opt)) opt = { init: opt }
    if (!opt.hasOwnProperty('init')) opt.init = _vue.autoinit;


    var logName = name;
    if (_.isArray(name)) {
        logName = name[1];
        name = name[0];
    }

	<?#j include $js['decl/init'] ?> //_init
    if (!_init) _init = _vue.defInit
        // r/rb/vue/env-js/vue-root.js.inc:52
        // r/rb/vue/env-js/_vue.js.inc:144

    var _log = Log.for(logName)
    /*var _clog = function(title, ccData, ...rest) {
        this.log.call(this.log, title, _cc(ccData), ...rest);
    }*/


    <? include $js['decl/cmd'] ?> //_vue/cmd.js.inc

    //01 -
    if (typeof construct !== 'function') {
        var _construct = construct;
        construct = function(){ return _construct }
    }


    //_log('_vue 00', { name, decl: _clone(construct) });
    //step: получение конфигурации vue-декларации
    var decl = construct(_log, _cmd/*///, _self*/);
    //next: переработка кофига, до получения реальной vue-декларации
    //_log('_vue 01', { name, decl: _clone(decl), opt, init: opt.init });

    var _cfg = decl._vue || {};

    if (_cfg.multiInstances) { //multi|multiInstances
        _cmd.counter = 1; // для повторяющихся компонентов
    }

    //step: добавление метода _log для компонента
    if (!decl.methods) decl.methods = {};
    if (!decl.methods._log) decl.methods._log = _log; //L
    if (!decl.methods.log) decl.methods.log = _log;
    if (!decl.methods.clog) {
        decl.methods.clog = function(title, ccData, ...rest) {
            this.log.call(this.log, title, _cc(ccData), ...rest);
        }
    }
    //dbg
    if (!decl.methods._log2) decl.methods._log2 = function(){
        _log('log2', {
            index: this._index,
            name: this._name,
            'this.log.setIndex': this.log.setIndex,
            '_log.setIndex': _log.setIndex
        })
        this.log.apply(this.log, arguments);
    };


	<? include $js['decl/provide'] ?> //@provider

    var _mounted = decl.mounted;
    //var _created = decl.created;
    var _data = decl.data;

	<? include $js['decl/router'] ?> //  _vue.routes

    <? include $js['decl/directives'] ?> //  _vue.directives

	<? include $js['decl/store'] ?> //  _vue.store

	<? include $js['decl/mounted'] ?> // decl.mounted

    /*decl.created = function(){
        _log('CREATED');
        _created && _created.apply(this, arguments);
    }*/

    if(0) decl.created = function(){
        _log('created')
    }

    if(0) decl.beforeMount = function(){
        _log('beforeMount')
    }

    if (!decl.template) {
        if (decl.template !== '') {
            decl.template = '#' + name;
        }
    }
    if (opt.isRoot) {
        decl.template = false;
    }

	<? include $js['decl/data'] ?> //:: decl.data


    if (l.cmpt) _log('_Decl', { name, decl });
    _Decl[name] = decl;


    //base case: не исполянеется / раньше для v1 запускался vue_app()
    //step: инициализации декларации
    if (opt.init) {
        //_log('_VUE/init-cmpt', { name, decl, _init, opt });
        _init(decl, _cmd, name) <?# < rb/vue/env-js/_vue/decl-init.js.inc ?>
    }

    if(0) if (_.includes(['ui-field', 'ui-select'], name)) {
        _log('=decl', name, { decl: _clone(decl) });
    }

    return decl;
}

_vue.autoinit = true;
_vue.defInit = function(decl, _cmd, name){
    //_log('INIT-CMPT', { decl });
    _vue.init_cmpt(name, decl);
    return decl;
}


//_vue.$init_cmpt
_vue.init_cmpt = pending_fn(); <?# rb/vue/env-js/_vue-app.js.inc:43 ?>
_vue.init_directive = pending_fn();

_vue.provider = {};
_vue.providerOpt = {};
_vue.providerDep = {};
