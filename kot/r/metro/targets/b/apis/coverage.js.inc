calcCoverage: function(id, set){
    var _set = makeSet(set);

    //_log('calcCoverage', { id });

    _set.busy(true);

    Api.request.post('targets/forecast', {
        'id': id
    }, {
        success: function(response){
            //_log('calcCoverage/response', { response })

            _Targets.dispatch('itemUpdate', {
                update: {
                    uid: id,
                    data: response.data,
                },
                busy: _set('busy'),
                //next: _set('next'),
                //next: _set.next,
            });

            //_set.next(response.data.forecast)

        },
        after: function(){
            _set.busy(false);
        }
    }, {
        //emu: true
    })

},



calcCoverage_batch(id_list, set){
    //_log('calcCoverage_batch', { id_list })
    var _set = makeSet(set);

    _set.busy(true);

    Api.request.post('targets/forecast/batch', {
        'id-list': id_list
    }, {
        success: function(response){
            //_log('calcCoverage_batch/response', { list: response.data.list, response })

            _.each(response.data.list, function(data, id){

                var updateData = {
                    uid: id,
                    data: data,
                };

                _Targets.dispatch('itemUpdate', {
                    update: updateData,
                    busy: _set('busy'),
                    next: function(data){
                        //_log('afterUpdate', { updateData, data })
                    }
                });

            })
        },
        after: function(){
            _set.busy(false);
        }
    }, {
        //emu: true
    })
},

calcCoverage_aggregate: function(targets, set){
    var _set = makeSet(set);

    var id = _set('id')

    //_log('calcCoverage-aggregate', { id, targetsData: _clone(targets) });

    _set.busy(true);

    Api.request.post('targets/forecast/aggregate', { targets }, {
        success: function(response){
            //_log('calcCoverage-aggregate/response',  { response, busyCtx: _set('busy') })
            //_log('calcCoverage-aggregate/response',  { responseData: response.data, response })
            //return;
            if (!response || !response.data || !response.data.coverage) {
                _log('ошибка', { targets: _cc(targets), response });
                _set.next(100)
                return;
            }
            var coverageValue = response.data.coverage;
            if (id) {//ak targetItemId
                _Targets.dispatch('itemUpdate', {
                    update: {
                        uid: id,
                        data: { forecast: coverageValue },
                    },
                    busy: _set('busy')
                });
            }

            _set.next(coverageValue)
        },
        after: function(){
            _set.busy(false);
        }
    }, {
        //emu: true
    })

},