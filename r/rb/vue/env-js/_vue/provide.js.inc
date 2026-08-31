<? #3.0.10 ?>
<? $js; ?>
/// _cfg.provide / ak extend
<?/*
-   -   eg
    m:link / link - method { link }
    _m:link - ak parent method { _link: link }
-   -   eg 2023
    _vue.provider['target-tpl/_w:cfg'] = function(){}

*/?>
var destinationMap = {
    'm': 'methods',
    'a': 'mounted', //after
    'r': 'created', //cReated
    'c': 'computed',
    'w': 'watch',
    'p': 'props',
    'e': 'emits',
    'd': 'data',
    't': 'template',
}
var namedDestinations = ['methods', 'computed', 'watch'];
var singleDestinations = ['data', 'props', 'emits', 'mounted', 'template', 'created'];
var defDestination = 'm';
var constructorPrefix = '_';
var extenderPrefix = '__';
var destinationDelimeter = ':';
var titleDelimeter = '/';

var Provider = _vue.provider;
var ProviderOpt = _vue.providerOpt;
var ProviderDep = _vue.providerDep;


<? include $js['decl/provide/link'] ?> /*
    link,
    linkBack,
    linkTitul
    linkRel
*/

<? include $js['decl/provide/reg'] ?> /*
    regField,
    regButton,
    regView
*/

<? include $js['decl/provide/parent'] ?> /*
    getParent,
    applyParentMethod,
    getRealParent,
    applyRealParentMethod
*/
<? include $js['decl/provide/date'] ?> /*
    formatDate
    getCurrentDateTime
*/

<? //include $js['decl/provide/crud'] ?> /*
    crud
*/

<? include $js['decl/provide/fq'] ?> /*
    isNumeric
    splitValueAndUnit
    convertStringToTypedValue
*/

var pdbg = false;
pdbg = (name === 'tpl-card2--card-factor');
//pdbg = (name === 'tpl2-card2--card-factor');



