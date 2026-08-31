function(itemFields){
    var data = {};
    var _valid = true;
    _app('system-modal', 'clearAll');

    _.each(itemFields, function(field, name){
        data[name] = field.value();
        field.validate(true);
        var valid = field.valid()
        _valid *= valid;
        if (!valid) {
            _app('system-modal', 'msg_error', {
                'title': 'Ошибка Валидации',
                'msg': 'Заполните поле: ' + field.data.label,
            }, false && 3000);
        }
        //_log('fieldsValue:item', name, { valid: field.valid(), field: field } )

    });

    return _valid && data;
}