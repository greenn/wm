__mqr.methods.initMQAutoResize = function(){
//initMQAutoResize(){
    //pr this.$el is brokn / указывается на последний чтоли mount элемент  - не понимаю
    var $App = $('BODY');

    var self = this;

    $('[mqr]', $App).each(function(){

        var $node = $(this);
        if ($node.parent().is('.mqr-w')) {
            return;
        }

        var $wrapperBlock = $('<div />', {
            class: 'mqr-w',
        });

        var ppath = `[${$node.ppath5(['site-w'])}]`; //idn 4 dbg

        var mqr = $node.attr('mqr');

        //if ($node.parents('[mqr]')) _log('mqr-has-parent');
        var $_childs = $('[mqr]', $node)
        if ($_childs.length) {
            _log('mqr-has-child', {
                $node, node: $node[0],
                $_childs, q$_childs: $_childs.length,
                $_child1: $_childs[0]
            });
            return;
        }

        //ak mqr-cfg \ prev -css
        var mqrc = $node.attr('mqrc');
        if (mqrc) {
            var mqrcPairs = _.map(_.split(mqrc, ';'), function(pair) {
                var [key, value] = _.split(pair, '=');
                return [_.trim(key), self.convertStringToTypedValue(value)];
            });
            mqrc = _.fromPairs(mqrcPairs); //создаём объект из пар
		}



        var mqrs = $node.attr('mqrs');
        if (mqrs) {
            var mqrsPairs = _.map(_.split(mqrs, ';'), function(pair) {
                var [opt, optValue] = _.split(pair, '=');
				//optValue = '800:10vw,500:10';
                var valuePairs = _.map(_.split(optValue, ','), function(pair) {
                    var [mqVal, value] = _.split(pair, ':');
                    //value=5vw | value=10
                    return [mqVal, self.splitValueAndUnit(value)];
                });

                return [_.trim(opt), _.fromPairs(valuePairs)];
            });
            mqrs = _.fromPairs(mqrsPairs); //создаём объект из пар
		}

        var mqrw = $node.attr('mqrw');
        if (mqrw) {
            var mqrwPairs = _.map(_.split(mqrw, ';'), function(pair) {
                var [opt, optValue] = _.split(pair, '=');
                return [_.trim(opt), self.convertStringToTypedValue(optValue)];
            });
            mqrw = _.fromPairs(mqrwPairs);
        }

        var mqrk = $node.attr('mqrk');


        var opts = _.zipObject(['w', 'h', 'dbg'], _.map(_.split(mqr, ','), function(item) {
            return _.trim(item);
            //return parseInt(_.trim(item), 10); // Второй аргумент в parseInt указывает на систему счисления (10 для десятичной)
        }));
        if (!opts.w) opts.w = <?=_css('site-w') + 60?>; //1280

        if ($node.is("[mqrd]")) opts.dbg = $node.attr("[mqrd]") !== 'off';

        var limW = opts.w;

        //var itemH = limW >= window.innerWidth ? $node.height() : (opts.h ? opts.h : false);
        var itemH = opts.h;
        if (limW <= window.innerWidth) {//withoutScale
            itemH =  $node.height()
        }

        if (opts.dbg) {
            _dbg.add($node, opts.dbg)
        }

        $node.wrap($wrapperBlock);
        var $wrapper = $node.parent();

        if (mqrk) {
            $wrapper.addClass(mqrk);
        }

        //$node.attr('o2', true);



        var item = {
            ppath,
            opts, mqr, //dbg
            limW,
            itemH,
            $node,
            $wrapper,
            //mqrs,
            mqrc: mqrc || {},
            mqrs,
            mqrw,
            mqrk,
            dbg: 1&&opts.dbg,

            defPosition: $node.css('position'),
            log6: _.debounce((title,...args) => {
                _log(title, ppath, ...args);
            }, 1000),
            log: function(title, args){
                item.ilog(title, args)
                item.dlog(title, args)
            },
            ilog: _.once(function(title) {
                _log(title, 'LIST::', _cc(self.mqList));
                _log(title, 'INFO::' + ppath, $node, item, item.opts, mqrc, mqrs);
            }),
            dlog: _.debounce(function(title, args) {
                _log(title, ppath, args);
            }, 500, { 'leading': true, 'trailing': true })
        }
        self.mqList.push(item);
        //_log('initMQAutoResize/item', { is$node: $node.length, is$wrapper: $wrapper.length, limW })

        if(1) _log('initMQAutoResize', item.ppath, _cc(item), $node)

    })

    this.MQAutoResize();
    window.onresize = this.MQAutoResize;

}