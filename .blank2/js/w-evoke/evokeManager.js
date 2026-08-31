//1.2.2 - отложенные вызовы
var evokeManager = function(){
    return {
        ready: {},
        list: {},
        //dbg-method
        listState: function(){
            return _.transform(this.list, function(res, item$, name){
                res[name] = item$.state()
                return res;
            }, {});
        },

        provide: function (name) {
            if (!this.list.hasOwnProperty(name)) {
                //console.log('evoke::provide', [name]);
                this.list[name] = $.Deferred();
            }
            return this.list[name];
        },
        set: function (name, res) {
            var self = this;
            var item$ = this.provide(name);
            $.when(res).then(function () {
                //console.log('__item:resolve', [name, res, arguments[0]])
                item$.resolve();
                self.ready[name] = true;
            })
        },
        when: function (names) {
            var items$ = _.transform(names, function (items, name) {
                var item$ = evoke.provide(name);
                items.push(item$)
            }, []);
            //console.log('evoke:when', names, items$);
            return $.when.apply($, items$);
        },
        after: function (names, caller, selfName) {
            //console.log('evoke/when //// ', names);
            this.when(names).then(function () {
                //console.log('evoke:after', selfName, names, caller);
                if (caller) {
                    var fn = caller[0];
                    var args = caller[1] || [];
                    var this_ = caller[2] || null;
                    //caller;
                    //console.log('evoke/after', selfName, caller);
                    //debugger;
                    var res = fn.apply(this_, args);
                } else {
                    //нужно просто соблюсти evoke.set
                    //например для .wait в интеграторе [#pr2021-1]
                }
                if (selfName) {
                    evoke.set(selfName, res);
                }
            });
        }
    }
}


evoke = evokeManager();
