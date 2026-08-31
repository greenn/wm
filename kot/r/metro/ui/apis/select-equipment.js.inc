_selectEquipment_loadOptions: function(_set, result){
    var self = this;
    //_log('_selectEquipment_loadOptions', {})

    Api.assignArray({
        api: 'ui/select-equipment',
        responseProp: ['data', 'options'],
        res: [self, 'selectEquipment'],
        busy: _set('busy'),
        cbRes: function(responseData){
            self.selectEquipmentById = _.transform(responseData, function(res, item){
                res[item.value] = item;
            }, {})

            //_log('_selectEquipment_loadOptions/res', { responseData, byId: self.selectEquipmentById })
            result();
        }
    });
},


selectEquipment_getOptions: function(set){
    var _set = makeSet(set);

    var self = this;
    var result = function(){
        var cloneOptions = _cc(self['selectEquipment']);
        var info = self['selectEquipmentById'];
        //_log('selectEquipment_getOptions/res', { info, cloneOptions });
        _set.next(cloneOptions, info);
    }

    //_log('selectEquipment_getOptions', { data: this['selectEquipment'] })

    if (this['selectEquipment']) {
        result();
    } else {
        this._selectEquipment_loadOptions(_set, result);
    }

},
