//_vue.provider['[target-tpl]fetchData'] = function(data){}
//_vue.provider['targetTpl/fetchData'] = function(data){}
//_vue.provider['(targetTpl)fetchData'] = function(data){}

_vue.provider['target-tpl/_validate'] = function(set){
    if (!set) set = { itemsProp: 'validateItems' }
    var itemsProp = set.itemsProp || 'validateItems'
    return function validate(){
        //this.log('validate', { items: this[itemsProp] });
        var self = this;
        var res = true;
        var itemRes;
        var setFocus = false;
        _.each(this[itemsProp], function(item){
            self.log('validate/each', { item: _cc(item), on_validate: item.on_validate, valid: item.valid })
            itemRes = item.ref.validate({
                validateOnChange: true,
                stopValidateOnSuccess: true,
                isValid: item.isValid,
                /*isValid: item.isValid || function(value){
                    //return value.length > 3; //dbg
                    return value !== '';
                },*/
            }, !setFocus); //проставить фокус, если не он проставлен до этого

            if (!itemRes && !setFocus) setFocus = false; //убираем флаг 'проставить-фокус'

            res *= itemRes;

        })
        return res
    }
};