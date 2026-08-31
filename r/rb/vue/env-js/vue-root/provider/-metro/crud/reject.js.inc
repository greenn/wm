_extension.methods.itemReject_popup = function(item, set) {
    _log('itemReject_popup', { item, set })

    var self = this;
    var _set = makeSet(set);

    _r('popup', 'content', {
        headline: 'Изменение статуса шаблона', //Отклонение согласования шаблона таргета
        msg: `Изменить статус на "Не активен"?`,
        submit: {
            title: 'Поменять',
            click: function(closePopup, Popup){
                //_log('itemReject/click', { set })
                self.itemReject(item, _set.extend({
                    next: closePopup
                }));
                return false; //остановить автозакрытие popup
            }
        }

    })
}

_extension.methods.itemReject = function(item, set) {
    _log('itemReject', { item, set })
    var _set = makeSet(set);
    Api.request.patch(`${_apiBase}/reject`, { id: item.uid }, {
        success: function(response){
           //_log('reject/response', { item: response.data.item, response, set })

            _r('sys-msg', 'showSuccess', 'Статус шаблона изменён') //Согласование шаблона таргета отклонено

            _Vuex.dispatch('itemSet', _set.extend({
                item: response.data.item
            }));
        },
    }, {
        emu: true
    })
}