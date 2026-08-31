_selectTimePreset_loadOptions: function(_set, dateType, result){
    var self = this;
    Api.assignArray({
        //dbg: true,
        api: dateType === 'date' ? 'ui/select-date-preset' : 'ui/select-time-preset',
        responseProp: ['data', 'options'],
        res: [self, 'selectTimePreset'],
        instantly: true,
        busy: _set('busy'),
        cbRes: function(responseData, response){
            self.selectTimePresetInfo = response.data.info;
            result()
        },
    });
},

selectTimePreset_getOptions: function(dateType, set){

    var self = this;
    var _set = makeSet(set);

    var result = function(){
        var cloneOptions = _cc(self['selectTimePreset']);
        var info = self['selectTimePresetInfo'];
        _set.next(cloneOptions, info);
    }

    //_log('selectStation_getOptions/0', { data: _cc(self['selectStation']) });
    if (self['selectTimePreset']) {
        //_log('selectStation_getOptions/res')
        result();
    } else {
        this._selectTimePreset_loadOptions(_set, dateType, result)
    }

},


<? if (0) { ?>
selectTimePreset_getOptions: function(dateType, set){
    var self = this;
    this.process_get({
        set: set,
        prop: 'selectTimePreset',
        //load: this._selectStation_loadOptions, loadArgs: [dateType],
        loadArgs: function(){
            self._selectTimePreset_loadOptions(this._set, dateType, this.result)
        },
        result: function(){
            var cloneOptions = _cc(self['selectTimePreset']);
            var info = self['selectTimePresetInfo'];
            this._set.next(cloneOptions, info);
        }
    })
}
<? } ?>
