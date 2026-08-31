itemAproove_popup: function(item, set) {
    _log('itemAproove_popup', { item, set })
    var self = this;
    var _set = makeSet(set);

    _r('popup', 'content', {
        headline: 'Изменение статуса шаблона', //Согласование шаблона таргета
        msg: `Изменить статус на "Действующий"?`, //#${item.uid}
        submit: {
            title: 'Поменять',
            click: function(closePopup, Popup){
                //_log('itemAproove_popup/click', { set })
                self.itemAproove(item, _set.extend({
                    next: closePopup
                }));
                return false; //остановить автозакрытие popup
            }
        }
    })
},

itemAproove(item, set) {
    _log('itemAproove', { item, set })
    var _set = makeSet(set);
    Api.request.patch('targets/aproove', { id: item.uid }, {
        success: function(response){
            //_log('aproove/response', { item: response.data.item, response, set })

            _r('sys-msg', 'showSuccess', 'Статус шаблона изменён') //Шаблон таргета отправлен на согласование

            _Targets.dispatch('itemSet', _set.extend({
                item: response.data.item
            }));

        },
    })
},
