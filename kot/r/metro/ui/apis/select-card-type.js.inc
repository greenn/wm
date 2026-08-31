_selectCardType_loadOptions: function(_set, result){
    var self = this;
    //_log('_selectCardType_loadOptions', {})

    Api.assignArray({
        api: 'ui/select-card-type',
        responseProp: ['data', 'options'],
        res: [self, 'selectCardType'],
        busy: _set('busy'),
        cbRes: function(responseData){
            self.selectCardTypeById = _.transform(responseData, function(res, item){
                res[item.value] = item;
            }, {})

            //_log('_selectCardType_loadOptions/res', { responseData, byId: self.selectCardTypeById })
            result();
        }
    });
},


selectCardType_getOptions: function(set){
    var _set = makeSet(set);

    var self = this;
    var result = function(){
        var cloneOptions = _cc(self['selectCardType']);
        var info = self['selectCardTypeById'];
        //_log('selectCardType_getOptions/res', { info, cloneOptions });
        _set.next(cloneOptions, info);
    }

    //_log('selectCardType_getOptions', { data: this['selectCardType'] })

    if (this['selectCardType']) {
        result();
    } else {
        this._selectCardType_loadOptions(_set, result);
    }

},
