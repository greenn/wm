
__root.componentCall = function(cmptName, propName, arg1/*, argN*/){
    //Array.prototype.slice.call(arguments, 2);
    var argsN = arguments.length;
    var args = _.slice(arguments, 2);

    var cmpt = __root.getComponent(cmptName);

    ///_log('componentCall', { cmptName, cmpt, argsN, propName, method: cmpt[propName], typeof: typeof cmpt[propName], args})
    //_log('O_O', { propName, typeof: cmpt && typeof cmpt[propName], argsN, cmpt })

    <? if (0) { ?>

    if (argsN === 1) return cmpt;
    if (cmpt) {
        if (typeof cmpt[propName] === 'function') {
            return cmpt[propName].apply(cmpt, args);
        } else {
            if (argsN === 2) return cmpt[propName];
            else if (argsN === 3) {
                var value = _.isFunction(arg1) ? arg1.call(cmpt, /*curValue*/cmpt[propName], propName) : arg1;
                cmpt[propName] = value;
            }
        }
    }

	<? } ?>

    var _case;

    if (argsN === 1) _case = 1;
    if (cmpt) {
        if (typeof cmpt[propName] === 'function') {
            _case = 2
        } else {
            if (argsN === 2) {
                _case = 3
            } else if (argsN === 3) {
                _case = 4;
                if (_.isFunction(arg1)) _case = 5;
            }
        }
    }

    switch (_case) {
        case 1: { //_r('app')
            return cmpt;
        } break;
        case 2: {
            return cmpt[propName].apply(cmpt, args);
        } break;
        case 3: {
            return cmpt[propName];
        } break;
        case 4: case 5: {
            var value = arg1;
            if (_case === 5) {
                value = arg1.call(cmpt, /*curValue*/cmpt[propName], propName)
            }
            cmpt[propName] = value;
        } break;
    }
}