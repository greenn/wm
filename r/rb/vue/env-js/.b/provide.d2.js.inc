<? $js; ?>
/// _cfg.provide / ak extend
<?/*
-   -   eg
    m:link / link - method { link }
    _m:link - ak parent method { _link: link }


-   -   ff
	cfg
		store
		- routes

	cfg-ff
		defViewName
		titulLink
		filterFieldsKeys
		d:fields

		c:filterListing
		c:view
		c:item
		w:$route

		m:link
		m:linkBack
		m:linkTitul
-   -   eg 2023
    _vue.provider['target-tpl/_w:cfg'] = function(){}

*/?>
var destinationMap = {
    'm': 'methods',
    'c': 'computed',
    'w': 'watch',
    'd': 'data',
    'p': 'props',
    'e': 'emits',
}
var namedDestinations = ['methods', 'computed', 'watch'];
var defDestination = 'm';
var constructorPrefix = '_';
var extenderPrefix = '__';
var destinationDelimeter = ':';
var titleDelimeter = '/';

var provider = _vue.provider;
var providerOpt = _vue.providerOpt;
var providerDep = _vue.providerDep;


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

*/



var cfgProvide = _cfg.provide; //секция provide (в _vue)
var cfgProvide_orig = cfgProvide;

//step: преобразуем конфиг в объект
if (_.isArray(cfgProvide)) {
    cfgProvide = _.transform(cfgProvide, function(res, target, index){
        //_log('cfgProvide:each', { index, target, res })
        if (typeof target == 'string') {
            res[target] = true;
        } else {
            //case: isObject
            _.assign(res, target)
        }
    }, {})
}

//td: verify dependencies for providings

var _depCheckoutList = {};
var _depCheckout = function(name){
    _.each(providerDep[name], function(depName){
        //_log('provide/verify-dependency', { _name, _depName })
        cfgProvide[depName] = true;
        if (!_depCheckoutList[depName]) {
            _depCheckoutList[depName] = true; //от зацикливания
            _depCheckout(depName);
        }

    })
}

_.each(cfgProvide, function(_cfg, _name){
    _depCheckout(_name)
})


//_log('provide/verify-dependency', { name, cfgProvide: _clone(cfgProvide) })

//if (name === 'table-listing') {

//}


//if (name === 'table-listing') _log('cfgProvide', { cfgProvide, cfgProvide_orig })
var provide = function(target, args,  _provider, _providerOpt){
    if (!_provider) _provider = provider;
    if (_providerOpt === undefined) _providerOpt = providerOpt;
    if (!_.isArray(args)) args = [args]; //для конструктора метода

    if (typeof target === 'string') {
        //base case
        target = provide.parseTitle(target);    
    }
    
    //var title = target.title
    var { title, destinationCode, destination } = target;

    var method = _provider[title];
    var methodOpt = _providerOpt[title] || {};

    var methodConstructor = provide.checkoutConstructor(target, _provider);
    if (methodConstructor) {
        method = methodConstructor.apply(null, args);
    }

    var declExtender = provide.checkoutExtender(target)
    
    if (!declExtender) {
        //case: Base
        //иногда самого метода может не быть, а только список зависимостей
        if (!method) return;

        var sectionProvider = provide[destinationCode];
        //if (!sectionProvider) return _log('!!error', { target })

        if (_.includes(namedDestinations, destination)) {
            sectionProvider(target.name, method, methodOpt);
        } else {
            sectionProvider(method, methodOpt);
        }
    } else {
        //case: Extend
        if (typeof declExtender === 'function') {
            declExtender = declExtender.apply(null, args)
        }

        _.each(declExtender, function(sectionName, section){
            var sectionProvider = provide[sectionName];

            if (_.includes(namedDestinations, sectionName)) {
                _.each(section, function(itemMethod, itemName){
                    sectionProvider(itemName, itemMethod)
                    provide(itemName, args, section,
                        sectionProvider.opt && sectionProvider.opt[provide.codedTitle(target)]
                    )
                })
            } else {
                sectionProvider(itemMethod)
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

    var destinationCode = defDestination; //'m', 'c', 'w', 'd'
    var destinationChunks = target.split(destinationDelimeter);
    var hasDeclaredDestination = destinationChunks.length == 2;
    if (hasDeclaredDestination) { //eg: '_m:%method'
        destinationCode = destinationChunks[0];
        target = destinationChunks[1];

    }
    var destination = destinationMap[destinationCode]; //'methods', 'computed', 'watch', 'data',

    //заявленный метод констуктор, но проверка будет потом, пока получаем оригинальное имя, и выставляем флаг
    var isConstructor = target.charAt(0) === constructorPrefix; //eg: '_link' | '_w:wait'
    if (isConstructor) target = target.slice(1);

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


//providerData для extender
provide.codedTitle = function(target, prefix){
    return [
        target.subTitle ? target.subTitle + '/' : '',
        prefix || '',
        target.codedName
    ].join('');
}
provide.checkoutConstructor = function(target, providerData){
    if (!providerData) providerData = provider;
    var constructorTitle = [
        //hasTitleChunks ? titleChunks.join('/') + '/' : '',
        target.subTitle ? target.subTitle + '/' : '',
        constructorPrefix,
        target.codedName
    ].join('');

    return providerData[constructorTitle];
}

provide.checkoutExtender = function(target, providerData){
    if (!providerData) providerData = provider;
    var extenderTitle = [
        //hasTitleChunks ? titleChunks.join('/') + '/' : '',
        target.subTitle ? target.subTitle + '/' : '',
        extenderPrefix,
        target.name
    ].join('');
    return providerData[extenderTitle];
}



provide.d = provide.data = function(method){
    var curMethod = decl.data; //ak curData
    decl.data = function(){
        //return _.defaults(declData.apply(this), method);
        return _.merge({},
            typeof method == 'function' ? method() : method,
            curMethod && curMethod.apply(this)
        );
    }
}

provide.c = provide.computed = function(target, method, methodOpt){
    if (!methodOpt) methodOpt = {};
    if (!decl.computed) decl.computed = {};
    var curSection = decl.computed;

    //надо тестировать
    if (!curSection[target] || methodOpt.override) {
        curSection[target] = method;
    }
}

provide.w = provide.watch = function(target, method){
    if (!decl.watch) decl.watch = {};
    var curSection = decl.watch;

    var curWatch = curSection[target];
    var curIsObject = curWatch && typeof curWatch === 'object';
    var newIsObject = typeof method === 'object';
    var asObject = curIsObject || newIsObject;

    //_log('provide/watch-merge', { curMethod, destinationCode, target, title, name, curIsObject, newIsObject })
    //if (target === 'value') _log('provide/watch-merge', { title, target, curWatch, curIsObject, newIsObject })

    var curHandler = curIsObject ? curWatch.handler : curWatch;
    var newHandler = newIsObject ? method.handler : method;
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


provide.m = provide.methods = function(target, method, methodOpt){
    if (!decl.methods) decl.methods = {};
    var curSection = decl.methods;
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

provide.e = provide.emits = function(method){
    provide.contract('emits', method)
}
provide.p = provide.props = function(method){
    provide.contract('props', method)
}



_.each(cfgProvide, function(args, target){
    provide(target, args)
})
