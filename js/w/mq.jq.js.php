<?#0.7.2 - media queries tracking

include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');
headers('js', 'utf8', 'nosniff', etag::ctx(__FILE__), SITE_CACHE);
?>
(function($){

    var $dbg_w, $dbg_w2, $dbg_w3;
    var mq1 = 1600, $mq1;
    var $dbgPane = $('<div />',{
        css: {
            position: 'fixed',
            top: '0',
            left: '50%',
            'z-index': '10000',
            transform: 'translateX(-50%)',
        },
        append: [
            $dbg_w = $('<span />', { text: '', title: 'window.innerWidth', css: { 'margin-right': '10px' } }),
            $dbg_w2 = $('<span />', { text: '', title: '$(document).width()', css: { 'margin-right': '10px' } }),
            $dbg_w3 = $('<span />', { text: '', title: '$(\'BODY\').width()', css: { 'margin-right': '10px' } }),
            $('<span />', { text: `mq(${mq1}): `, append: $mq1 = $('<span />') }),
        ],

    })

    var dbgPane = {
        inited: false,
        init: function(){
            if (!dbgPane.inited) $(function(){
                $dbgPane.prependTo('BODY');
                dbgPane.inited = true;
            })
        },
        w1: function(){ return window.innerWidth },
        w2: function(){ return $(document).width() },
        w3: function(){ return $('BODY').width() },
        mq1: function(){
            var mq = `(max-width: ${mq1}px)`;
            var res = window.matchMedia(mq);
            return res.matches;
        },
        sync: function(){
            if (dbgPane.inited) {
                $dbg_w.text(dbgPane.w1());
                $dbg_w2.text(dbgPane.w2());
                $dbg_w3.text(dbgPane.w3());
                $mq1.text(dbgPane.mq1() ? 'true': 'false');
            }
        }
    }


    var is_mq = function(mq){
        return window.matchMedia(mq).matches;
    }

    var get_w = function(){
        return window.innerWidth;
    }

    //get center X of $target
    var xcOf = function($target){
        var bcr = this.$target[0].getBoundingClientRect();
        var x = bcr.x + bcr.width / 2;
        return Math.ceil(x);
    }

    $.fn.mq = function(set, _cb/*hasMatch, stateHasChanged|isNewState*/) {
        if (_cb) set.cb = _cb;

        set.node = this;
        set.$node = $(this);

        if (set.min) set.min = parseInt(set.min);
        if (set.max) set.max = parseInt(set.max);

        var curState, prevState;
        var stateHandler = function(){};
        var W;

        var update_w = function(){ W = get_w() };
        var isNewState = function(){ return curState !== prevState };

        set.xcOf = xcOf;

        var call_cb = function(cb, argsPackId){
            if (cb) {
                var args = [];
                switch (argsPackId || 1) {
                    case 1: { args = [W] } break;
                    case 'on-cb': { args = [W, isNewState()]  } break;
                    case 'on-change': { args = [!!curState, W]  } break;
                    case 'on-init': { args = [W, !!curState]  } break;
                }

                cb.apply(set, args)
            }
        }

        var on_lim = function(){
            if (set.min) {
                if (W < set.min) {
                    call_cb(set.onMin, 1);
                    call_cb(set.onStop, 1);
                }
            }
            if (set.max) {
                if (W > set.max) {
                    call_cb(set.onMax, 1);
                    call_cb(set.onStop, 1);
                }
            }
        }

        if (set.mq) {
            //var mq_wMax = `(max-width: ${set.max}px)`;
            stateHandler = function(){
                curState = is_mq(set.mq);
            }

        } else {
            stateHandler = function(){
                var state = true;
                if (set.min) state *= W >= set.min;
                if (set.max) state *= W <= set.max;
                curState = state;
            }
        }

        var dbg = function(){};
        if (set.dbg) {
            dbgPane.init();
            dbg = dbgPane.sync();
        }

        //ak sync|
        var onResize = function(){
            dbg();
            update_w()
            prevState = curState;
            stateHandler();
            if (curState) {
                call_cb(set.cb, 'on-cb');
            }
            if (isNewState()) {
                call_cb(set.onChange, 'on-change');

                if (curState && set.onStart) {
                    call_cb(set.onStart, 1);
                }
                if (typeof prevState != 'undefined') {
                    on_lim();
                }
            }
        }


        if (set.debounce) {
            onResize = _.debounce(onResize, set.debounce);
        }

        $(function(){
            update_w();
            if (set.onInit) call_cb(set.onInit, 'on-init');
            onResize(); //init
            $(window).resize(onResize);
        })

    }
})(jQuery);

<? return; ?>


$('.<?=$n?>-graph-dyn-nso').mq({
    //dbg: true,
    //debounce: 200,
    mq: '(max-width: <?=_mq(1)?>px)',
    max: <?=_mq(1)?>, //max: 1138,
    min: '<?=_mq(2)?>',
    onInit: function(W, state){
        console.log('onInit', [W, state, this])
    },
    cb: function(W, isNewState){
        console.log('cb', [W, isNewState, this])
    },
    onMin: function(W){
        console.log('onMin', [W, this])
    },
    onMax: function(W){
        console.log('onMax', [W, this])
    },
    onStart: function(W, ){
        console.log('onStart', [W, this])
    },
    onStop: function(W){
        console.log('onStop', [W, this])
    },
    onChange: function(state, W){
        console.log('onChange', [state, W])
    },
}, function(W, isNewState){

})
