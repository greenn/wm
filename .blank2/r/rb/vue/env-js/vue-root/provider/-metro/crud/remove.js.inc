//попап с возможным процессом удаления элемента из спсика
_extension.methods.itemRemove_popup = function(item, set) {
    var self = this;
    var _set = makeSet(set);
    //_log('itemRemove_popup', { item })
    _r('popup', 'content', {
        headline: 'Удаление шаблона таргета',
        msg: `Удалить шаблон таргета #${item.uid}?`,
        submit: {
            title: 'Удалить',
            click: function(closePopup, Popup){
                self.itemRemove(item, _set.extend({
                    next: closePopup
                }));
                return false; //остановить автозакрытие popup
            }
        },
        cancel: {
            click: function(){
                //self.open = false;
            }
        }

    })
}

//процесс (api, sys-msg, store) удаления элемента из спсика
_extension.methods.itemRemove = function(item, set) {//itemRemove
    var _set = makeSet(set);
    //_log('itemRemove', { item, set })
    Api.request.delete(`${_apiBase}/item`, { id: item.uid }, {
        success: function(response){
            //_log('delete/response', { response, set })

            _r('sys-msg', 'showSuccess', 'Шаблон таргета был удалён')

            _Vuex.dispatch('listRemove', _set.extend({
                item: item
            }));

        },
        //after: function(){}
    }, {
        emu: true
    })
}