_extension.methods.itemUpdate = function(data, set) {
    _log('itemUpdate', { data, set })

    var _set = makeSet(set);
    _set.busy(true);

    Api.request.put(`${_apiBase}/update`, data, {
        success: function(response){
            _log('update/response', { response });
            _delay(500, function(){

                if (!1) {
                    _Vuex.dispatch('itemSet', {
                        item: response.data['item'],
                        busy: [self, 'busy'],
                    });
                } else {
                    var updateData = {
                        uid: response.data['id'],
                        data: response.data['item'],
                    };

                    _Vuex.dispatch('itemUpdate', {
                        update: updateData,
                        busy: _set('busy'),
                        next: function(data){
                            //_log('afterUpdate', { updateData, data })
                        }
                    });
                }

                _r('sys-msg', 'showSuccess', 'Запись была обновлена')

                _set.next();
            })
        },

        after: function(){
            _set.busy(false);
        }

    }, {
        emu: <?= gt_on('all') ? 'false' : 'true'?>
    })
}
