<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
	'headers'
);

$Self = _site::self();
$n = $Self::nc();

$js = array();
headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra(),
	//$js['parallax'] = $Self::path('parallax', 'js.inc'),
	__FILE__
), SITE_CACHE);
js::wreq('click-class.jq');
?>
$(function(){

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
        'stop': true,
    });

    (function(){
        var nc = '-click';
        var dbg = false;
        $('[click]').each(function(){
            var $node = $(this);
            $node
                .mousedown(function(){
                    $node.addClass(nc)
                })
                .mouseup(function(){
                    if (dbg) return;
                    $node.removeClass(nc)
                })
                .dblclick(function(){
                    dbg = !dbg;
                })
            ;
        })
    })()


})