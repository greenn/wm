_extension.methods.itemCreate = function(fieldsData, set) {
    //_log('itemCreate', { fieldsData, set, _fieldsData: _cc(fieldsData) })

    var _set = makeSet(set);

    _set.busy(true);

    Api.request.post(`${_apiBase}/create`, {
        fields: fieldsData,
    }, {
        success: function(response){
            //_log('api/response', { response })

            //self.busyForm = false;
            //_log.timeEnd('submit');

            _delay(500, function(){
                _r('sys-msg', 'showSuccess', 'Запись была добавлена')
                //_r('targets-list', 'addItem', response.data.item)

                _set.next();

                    //self.linkPar();

                /*if (confirm('linkPar')) {
					_log('goTo', 'linkPar');
					self.linkPar();
				}*/

            })

        },

        after: function(){
            _set.busy(false);
        }

    }, {
        emu: <?= gt_on('all') ? 'false' : 'true'?>
    })


}
