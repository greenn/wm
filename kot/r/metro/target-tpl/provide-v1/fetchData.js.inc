//_vue.provider['[target-tpl]fetchData'] = function(data){}
//_vue.provider['targetTpl/fetchData'] = function(data){}
//_vue.provider['(targetTpl)fetchData'] = function(data){}

_vue.provider['target-tpl/fetchData'] = function(data){
    _.merge(this.cfg, data, function(selfValue, newValue) {
        if (_.isUndefined(newValue)) {
            return selfValue;
        }
    })
};