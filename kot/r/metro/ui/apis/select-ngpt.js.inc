_selectNgpt_loadOptions: function(_set, result){
    var self = this;
    //_log('_selectNgpt_loadOptions', {})

    Api.assignArray({
        api: 'ui/select-ngpt',
        responseProp: ['data', 'options'],
        res: [self, 'selectNgpt'],
        busy: _set('busy'),
        cbRes: function(responseData){
            self.selectNgptById = _.transform(responseData, function(res, item){
                res[item.value] = item;
            }, {})

            //_log('_selectNgpt_loadOptions/res', { responseData, byId: self.selectNgptById })
            result();
        }
    });
},


selectNgpt_getOptions: function(set){
    var _set = makeSet(set);

    var self = this;
    var result = function(){
        var cloneOptions = _cc(self['selectNgpt']);
        var info = self['selectNgptById'];
        //_log('selectNgpt_getOptions/res', { info, cloneOptions });
        _set.next(cloneOptions, info);
    }

    //_log('selectNgpt_getOptions', { data: this['selectNgpt'] })

    if (this['selectNgpt']) {
        result();
    } else {
        this._selectNgpt_loadOptions(_set, result);
    }

},
