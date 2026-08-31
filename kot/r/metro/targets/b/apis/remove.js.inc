//попап с возможным процессом удаления элемента из спсика
itemRemove_popup(item, set) {
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
},

//процесс (api, sys-msg, store) удаления элемента из спсика
itemRemove(item, set) {//itemRemove
    var _set = makeSet(set);
    //_log('itemRemove', { item, set })
    Api.request.delete('targets/item', { id: item.uid }, {
        success: function(response){
            //_log('delete/response', { response, set })

            _r('sys-msg', 'showSuccess', 'Шаблон таргета был удалён')

            _Targets.dispatch('listRemove', _set.extend({
                item: item
            }));

        },
        //after: function(){}
    })
},