_selectSex_loadOptions: function(_set, result){
    var self = this;
    //_log('_selectSex_loadOptions', {})

    Api.assignArray({
        api: 'ui/select-sex',
        responseProp: ['data', 'options'],
        res: [self, 'selectSex'],
        busy: _set('busy'),
        cbRes: function(responseData){
            self.selectSexById = _.transform(responseData, function(res, item){
                res[item.value] = item;
            }, {})

            //_log('_selectSex_loadOptions/res', { responseData, byId: self.selectSexById })
            result();
        }
    });
},


selectSex_getOptions: function(set){
    var _set = makeSet(set);

    var self = this;
    var result = function(){
        var cloneOptions = _cc(self['selectSex']);
        var info = self['selectSexById'];
        //_log('selectSex_getOptions/res', { info, cloneOptions });
        _set.next(cloneOptions, info);
    }

    //_log('selectSex_getOptions', { data: this['selectSex'] })

    if (this['selectSex']) {
        result();
    } else {
        this._selectSex_loadOptions(_set, result);
    }

},
