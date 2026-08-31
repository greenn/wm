_selectCardFactor_loadOptions: function(_set, result){
    var self = this;
    //_log('_selectCardFactor_loadOptions', {})

    Api.assignArray({
        api: 'ui/select-card-factor',
        responseProp: ['data', 'options'],
        res: [self, 'selectCardFactor'],
        busy: _set('busy'),
        cbRes: function(responseData){
            self.selectCardFactorById = _.transform(responseData, function(res, item){
                res[item.value] = item;
            }, {})

            //_log('_selectCardFactor_loadOptions/res', { responseData, byId: self.selectCardFactorById })
            result();
        }
    });
},


selectCardFactor_getOptions: function(set){
    var _set = makeSet(set);

    var self = this;
    var result = function(){
        var cloneOptions = _cc(self['selectCardFactor']);
        var info = self['selectCardFactorById'];
        //_log('selectCardFactor_getOptions/res', { info, cloneOptions });
        _set.next(cloneOptions, info);
    }

    //_log('selectCardFactor_getOptions', { data: this['selectCardFactor'] })

    if (this['selectCardFactor']) {
        result();
    } else {
        this._selectCardFactor_loadOptions(_set, result);
    }

},
