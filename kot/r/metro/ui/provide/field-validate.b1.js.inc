_vue.providerOpt['ui/field/validate'] = {};

_vue.providerDep['ui/field/validate'] = [
    'ui/field/p:validate',
    'ui/field/d:validate',
    'ui/field/isValid',
    'ui/field/showWarn',
    'ui/field/w:value',
    'ui/field/w:valid',
    'ui/field/w:relValid',
];

_vue.provider['ui/field/p:validate'] = ['relValid'];

_vue.provider['ui/field/d:validate'] = function(val){
    return {
        valid: null,
        on_validate: false, //01
        validateOnChange: false,
        stopValidateOnSuccess: false,

        warnInput: false,
        warnTooltip: false,

        msgWarnDef: 'Необходимо заполнить это поле',
    }
}


_vue.provider['ui/field/validate'] = function(set, setFocus){
    var self = this;
    var _set = makeSet(set);
    _set.fetch(this, ['isValid', 'validateOnChange', 'stopValidateOnSuccess'])
    /*if (set) _.each(['isValid', 'validateOnChange', 'stopValidateOnSuccess'], function(prop){
        if (set.hasOwnProperty(prop)) self[prop] = set[prop]
    })*/

    this.on_validate = true; //01
    this.valid = this.isValid(this.value);
    this.log('validate', { res: this.valid, value: this.value, name: this.name1,
        set: _clone(set), validateOnChange: this.validateOnChange, stopValidateOnSuccess: this.stopValidateOnSuccess,
    })
    if (!this.valid && setFocus && this.setFocus) this.setFocus();

    //_set.next(this.valid);

    return this.valid;
};

//дефолтный метод, может быть перезаписан
_vue.provider['ui/field/isValid'] = function(val){
    return !!val;
},

_vue.provider['ui/field/showWarn'] = function(state){
    this.warnInput = state; //показываем warn-input
    this.warnTooltip = state; //показываем warn-tooltip
}

_vue.provider['ui/field/w:value'] = function(val){
    //this.log('w|provide:value', { val, 'validate?': this.validateOnChange });
    if (this.validateOnChange) {
        this.validate();
    }
}

//для указанного prop relValid
_vue.provider['ui/field/w:relValid'] = function(val){
    //this.log('w:relValid', { relValid: val, valid: this.valid })
    this.valid = val;
}

_vue.provider['ui/field/w:valid'] = function(val){
    //this.log('w:valid', { val });
    this.showWarn(!val);
    if (val && this.stopValidateOnSuccess) {
        this.on_validate = false; //01
        this.validateOnChange = false;
    }
}
