<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _rw::name('tool-admin');
headers('js', 'utf8', 'nosniff', etag::ctx(
	//etag::extra(),
	__FILE__
), SITE_CACHE);
?>

//step: добавляем api
var _log = Log.for('toolAdminApi/sd');

    var _api = Api.made('tool-admin', function(){

    })

//api: получение структуры sd-таблицы
api.sd_struct = function(sdName, cb){
    //Api.request.get('rw/tool-admin/sd/list', { sd: sdName, resProp: 'id' }, cb)
    Api.request.get('rw/tool-admin/sd/struct', { sd: sdName, get: 'fields' }, cb)
}

//получение листинга данных sd-таблицы
api.sd_list = function(sdName, cb){
    //Api.request.get('rw/tool-admin/sd/list', { sd: sdName, resProp: 'id' }, cb)
    Api.request.get('rw/tool-admin/sd/list', { sd: sdName, resProp: null }, cb)
}

api.sd_get = function(sdName, id, cb, cb_error){
    //Api.request.get('rw/tool-admin/sd/list', { sd: sdName, resProp: 'id' }, cb)
    Api.request.get('rw/tool-admin/sd/item', { sd: sdName, id: id }, function(response){
        _log('sd_get', { response, args: arguments });
        if (response.error) {
            cb_error({
                msg: response.error
            })
        } else if (response.item) {
            cb(response.item);
        } else {
            cb_error({
                msg: `Такого id нет: ${id}`,
                form: false
            });
        }
    })
}
    //await api_('sd_get', sdName, id, data);
    api.sd_get_ = async function(sdName, id, data){
        return new Promise(function(resolve, reject){
            api.sd_get(sdName, id, data, resolve, reject)
        })
    }


api.sd_create = function(sdName, data, cb, cb_error){
    //Api.request.put('rw/tool-admin/sd/item', { sd: sdName, data: data, cb, cb_error}
    Api.request.put('rw/tool-admin/sd/item', { sd: sdName, data: data }, function(response){
        _log('sd_create', { response, args: arguments });
        cb(response);
    })
}

api.sd_update = function(sdName, id, data, cb, cb_error){
    Api.request.patch('rw/tool-admin/sd/item', { sd: sdName, data: data, id: id }, function(response){
        _log('sd_update', { response, args: arguments });
        cb(response);
    })
}


api.sd_remove = function(sdName, id, cb, cb_error){
    Api.request.delete('rw/tool-admin/sd/item', { sd: sdName, id: id }, function(response){
        _log('sd_remove', { response, args: arguments });
        cb(response);
    })
}

<? if (0) { ?>
api.sd = {
    struct: null,
    get_struct: function(){

    },

    ...(function(){
        var struct = {}
        return {
            struct: function(){},
            get_struct: function(){},
            struct_get: function(){},
        }
    })(),



    list: null,
    get_list: function(){

    }
}
<? } ?>