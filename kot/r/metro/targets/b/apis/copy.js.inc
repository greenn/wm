itemCopy_popup: function(item, set) {
    //_log('itemCopy_popup', { item, set })
    var self = this;
    var _set = makeSet(set);

    _r('popup', 'content', {
        headline: 'Копирование шаблона таргета',
        msg: `Копировать шаблон таргета?`, //#${item.uid}
        submit: {
            title: 'Копировать',
            click: function(closePopup, Popup){
                //_log('itemAproove_popup/click', { set })
                self.itemCopy(item, _set.extend({
                    next: closePopup
                }));
                return false; //остановить автозакрытие popup
            }
        }
    })
},

itemCopy(item, set) {
    var _set = makeSet(set);
    Api.request.post('targets/copy', { id: item.uid }, {
        success: function(response){
            _log('copy/response', { response, set: _set.ctx() })

            _r('sys-msg', 'showSuccess', 'Шаблон таргета скопирован')

            _Targets.dispatch('listAdd', _set.extend({
                item: response.data['new-item'],
                nextArgs: [response],
            }));
        },
    })
},