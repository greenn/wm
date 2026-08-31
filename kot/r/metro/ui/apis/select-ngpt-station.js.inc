_selectNgptStation_loadOptions: function(_set, result){
    var self = this;
    //_log('_selectNgptStation_loadOptions', {})

    Api.assignArray({
        api: 'ui/select-ngpt-station',
        responseProp: ['data', 'optionsData'],
        res: [self, 'selectNgptStation'],
        busy: _set('busy'),
        cbRes: function(responseData){

            self.selectNgptStationById = _.transform(responseData, function(res, list, index){
                res[index] = _.transform(list, function(res2, item){
                    res2[String(item.value)] = item;
                }, {})
            }, [])

            //_log('_selectNgptStation_loadOptions/res', { responseData, byId: self.selectNgptStationById })
            result();
        }
    });
},


selectNgptStation_getOptions: function(set){
    var _set = makeSet(set);

    var self = this;
    var result = function(){
        var cloneOptions = _cc(self['selectNgptStation']);
        var info = self['selectNgptStationById'];
        //_log('selectNgptStation_getOptions/res', { info, cloneOptions });
        _set.next(cloneOptions, info);
    }

    //_log('selectNgptStation_getOptions', { data: this['selectNgptStation'] })

    if (this['selectNgptStation']) {
        result();
    } else {
        this._selectNgptStation_loadOptions(_set, result);
    }

},
