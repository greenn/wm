<? if (0) { ?>
    selectStation_setColorData: function(dataList, colorMap){
        var options = [{ value: '', text: '- название станции -' }];

        _.each(dataList, function(list, headline) {
            options.push({
                value: headline, text: headline,
                disabled: true, style: { color: colorMap[headline] || '<?=_cssKot('warn-border')?>' }
            })
            _.each(list, function(item) {
                options.push({ value: item, text: item })
            })
        });

        return this.options = options;
    },
<? } ?>

_selectStation_loadOptions: function(_set, result){
    var self = this;
    Api.assignArray({
        api: 'ui/select-station',
        responseProp: ['data', 'options'],
        res: [self, 'selectStation'],
        busy: _set('busy'),
        cbRes: function(responseData){
            self.selectStationById = _.transform(responseData, function(res, item){
                res[item.value] = item;
            }, {})

            //_log('selectStation_getOptions/load')
            result();
        }
    });
},


selectStation_getOptions: function(set){
    var self = this;
    var _set = makeSet(set);

    var result = function(){
        var cloneOptions = _cc(self['selectStation']);
        var stations = self['selectStationById'];
        _set.next(cloneOptions, stations);
    }

    if (self['selectStation']) {
        result();
    } else {
        self._selectStation_loadOptions(_set, result);
    }

},

<? if (0) { ?>
selectStation_getOptions: function(set){
    var self = this;
    this.process_get({
        set: set,
        prop: 'selectStation',
        //load: this._selectStation_loadOptions, loadArgs: [],
        loadArgs: function(){
            self._selectStation_loadOptions(this._set, this.result)
        },
        result: function(){
            var cloneOptions = _cc(self['selectStation']);
            var stations = self['selectStationById'];
            this._set.next(cloneOptions, stations);
        }
    })
}
<? } ?>