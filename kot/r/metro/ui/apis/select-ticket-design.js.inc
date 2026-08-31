_selectTicketDesign_loadOptions: function(_set, result){
    var self = this;
    //_log('_selectTicketDesign_loadOptions', {})

    Api.assignArray({
        api: 'ui/select-ticket-design',
        responseProp: ['data', 'options'],
        res: [self, 'selectTicketDesign'],
        busy: _set('busy'),
        cbRes: function(responseData){
            self.selectTicketDesignById = _.transform(responseData, function(res, item){
                res[item.value] = item;
            }, {})

            //_log('_selectTicketDesign_loadOptions/res', { responseData, byId: self.selectTicketDesignById })
            result();
        }
    });
},


selectTicketDesign_getOptions: function(set){
    var _set = makeSet(set);

    var self = this;
    var result = function(){
        var cloneOptions = _cc(self['selectTicketDesign']);
        var info = self['selectTicketDesignById'];
        //_log('selectTicketDesign_getOptions/res', { info, cloneOptions });
        _set.next(cloneOptions, info);
    }

    //_log('selectTicketDesign_getOptions', { data: this['selectTicketDesign'] })

    if (this['selectTicketDesign']) {
        result();
    } else {
        this._selectTicketDesign_loadOptions(_set, result);
    }

},
