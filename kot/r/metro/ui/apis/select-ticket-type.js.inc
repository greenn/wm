_selectTicketType_loadOptions: function(_set, result){
    var self = this;
    //_log('_selectTicketType_loadOptions', {})

    Api.assignArray({
        api: 'ui/select-ticket-type',
        responseProp: ['data', 'options'],
        res: [self, 'selectTicketType'],
        busy: _set('busy'),
        cbRes: function(responseData){
            self.selectTicketTypeById = _.transform(responseData, function(res, item){
                res[item.value] = item;
            }, {})

            //_log('_selectTicketType_loadOptions/res', { responseData, byId: self.selectTicketTypeById })
            result();
        }
    });
},


selectTicketType_getOptions: function(set){
    var _set = makeSet(set);

    var self = this;
    var result = function(){
        var cloneOptions = _cc(self['selectTicketType']);
        var info = self['selectTicketTypeById'];
        //_log('selectTicketType_getOptions/res', { info, cloneOptions });
        _set.next(cloneOptions, info);
    }

    //_log('selectTicketType_getOptions', { data: this['selectTicketType'] })

    if (this['selectTicketType']) {
        result();
    } else {
        this._selectTicketType_loadOptions(_set, result);
    }

},
