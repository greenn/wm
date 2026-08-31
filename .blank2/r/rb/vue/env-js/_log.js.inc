//#4.2.11 - logger
<?/*
    oo js/w/llog.js.php
*/?>

const Log = (function(){
    return {
        'for': function(baseTitle){ //|for|build

            var list = {};
            var stop = function(act){
                return list[act] === 0 || list[act] === false;
            }

            var method = 'log';
            var log = function(title/*, arg1, argN */){
                var args = Array.prototype.slice.call(arguments, 1)
                var act = title;
                if (_.isArray(title)) {
                    act = title[0];
                    title = title.join('|');
                }

                if (stop(act) || stop(title)) return;
                args.unshift(log.title(title));
                //console.log.apply(console, args)
                console[method].apply(console, args)
            };

            log.title = function(title){
                return [baseTitle + log.indexTitle(), title].join('¦')
            }

            log.warn = function(){
                //var args = Array.prototype.slice.call(arguments)
                //var args = [...arguments];
                method = 'warn';
                log.apply(null, args);
                method = 'log';
            };


            log.set = function(act, state){
                list[act] = state;
            }
            log.set_ = function(acts){
                _.each(acts, function(state, act){
                    log.set(act, state)
                })
            }
            log.index = 0;
            log.indexTitle = function(){
                var index = typeof log.index == 'function' ? log.index() : log.index;
                return index ? '.' + index : '';
            };
            log.changeBaseTitle = function(title){
                baseTitle = title;
            }

            var timeItemTitles = {}
            var timeItemTitle = function(title, set){
                if (timeItemTitles[title] === undefined) timeItemTitles[title] = 0;
                var num = set ? ++timeItemTitles[title] : timeItemTitles[title];
                return `${title}[${num}]`;
            }

            log.timeItem = function(timeTitle, ...args){
                this.time(timeItemTitle(timeTitle, true), ...args);
            }
            log.timeItemEnd = function(timeTitle, ...args){
                this.timeEnd(timeItemTitle(timeTitle), ...args);
            }

            log.time = function(timeTitle){
                console.time(log.title(timeTitle))
                if (arguments.length > 1) {
                    log.apply(null, arguments)
                }
            }
            log.timeEnd = function(timeTitle){
                console.timeEnd(log.title(timeTitle))
                if (arguments.length > 1) {
                    //var args = Array.prototype.slice.call(arguments, 0)
                    log.apply(null, arguments)
                }
            }
            return log;
        }
    };
})()
