ProviderDep.regParent = ['applyRealParentMethod', 'applyParentMethod'];
Provider._regParent = function(set){
    var methodPropName = set.method;
    var parentName = set.parent;

    return function(){
        var methodName = this[methodPropName];
        console.log('regParent', { methodPropName, methodName });
        if (parentName) {
            this.applyParentMethod(parentName, methodName, this)
        } else {
            this.applyRealParentMethod(methodName, this)
        }
    }
}



Provider._regField = function(fieldsProp){
    if (fieldsProp !== false) //можно отключить
    if (!fieldsProp || fieldsProp === true) fieldsProp = 'fields';
    //_log('_regField', { fieldsProp, type: typeof fieldsProp });
    return function regField(field, name){
        if (!name) name = field.name
        //_log('regField', { fieldsProp, this: this, name: name, field: field });
        if (fieldsProp) {
            //if (!this[fieldsProp]) this[fieldsProp] = {}; 01 - пускай луше вылетает ошибка
            this[fieldsProp][name] = field;
        } else {
            this[name] = field;
        }

        //this._log('regField', { name, field });
    }
};

Provider._regButton = function(propMap){
    if (!propMap || propMap === true) propMap = {};
    //_log('_regButton|0', { propMap, type: typeof propMap });
    return function regButton(button, name){
        //_log('_regButton|1', { propMap, name, button: _clearObject(button), self: _clearObject(this) });
        if (!name) name = button.name;
        var prop = propMap[name] || name;
        this.$data[prop] = button;
        //this._log('regButton|2', { prop, $data: _clearObject(this.$data) });
    }
};

//4.0.1
Provider._regView = function(propMap, parentProp, optStackSame){
    if (!propMap || propMap === true) propMap = {};
    if (typeof propMap === 'string') { //case: опускание propMap
        if (!parentProp) parentProp = propMap;
        propMap = {};
    }
    if (typeof optStackSame === 'undefined') optStackSame = true;
    //_log('_regView|0', { args: arguments });
    return function regView(view, name){
        if (!name) {
            name = view.name || view.viewName || view._name
        }
        var prop = propMap[name] || name;

        //this._log('PROVIDER:_regView', { propMap, name, parentProp, prop, 'view.name': view.name, 'view._name': view._name });

        this.$data._viewName = prop;

        if (parentProp) {
            if (!this.$data[parentProp]) this.$data[parentProp] = {};
            if (_.isArray(this.$data[parentProp])) {
                this.$data[parentProp][prop].push(view);
            } else {
                if (this.$data[parentProp][prop]) {
                    if (optStackSame) {
                        if (!_.isArray(this.$data[parentProp])) {
                            var soleItem = this.$data[parentProp][prop];
                            this.$data[parentProp][prop] = [soleItem];
                        }
                        this.$data[parentProp][prop].push(view);
                    } else {
                        this.$data[parentProp][prop] = view;
                    }
                } else {
                    this.$data[parentProp][prop] = view;
                }

            }

        } else {
            this.$data[prop] = view;
        }

    }
};