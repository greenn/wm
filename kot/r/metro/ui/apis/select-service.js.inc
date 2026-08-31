_selectService_loadOptions: function(_set, result){
    var self = this;
    //_log('_selectService_loadOptions', {})

    Api.assignArray({
        api: 'ui/select-service',
        responseProp: ['data', 'options'],
        res: [self, 'selectService'],
        busy: _set('busy'),
        cbRes: function(responseData){
            self.selectServiceById = _.transform(responseData, function(res, item){
                res[item.value] = item;
            }, {})

            //_log('_selectService_loadOptions/res', { responseData, byId: self.selectServiceById })
            result();
        }
    });
},


selectService_getOptions: function(set){
    var _set = makeSet(set);

    var self = this;
    var result = function(){
        var cloneOptions = _cc(self['selectService']);
        var info = self['selectServiceById'];
        //_log('selectService_getOptions/res', { info, cloneOptions });
        _set.next(cloneOptions, info);
    }

    //_log('selectService_getOptions', { data: this['selectService'] })

    if (this['selectService']) {
        result();
    } else {
        this._selectService_loadOptions(_set, result);
    }

},
