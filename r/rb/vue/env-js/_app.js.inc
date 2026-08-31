//#0.4.138-232 - eventCar
const _app = (function(){
    const list = {};
    
    const _index = {
        regex: new RegExp('\\.([\\d]+)$'), //https://regex101.com/r/EIJ4kk/1
       
        has: function(str){
            return str.match(this.regex)
        },
        get: function(str){
            var match = this.regex.exec(str)
            return match && parseInt(match[1]);
        },
        cut: function(str){
            return str.replace(this.regex, '');
        },
        name: function(name, num){ //pattern|name
            return name + '.' + num;
        },
        normalize: function(name){ //normalize|name
            return this.has(name) ? name : this.name(name, 1);
        },
        num: function(name){ //name|parse|index|num
            return this.get(name) || 1;
            //return this.has(name) ? this.get(name) : 1;
        },
        cur: function(name){
            return this.name(name, list[name].length);
        },
        nextNum: function(name){
            return list[name] ? list[name].length + 1 : 1
        }
    }

    
    const add = function(name, obj){
        if (!list[name]) list[name] = [];
        list[name].push(obj);
        return _index.cur(name);
    }
    
    const get = function(agrName){

        var index = _index.num(agrName) - 1;
        var name = _index.cut(agrName);
        //console.log('_app', { index, name, list: _.keys(list) })
        //!!!! что-то не так с этим местом
        if(!list[name]) {
            //_log.warn - не работает
            console.warn('_app.get()', {
                list: _clone(list),
                name: name,
                index: index,
                agrName: agrName,
            })
        }
        return list[name][index];
    }

    const call = function(obj, method, args){
        if (!1) console.log('_app|call', {
            name: name,
            method: method,
            obj: obj,
            //'obj.hasOwnProperty(method)': obj && obj.hasOwnProperty && obj.hasOwnProperty(method),
            'typeof obj[method]': obj && typeof obj[method],
            'obj[method]': obj[method]
        });

        if (typeof obj[method] == 'function') {
            return obj[method].apply(obj, args);
        } else {
            if (args[0]) {
                obj[method] = args[0];
            } else {
                return obj[method];
            }
        }
    }

    const app = function(name, method/*, args*/){
        name = _index.normalize(name);
        const obj = get(name);
        if (!method) return obj;
        const args = Array.prototype.slice.call(arguments, 2);

        if (obj) {
            return call(obj, method, args);
        } else emittery.on('app-init-' + name, function(obj){
            call(obj, method, args);
        });
    };

    app.init = function(name, obj){
        name = add(name, obj);
        emittery.emit('app-init' + name, obj);
    }

    app.dbg = function(){
        console.log('_app/dbg', list);
    }
    app.dbgList = function(keys){
        var result = list;
        if (keys) result = _.keys(result);
        return result;
    }

    app.nextName = function(name){
        var num = _index.nextNum(name);
        return num === 1 ? name : _index.name(name);
    }

    app.curNum = function(name){
        return _index.nextNum(name) - 1
    }
    app.nextNum = _index.nextNum.bind(_index);
    return app;
})()
