//#0.5.10 сменить значение не противоположное
_vue.provider.toggleValue = function(prop){ //mb, state - принудительное значение (а не текущее), от которого брать противиолложное
    var isComplexKey = typeof prop === 'string' && (prop.includes('.') || prop.includes('[') || prop.includes(']'));
    var value = isComplexKey || _.isArray(prop) ? _.get(this, prop) : this[prop];

    var reverseValue = !value;

    isComplexKey || _.isArray(prop) ? _.set(this, prop, reverseValue) : this[prop] = reverseValue;

    <? if (0) { ?>
        this.clog('toggleValue', { prop, reverseValue, value,
            isComplexKey,
            isArray: _.isArray(prop),
            valueVerify: _.isArray(prop) ? _.get(this, prop) : this[prop]
        });
	<? } ?>
},