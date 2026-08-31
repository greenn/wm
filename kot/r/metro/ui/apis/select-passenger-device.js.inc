_selectPassengerDevice_loadOptions: function(_set, result){
    var self = this;
    //_log('_selectPassengerDevice_loadOptions', {})

    Api.assignArray({
        api: 'ui/select-passenger-device',
        responseProp: ['data', 'options'],
        res: [self, 'selectPassengerDevice'],
        busy: _set('busy'),
        cbRes: function(responseData){
            self.selectPassengerDeviceById = _.transform(responseData, function(res, item){
                res[item.value] = item;
            }, {})

            //_log('_selectPassengerDevice_loadOptions/res', { responseData, byId: self.selectPassengerDeviceById })
            result();
        }
    });
},


selectPassengerDevice_getOptions: function(set){
    var _set = makeSet(set);

    var self = this;
    var result = function(){
        var cloneOptions = _cc(self['selectPassengerDevice']);
        var info = self['selectPassengerDeviceById'];
        //_log('selectPassengerDevice_getOptions/res', { info, cloneOptions });
        _set.next(cloneOptions, info);
    }

    //_log('selectPassengerDevice_getOptions', { data: this['selectPassengerDevice'] })

    if (this['selectPassengerDevice']) {
        result();
    } else {
        this._selectPassengerDevice_loadOptions(_set, result);
    }

},