var provide = function(target, args){

    if (!_.isArray(args)) args = [args]; //для конструктора метода

    if (typeof target === 'string') {
        //base case
        target = provide.parseTitle(target);    
    }
    
    //var title = target.title
    var { title, destination } = target;

    //if (pdbg) _log('provide', { name, title, destination })

    var method = Provider[title];
    var methodOpt = ProviderOpt[title] || {};

    var constructorTitle = provide.codedTitle(target, constructorPrefix)
    var methodConstructor = Provider[constructorTitle]
    if (methodConstructor) {
        //_log('pr/methodConstructor', { constructorTitle, extenderTitle, methodConstructor, type: typeof methodConstructor, })
        method = methodConstructor.apply(null, args);
    }

    var extenderTitle = provide.codedTitle(target, extenderPrefix)

    var declExtender = Provider[extenderTitle]; //extenderTitle ~ '__data-list'
    ///_log('provide/declExtender', { extenderTitle })

    //if (target.name === 'target-tpl') _log('target-tpl', { targetName: target.name, extenderTitle, declExtender, target })

    if (!declExtender) { //case: Base
        //иногда самого метода может не быть, а только список зависимостей
        if (!method) return;

        //var sectionProvider = provide[destinationCode];
        var sectionProvider = provide[destination];
        //if (!sectionProvider) return _log('!!error', { target })

        if (_.includes(namedDestinations, destination)) {
            sectionProvider(target.name, method, methodOpt);
        } else {
        //mb } else if (_.includes(singleDestinations, destination)) {
            sectionProvider(method, methodOpt);
        }
    } else { //case: Extend / __extend-name
        //if (pdbg) _log('declExtender', { extenderTitle, isConsructor: typeof declExtender === 'function', args })
        if (typeof declExtender === 'function') {
            declExtender = declExtender.apply(null, args)
            //if (pdbg) _log('declExtender/res', { declExtender: _cc(declExtender) })
            //if (constructorTitle === '_prod-item') { debugger; }
        }
        var argsData = args[0];

        //var optSection = declExtender.provideOpt || {}; //указания для обработки методов (указываются в provide-js-файлах)
        var optSection = methodOpt;
        //if (name === 'prod-size') _log('optSection', {constructorTitle, methodOpt });


        _.each(declExtender, function(section, sectionName){
            ///if (sectionName === 'mounted') _log('declExtender/~', { extenderTitle, sectionName }); //dbg
            //_log('declExtender/~', { sectionName, section }); //dbg
            var sectionProvider = provide[sectionName];
            if (_.includes(namedDestinations, sectionName)) {
                _.each(section, function(itemMethod, itemName){
                    var isConstructor = itemName[0] === constructorPrefix;
                    if (isConstructor) {
                        var constructorName = itemName;
                        var constructorMethod = itemMethod;
                        //изменияем на реальное имя
                        itemName = itemName.slice(1);

                        var argName = (sectionName === 'methods' ? '' : sectionName[0] + ':') + itemName
                        var constructorArgs = argsData[argName] ? _.castArray(argsData[argName]) : []; //аргумента дял конструктора (указываются в секции { _vue.provide.%method: %args } )

                        //составляем реальный метод
                        itemMethod = constructorMethod.apply(null, constructorArgs);
                        //_log('extender/section', { sectionName, itemName, isConstructor, args, optName })
                    }

                    var optName = (sectionName === 'methods' ? '' : sectionName[0] + ':') + itemName

                    var dbg = itemName === 'addValidate'; dbg = null;

                    //if (name === 'prod-size') _log('optSection', { sectionName, optSection, optName, opt: optSection &&  optSection[optName] });
                    sectionProvider(itemName, itemMethod, optSection[optName], dbg)
                })
            } else if (_.includes(singleDestinations, sectionName)) {
                ///if (sectionName === 'mounted') _log('is-singleDestinations', { sectionName, section, sectionProvider });
                sectionProvider(section, optSection[sectionName])
            } else {

                if (sectionName === '_vue') {
                    sectionProvider(section);
                } else if (sectionName === 'provideOpt') {
                    //skip
                } else {
                    _log('provider/unknonwn-section', { sectionName, section: optSection[sectionName] })
                }


            }
        })

    }

}
//oo r/rb/vue/env-js/vue-root/vue-decl.js.inc



provide.parseTitle = function(target){
    var title = target; //внутренний title провайдера, может помочь сделать провайдеры с одинаковыми именами, или просто показать дополнительное логическое название
    var subTitle = '';
    var titleChunks = target.split(titleDelimeter); //eg: 'target-tpl/fetchData'
    var hasTitleChunks = titleChunks.length > 1;
    if (hasTitleChunks) {
        target = titleChunks.pop(); //последняя часть
        subTitle = titleChunks.join('/')
    }

    //заявленный метод констуктор, но проверка будет потом, пока получаем оригинальное имя, и выставляем флаг
    var isConstructor = target.charAt(0) === constructorPrefix; //eg: '_link' | '_w:wait'
    if (isConstructor) target = target.slice(1);

    var destinationCode = defDestination; //'m', 'c', 'w', 'd'
    var destinationChunks = target.split(destinationDelimeter);
    var hasDeclaredDestination = destinationChunks.length == 2;
    if (hasDeclaredDestination) { //eg: '_m:%method'
        destinationCode = destinationChunks[0];
        target = destinationChunks[1];

    }
    var destination = destinationMap[destinationCode]; //'methods', 'computed', 'watch', 'data',



    return {
        name: target, //ak targetName
        title, //ak providerName
        subTitle, //ak providerSection
        destinationCode,
        destination,
        codedName: hasDeclaredDestination ? [destinationCode, target].join(destinationDelimeter) : target,
        //codedName: destinationCode !== 'm' ? [destinationCode, target].join(destinationDelimeter) : target,
        isConstructor,
    }
}


