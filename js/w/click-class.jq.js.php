<?#0.1.10
//man plugin https://habr.com/ru/post/158235/
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');
headers('js', 'utf8', 'nosniff', etag::ctx(__FILE__), SITE_CACHE);
?>
(function($){
    //console.log('click-class', { '$.fn': $.fn });
    $.fn.clickClass = function(set, ctx) {
        if (!ctx) ctx = {};
        var _cb = function(cbName, self){
            if (typeof set[cbName] === 'function') {
                return set[cbName].call(self || null, ctx, set);
            }
            return set[cbName];
        }
        var $targets = $(this);

        _cb('init');
        $targets.click(function(e){
            var $node = $(this);
            var nc = _cb('nc', this);
            //console.log('click-class', { nc, ctx });
            if (!$node.hasClass(nc)) {
                if (nc) $node.addClass(nc)
                _cb('clickIn', this)
                setTimeout(function(){
                    if (nc) $node.removeClass(nc);
                    _cb('clickOut', this)
                }, set.tm)
            }

            var setStop = set.stopPropagation || set.stop;
            if (set.stopPropagation) e.stopPropagation();
            if (setStop) return false;
        })

    }
})(jQuery);

<? return; ?>
$('[nolink]').clickClass({
    'nc': 'shake-404',
    'tm': 250,
    'stopPropagation': true
});

$('[bclick]').clickClass({
    'tm': 150,
    'nc': function(){
        var $node = $(this);
        var val = $node.attr('bclick');
        //console.log('click-class  nc', { $node, val });
        return `bclick-${val}`
    },
    stop: true,
});

