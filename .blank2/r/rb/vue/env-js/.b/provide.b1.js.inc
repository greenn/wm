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
*/?>
var destinationMap = {
    'm': 'methods',
    'c': 'computed',
    'w': 'watch',
    'd': 'data',
}
var defDestination = 'm';
var constructorPrefix = '_';
var destinationDelimeter = ':';
var titleDelimeter = '/';

var provider = _vue.provider;
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

var _depCheckout = function(name){
    _.each(providerDep[name], function(depName){
        //_log('provide/verify-dependency', { _name, _depName })
        cfgProvide[depName] = true;
        _depCheckout(depName);
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



    var title = ''; //внутренни title провайдера, может помочь сделать провайдеры с одинаковыми именами, или просто показать дополнительное логическое название
    var titles = target.split(titleDelimeter); //eg: 'target-tpl/fetchData'
    if (titles.length > 1) {
        target = titles.pop(); //последнюю часть
        title = titles.join(titleDelimeter) + '/'
    }

    const dbg = target === 'w:wait';


    var targets = target.split(destinationDelimeter); //eg: 'm:link'
    if (targets.length == 1) targets.unshift(defDestination); //eg: 'link', поэтому добавляем destination по умолчанию
    var name = targets[1];
    var namePrefix = '';



    var destinationTarget = targets[0]; //here eg: 'm'
    var destinationTargets = destinationTarget.split('_'); //eg: '_m:%method' \ak parent
    var destination = destinationTargets[0]; //case: 'link' ~> 'm'

    if (destinationTargets.length > 1) { //case: '_link'
        namePrefix = '_';
        destination = destinationTargets[1];
    }
    var destinationProp = destinationMap[destination]




    //_log('provide/destination', { src: targets, target: destinationTarget, targets: destinationTargets, name: name, nameprefix: propNameprefix })
    var propName = namePrefix + name;

    var method = provider[title + name];
//if (target === 'fetchData') debugger;
    //case: использование конструктора (_%name) для метода
    var methodConstructor = provider[title + constructorPrefix + name];
    if (methodConstructor) {
        method = methodConstructor.apply(null, args);
    }

    //if (dbg) debugger;
    
    if (!decl[destinationProp]) decl[destinationProp] = {};

    if (_.isObjectLike(method)) {

        decl[destinationProp][propName] = _.merge({}, method); //clone
    } else {
        decl[destinationProp][propName] = method;
    }


    /*switch (destination) {
        case 'w': {

        } break;
        default: {

        }
    }*/
})
