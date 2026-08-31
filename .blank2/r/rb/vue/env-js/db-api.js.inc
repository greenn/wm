//DbData
const DbApi = (function(){
    var db = {};

    //api(uri, data, success_cb)

    _.each({

        licenses: {}, //Вод. Удостоверение
        passports: {}, //Паспорта РФ
        bills: {}, //Счета оплаты
        damages: {}, //Фиксация порчи
        fines: {}, //штраф по прокату
        clients: {}, //Клиенты
        cards: {}, //Карта
        bookings: {}, //Бронирование
        pts: {}, //ПТС
        cars: {}, //Автомобили
        brands: {}, //Марка
        tariffs: {}, //Тарифы
        models: {}, //Модель
        penalties: {}, //Система штрафов

    }, function(cfg, table){
        //var table_nm = table + dbSuffix;

        var apis = {};

        var _uri = { base: cfg.uri || table };
        var take_uri = function(method){
            return [_uri.base, method].join('/')
        }
        _.each(['getAll', 'get', 'add', 'update', 'remove'], function(method){
            _uri[method] = take_uri(method);
        })
	    <? if (0) { ?>
        apis['getAll'] = function(cb) {
            var uri = _uri['getAll'];
            api(uri, {}, function (response) {
                Store.set([dbSuffix, table], response.data)
                cb();
            })
        }
        <? } ?>

        apis['getAll'] = function(cb, timeout){
            var data = Store.get([dbSuffix, table]);
	        <? if (0) { ?>
            if (!data) { //case: set def data
                data = DbData[table];
                //console.log('DBAPI:set', { nm: table, set: data });
                Store.set([dbSuffix, table], data)
            }
	        <? } ?>
            setTimeout(function(){
                cb({ data: data });
            }, timeout || 0);
        }

        apis['get'] = function(key, cb, timeout){
            var item = Store.get([dbSuffix, table, key]);
            setTimeout(function(){
                cb({ item: item });
            }, timeout || 0);
        }

        apis['add'] = function(item, cb, timeout){
            var data = Store.get([dbSuffix, table]);
            var key = parseInt(_.max(_.keys(data))) + 1;
            item.key = key;
            data[key] = item;
            Store.set([dbSuffix, table], data);

            setTimeout(function(){
                cb({ key: key, data: item });
                emittery.emit(table + '-add', [key, item]);
            }, timeout || 0);
        }

        apis['update'] = function(key, data, cb, timeout){
            var item = Store.get([dbSuffix, table, key]);
            _.extend(item, data)
            Store.set([dbSuffix, table, key], item);

            setTimeout(function(){
                cb({ update: data, data: item });
                emittery.emit(table + '-upd', [key, item, data]);
            }, timeout || 0);
        }

        apis['remove'] = function(key, cb, timeout){
            var data = Store.get([dbSuffix, table]);
            var item = data[key];
            var ok = !!item;
            if (item) {
                delete data[key]
            }
            Store.set([dbSuffix, table], data);

            setTimeout(function(){
                cb({ ok: ok, item: item, list: _.extend({}, data) });
                emittery.emit(table + '-remove', [ok, item, key]);
            }, timeout || 0);
        }

        db[table] = apis;

    });


    //console.log('DBAPI', db);
    return db;
})();