_selectCardStatus_loadOptions: function(_set, result){
    var self = this;
    //_log('_selectCardStatus_loadOptions', {})

    Api.assignArray({
        api: 'ui/select-card-status',
        responseProp: ['data', 'options'],
        res: [self, 'selectCardStatus'],
        busy: _set('busy'),
        cbRes: function(responseData){
            self.selectCardStatusById = _.transform(responseData, function(res, item){
                res[item.value] = item;
            }, {})

            //_log('_selectCardStatus_loadOptions/res', { responseData, byId: self.selectCardStatusById })
            result();
        }
    });
},


selectCardStatus_getOptions: function(set){
    var _set = makeSet(set);

    var self = this;
    var result = function(){
        var cloneOptions = _cc(self['selectCardStatus']);
        var info = self['selectCardStatusById'];
        //_log('selectCardStatus_getOptions/res', { info, cloneOptions });
        _set.next(cloneOptions, info);
    }

    //_log('selectCardStatus_getOptions', { data: this['selectCardStatus'] })

    if (this['selectCardStatus']) {
        result();
    } else {
        this._selectCardStatus_loadOptions(_set, result);
    }

},
