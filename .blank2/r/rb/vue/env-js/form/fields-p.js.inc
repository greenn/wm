var fieldP = {};

//[007
fieldP.buildData = function(data, extend, dataIsCtx){
    if (dataIsCtx) {
        var ctx = data;
        data = ctx.data || {};
        _.each(ctx, function(val, name){
            if (name !== 'data') data[name] = val;
        })
    }


    var id = _.uniqueId();
    return _.defaults({}, extend, data, {
        id: id,
        name: '_' + id,
        value: '',
        label: false,
        placeholder: '',
        disabled: false,
        type: 'text',

        busy: false,
        validation: false,
        valid: false,

        under_validation: false,
    })
}


fieldP.makeItem = function(srcData){

    var data = _.clone(srcData);
    data = alignFieldData(data);

    var item = { data: data, srcData: srcData }

    item.name = data.name;

    item.vue = {
        //ncF: {}, //ak установка для nF
        //ncI: {},  //ak установка для nI
        value: data.value,
        label: data.label,
        placeholder: data.placeholder,
        disabled: data.disabled,
        type: data.type,

        busy: false,
        valid: !!!data.validation,
    }

    item.savedValue = data.value || '';
    item.value = function(){
        return this.vue.value;
    }
    item.setValue = function(val){
        this.vue.value = val;
        this.savedValue = val;
    }

    var underValidation = false;
    item.underValidation = function(/*setValue*/){
        if (arguments.length) {
            var setValue = arguments[0];
            underValidation = setValue
            this.vue.busy = setValue;
        }
    };
    item.valid = function(){
        return this.vue.valid;
    }
    item.setValid = function(val){
        this.vue.valid = val;
    };

    item.validate = function(setResult){
        item.underValidation(true);
        var result = true;
        if (data.validation) {
            if (data.validation === true) {
                result = !!this.value();
            }
        }
        if (setResult === true) {
            item.setValid(result);
        }
        return result;
    };
    item.isWarn = function(){
        //_log('fields-item/isWarn', { name: item.name, underValidation: item.underValidation, valid: item.valid })
        return item.underValidation() && !item.valid();
    }

    return item;
}