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
var defDestination = 'm';
var constructorPrefix = '_';
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

_.each(cfgProvide, function(args, target){
    if (!_.isArray(args)) args = [args]; //для конструктора метода

    var title = target; //внутренний title провайдера, может помочь сделать провайдеры с одинаковыми именами, или просто показать дополнительное логическое название
    var subTitle = '';
    var titleChunks = target.split(titleDelimeter); //eg: 'target-tpl/fetchData'
    var hasTitleChunks = titleChunks.length > 1;
    if (hasTitleChunks) {
        target = titleChunks.pop(); //последняя часть
        subTitle = titleChunks.join('/')
    }

    const dbg = target === 'w:wait';

    var isConstructor = target.charAt(0) === constructorPrefix; //eg: '_link' | '_w:wait'
    if (isConstructor) target = target.slice(1);
    var destinationCode = defDestination; //'m', 'c', 'w', 'd'
    var destinationChunks = target.split(destinationDelimeter);
    if (destinationChunks.length == 2) { //eg: '_m:%method'
        destinationCode = destinationChunks[0]; 
        target = destinationChunks[1]; 
    }
    var destination = destinationMap[destinationCode]; //'methods', 'computed', 'watch', 'data',


    if (title === 'ui/field/validate') {
        _log('provide', { title, subTitle, target, isConstructor, destinationCode, destination, method: provider[title], methodOpt: providerOpt[title] })
        return;
    }

    var method = provider[title];
    var methodOpt = providerOpt[title] || {};

    var constructorTitle = [
        //hasTitleChunks ? titleChunks.join('/') + '/' : '',
        subTitle ? subTitle + '/' : '',
        constructorPrefix,
        destinationChunks.join(destinationDelimeter)
    ].join('');
    var methodConstructor = provider[constructorTitle]
    if (methodConstructor) {
        method = methodConstructor.apply(null, args)
    }

    //иногда самого метода может не быть, а только список зависимостей
    if (!method) return;

    var curMethod, curSection;
    if (destinationCode === 'd') { //case: section 'data'
        curMethod = decl[destination]; //ak curData
        decl[destination] = function(){
            //return _.defaults(declData.apply(this), method);
            return _.merge({},
                typeof method == 'function' ? method() : method,
                curMethod && curMethod.apply(this)
            );
        }

    } else if (destinationCode === 'c') { //case: section 'computed'
        curSection = decl[destination];
        if (!curSection) curSection = {};

        //надо тестировать
        if (!curSection[target] || methodOpt.override) {
            curSection[target] = method;
        }

    } else if (destinationCode === 'w') { //case: section 'watch'
        curSection = decl[destination];
        if (!curSection) curSection = {};

        var curWatch = decl[destination][target];
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

    } else if (destinationCode === 'm') { //base case: section 'methods'
        curSection = decl[destination];
        if (!curSection) curSection = {};

        if (curSection[target]) {
            if (!methodOpt.override) target = '_' + target; //superMethodName = '_'
            //записываем provider-method в {_%method} если такой метод уже задекларирован
        }
        curSection[target] = method;

    } else { //else case: emits and props
        curSection = decl[destination];
        if (!curSection) curSection = [];

        var curIsObject = _.isPlainObject(curSection);
        var newIsObject = _.isPlainObject(method);
        var asObject = curIsObject || newIsObject;

        if (asObject) {
            console.warn('WEB: provide need desctibe emits-props section as object', 1)
            console.log('WEB: provide need desctibe emits-props section as object', { curIsObject, newIsObject, curData: curSection, newData: method })
            //перевести [] в простой { $prop: String }
        } else {
            decl[destination] = _.uniqWith(_.concat(curSection, method), _.isEqual);
            //_log('provide/merge(emits,props)', { curData: curSection, newData: method, resData: decl[destination] })
        }

    }
    
})