provide.codedTitle = function(target, prefix){
    return [
        target.subTitle ? target.subTitle + '/' : '',
        prefix || '',
        target.codedName
    ].join('');
}


///provide.d =
provide.data = function(method){
    var curMethod = decl.data; //ak curData
    decl.data = function(){
        //return _.defaults(declData.apply(this), method);

        ///return _.cloneDeep(_.merge({},
        return _.merge({},
            typeof method == 'function' ? method.apply(this) : method,
            curMethod && curMethod.apply(this)
        );
    }
}

///provide.c =
provide.computed = function(target, method, methodOpt){
    if (!methodOpt) methodOpt = {};
    if (!decl.computed) decl.computed = {};
    var curSection = decl.computed;

    var override = _.defaultTo(methodOpt && methodOpt.override, false);

    //_log('provide/extend/computed', { name, methodOpt, override });

    if (curSection[target] && !override) {
        curSection[`_${target}`] = curSection[target];
    }

    curSection[target] = method;
}

///provide.w =
provide.watch = function(target, method, methodOpt){
    if (!decl.watch) decl.watch = {};
    var curSection = decl.watch;

    //_log('provide/extent/watch', { name, methodOpt });
    var override = _.defaultTo(methodOpt && methodOpt.override, false);

    if (!curSection[target] || override) {
        //case (пока по умолчанию): Перезапись и перемещение предыдущего в _name
        if (curSection[target]) {
            curSection['_' + target] = curSection[target];
        }
        curSection[target] = method;

    } else { //case: extension

        var curWatch = curSection[target];
        var curIsObject = curWatch && typeof curWatch === 'object';
        var newIsObject = typeof method === 'object';
        var asObject = curIsObject || newIsObject;

        _log('provide/watch-merge/1', { curMethod, destinationCode, target, title, name, curIsObject, newIsObject })
        //if (target === 'value') _log('provide/watch-merge', { title, target, curWatch, curIsObject, newIsObject })

        var curHandler = curIsObject ? curWatch.handler : curWatch;
        var newHandler = newIsObject ? method.handler : method;

        _log('provide/watch-merge/2', { curHandler, newHandler, title, name, curIsObject, newIsObject })

        var methodHandler = curWatch ? function(){
            //this.log(`w:(merged)${target}`)
            curHandler.apply(this, arguments);
            newHandler.apply(this, arguments);
        } : newHandler;

        if (asObject) { //case: deep watch
            //_log('provide/watch-merge-as-object', { title, name, curIsObject, newIsObject })
            curSection[target] = {
                deep: true,
                handler: methodHandler,
            }
        } else {
            curSection[target] = methodHandler;
        }
    }
}


///provide.m =
provide.methods = function(target, method, methodOpt, dbg){
    if (!methodOpt) methodOpt = {};
    if (!decl.methods) decl.methods = {};
    var curSection = decl.methods;
    //r/rb/vue/env-js/_vue/provide.js.inc:163
    if (dbg) _log('dbg/provide/methods', { target, methodOpt: _clone(methodOpt), method, hasMethod: curSection[target] })
    if (curSection[target]) {
        if (!methodOpt.override) target = '_' + target; //superMethodName = '_'
        //записываем provider-method в {_%method} если такой метод уже задекларирован
    }
    curSection[target] = method;
}


provide.contract = function(section, method){
    if (!decl[section]) decl[section] = [];
    var curSection = decl[section];

    var curIsObject = _.isPlainObject(curSection);
    var newIsObject = _.isPlainObject(method);
    var asObject = curIsObject || newIsObject;

    if (asObject) {
        console.warn(`WEB: provide need desctibe ${section} section as object`, 1)
        console.log(`WEB: provide need desctibe ${section} section as object`, { curIsObject, newIsObject, curData: curSection, newData: method })
        //перевести []-props в простые { $prop: String }
    } else {
        decl[section] = _.uniqWith(_.concat(curSection, method), _.isEqual);
        //_log('provide/merge(emits,props)', { curData: curSection, newData: method, resData: decl[destination] })
    }
}

