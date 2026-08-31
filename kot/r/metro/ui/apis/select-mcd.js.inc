_selectMcd_loadOptions: function(_set, result){
    var self = this;
    //_log('_selectMcd_loadOptions', {})

    Api.assignArray({
        api: 'ui/select-mcd',
        responseProp: ['data', 'options'],
        res: [self, 'selectMcd'],
        busy: _set('busy'),
        cbRes: function(responseData){
            self.selectMcdById = _.transform(responseData, function(res, item){
                res[item.value] = item;
            }, {})

            //_log('_selectMcd_loadOptions/res', { responseData, byId: self.selectMcdById })
            result();
        }
    });
},


selectMcd_getOptions: function(set){
    var _set = makeSet(set);

    var self = this;
    var result = function(){
        var cloneOptions = _cc(self['selectMcd']);
        var info = self['selectMcdById'];
        //_log('selectMcd_getOptions/res', { info, cloneOptions });
        _set.next(cloneOptions, info);
    }

    //_log('selectMcd_getOptions', { data: this['selectMcd'] })

    if (this['selectMcd']) {
        result();
    } else {
        this._selectMcd_loadOptions(_set, result);
    }

},
