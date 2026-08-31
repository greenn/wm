_selectCarrier_loadOptions: function(_set, result){
    var self = this;
    //_log('_selectCarrier_loadOptions', {})

    Api.assignArray({
        api: 'ui/select-carrier',
        responseProp: ['data', 'options'],
        res: [self, 'selectCarrier'],
        busy: _set('busy'),
        cbRes: function(responseData){
            self.selectCarrierById = _.transform(responseData, function(res, item){
                res[item.value] = item;
            }, {})

            //_log('_selectCarrier_loadOptions/res', { responseData, byId: self.selectCarrierById })
            result();
        }
    });
},


selectCarrier_getOptions: function(set){
    var _set = makeSet(set);

    var self = this;
    var result = function(){
        var cloneOptions = _cc(self['selectCarrier']);
        var info = self['selectCarrierById'];
        //_log('selectCarrier_getOptions/res', { info, cloneOptions });
        _set.next(cloneOptions, info);
    }

    //_log('selectCarrier_getOptions', { data: this['selectCarrier'] })

    if (this['selectCarrier']) {
        result();
    } else {
        this._selectCarrier_loadOptions(_set, result);
    }

},