///provide.e =
provide.emits = function(method){
    provide.contract('emits', method)
}
///provide.p =
provide.props = function(method){
    provide.contract('props', method)
}

///provide.a =
//npr
_.each(['mounted', 'created'], function(methodName){
    provide[methodName] = function(method, methodOpt){
        var curMethod = decl[methodName];
        ///_log('provide/mounted', { curMethod, method, methodOpt });

        decl[methodName] = function(){
            ///this.log('mounted|provider', { curMethod, method, methodOpt });
            curMethod && curMethod.apply(this)
            method.apply(this);
        }
    }
});



///provide.t =
provide.template = function(newTemplate, methodOpt){
    var curTemplate = decl.template;
    //_log('provide/template', { curTemplate, newTemplate });
    decl.template = newTemplate;
}


provide._vue = function(extSection){
    var curSection = decl._vue;

    //_log('provide/_vue', { curSection, extSection});

    var curSection0 = _clone(curSection);
    var extSection0 = _clone(extSection);

    decl._vue = _.mergeWith(curSection || {}, extSection,   function (declValue, extValue, key) {
        //_log('provide/merge', { objValue, srcValue, key })
        if (key === 'provide') {
            //_log('provide-extra', { extValue, declValue })
            provide.init(extValue)
        }

        if (_.isArray(declValue)) {
            // Слияние массивов и удаление дубликатов
            // Для объектов в массивах будет использоваться JSON.stringify для сравнения
            return _.unionWith(declValue, extValue, _.isEqual);
        }
    });

    //_log('provide/_vue/result', { _vue: decl._vue, curSection, extSection});
    //_log('reprovide-vue', { decl, provide2: decl._vue.provide, curSection0, extSection0 })

}


provide.prepare = function(cfg){
    var cfgProvide = cfg; //секция provide (в _vue)
    var cfgProvide_orig = _clone(cfgProvide);

    var prepareProvideList = function(cfg){
        return _.transform(cfg, function(res, target, index){
            //_log('cfgProvide:each', { index, target, res })
            if (typeof target == 'string') {
                res[target] = true;
            } else {
                //case: isObject
                _.assign(res, target)
                //res = _.assign({}, target, res) //v2 вроде как dep спереди должен встать
            }
        }, {})
    }
    //step: преобразуем конфиг в объект
    if (_.isArray(cfgProvide)) {
        cfgProvide = prepareProvideList(cfgProvide)
    }

    //step: verify dependencies for providings
    var _depCheckoutList = {};
    var _depCheckout = function(name){
        var depCfg = prepareProvideList(ProviderDep[name])
        //if (pdbg) _log('provide/depCheckout', { name, depCfg0: ProviderDep[name], depCfg1: depCfg })

        _.each(depCfg, function(depCfg, depName){
            //_log('provide/verify-dependency', { _name, _depName })
            cfgProvide[depName] = depCfg;
            if (!_depCheckoutList[depName]) {
                _depCheckoutList[depName] = true; //от зацикливания
                _depCheckout(depName);
            }
        })
    }

    //if (pdbg) _log('provide/depCheckout/0', { cfgProvide0: _cc(cfgProvide) })
    _.each(cfgProvide, function(_cfg, _name){
        _depCheckout(_name)
    })
    //if (pdbg) _log('provide/depCheckout/1', { cfgProvide1: _cc(cfgProvide) })

    //if (name === 'table-listing') _log('cfgProvide', { cfgProvide, cfgProvide_orig })

    return cfgProvide;
}


provide.init = function(cfg){
    var list = provide.prepare(cfg);

    _.each(list, function(args, target){
        provide(target, args)
    })
}

//if (pdbg) _log('provide', { list: _cc(cfgProvide) });

if (!_.isEmpty(_cfg.provide)) {
    provide.init(_cfg.provide);
}

