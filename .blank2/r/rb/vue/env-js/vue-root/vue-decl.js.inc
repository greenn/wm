var VueDecl = (function(){
    <?/*
        _vueDecl (с маленькой, потому что внутренний объект)
        VueDecl может быть и глобальным легко, просто пока здесь
        а он и есть глобальный
    */?>
    var __decl = {};
    var _log = Log.for('VUEDECL'); //VueDecl

    //oo rb/vue/env-js/_vue/provide.js.inc
    var provider = {};
	<? //include $js['decl/provide/link'] ?> //link, linkBack, linkTitul
	<? //include $js['decl/provide/reg'] ?> //regField, regButton, regView
	<? //include $js['decl/provide/parent'] ?> //getParent, applyParentMethod, getRealParent, applyRealParentMethod

    /*[trd]
        ? экстендим provider
   */
    provider.setData = function(data){
        //_log('setData', { this: this });
        var self = this;
        _.each(data, function(value, name){
            self[name] = value;
        })
    }


    //ak r/rb/vue/env-js/_vue/provide.js.inc
    __decl.provideMethod = function(decl, name, constructorArgs){ //vueProvide

        if (!decl.methods[name]) {
            var method = provider[name];
            var methodConstructor = provider['_' + name];
            if (methodConstructor) {
                method = methodConstructor.apply(null, _.castArray(constructorArgs));
            }

            decl.methods[name] = method;
        }

    };

    //Hook Extend
    __decl.extendCallback = function(section, decl, callback){
        var orig_section = decl[section];
        if (orig_section) {
            decl[section] = function(){
                if (_.startsWith(this._name, 'target-form')) {
                    _log(`extend ${section}`, [name, this._name], { this: this });
                }
                callback.apply(this, arguments);
                return orig_section.apply(this, arguments);
            }
        } else {
            decl[section] = callback;
        }
        return decl;
    };

    __decl.extend = function(decl, extension){
        ///_log('__decl.extend', { decl: _clone(decl), extension: _clone(extension) });
        _.each(extension, function(data, section){
            switch (section) {
                case 'data': {
                    var extensionDataMethod = data;
                    if (!decl.data) decl.data = extensionDataMethod;
                    else {
                        var curDataMethod = decl.data;
                        decl.data = function(){
                            //here: перезапись
                            return _.assign({}, curDataMethod(), extensionDataMethod());
                        }
                    }
                } break;

                case 'mounted': {
                    var mountedCallback = data;
                    __decl.extendCallback('mounted', decl, mountedCallback);
                } break;

                //case 'watch': {} break;

                default:
                case 'watch':
                case 'computed':
                case 'methods': {
                    //var methodsList = data;
                    var extensionData = data;
                    //here: пока перезапись
                    decl[section] = _.assign({}, decl[section], extensionData);
                } break;



            }
        })

        return decl;
    }





    return __decl;
})();