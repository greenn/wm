__mqr.methods.initMQAutoResize = function(){
//initMQAutoResize(){
    //pr this.$el is brokn / указывается на последний чтоли mount элемент  - не понимаю
    var $App = $('BODY');
    var self = this;

	<? include_once 'hp-initMQAutoResize.js.inc' ?>;

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

        if (!verifyNestedMqr($node)) {
            return;
        }

        var opts = get_mqr($node); //mqrd
        var mqrc = get_mqrc($node);
        var mqrs = get_mqrs($node);
        var mqrw = get_mqrw($node);
        var mqrk = get_mqrk($node);
        var mqrz = get_mqrz($node);
        var mqrh = get_mqrh($node);
        var mqrl = get_mqrl($node);



        var limW = opts.w;

        //var itemH = limW >= window.innerWidth ? $node.height() : (opts.h ? opts.h : false);
        var itemH = opts.h;
        if (limW <= window.innerWidth) {//withoutScale
            itemH =  $node.height()
        }

        if (opts.dbg) {
            /*_log('init', {
                $node,
                w1: $node.width(),
                w2: $node.css('max-width')
            });
            debugger;*/
            _dbg.add($node, opts.dbg)
        }

        $node.wrap($wrapperBlock);
        var $wrapper = $node.parent();

        if (mqrk) {
            $wrapper.addClass(mqrk);
        }

        if (mqrz) {
            if (mqrz !== 'auto') {
                $wrapper.css('z-index', mqrz);
            }
        }

        if (mqrc.to) {
            $node.css('transform-origin', mqrc.to);
        }

        //$node.attr('o2', true);



        var item = {
            ppath,
            opts, mqr, //dbg
            limW,
            itemH,
            $node,
            $wrapper,
            mqrc: mqrc || {},
            mqrs,
            mqrw,
            mqrk,
            mqrh,
            mqrl,
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

        if(__cfg.dbg()) _log('initMQAutoResize', item.ppath, _cc(item), $node)

    })

    //binding
    this.MQAutoResize('resize0');
    //this.$nextTick(this.MQAutoResize)
    window.onresize = () => this.MQAutoResize('resize');
    //window.onresize = function(){ self.MQAutoResize() };

    //hk без этого криво встаёт
    setTimeout(() => { this.MQAutoResize('resize1') }, 1);
}