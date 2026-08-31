<?#1.1.6
//man plugin https://habr.com/ru/post/158235/
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');
headers('js', 'utf8', 'nosniff', etag::ctx(__FILE__), SITE_CACHE);
?>
//console.log('$.fn.externalClick');

(function($){
    var nodeIsExternal = function($node, $target){
        return !$target.closest($node).length;
    }
    //stateOn - надо реагировать на клик
    $.fn.externalClick = function(stateOn, cb, $moreNodes) {
        var $forNode = $(this);
        var stateOnSelf = false;
        if (Array.isArray(stateOn)) {
            stateOnSelf = stateOn[1];
            stateOn = stateOn[0];
        }
        //console.log('externalClick-init', [$forNode.length, $forNode]);
        if (stateOnSelf) {
            $forNode.click(function(event){
                var $target = $(event.target); //элемент, на котором произошло событие
                if(stateOnSelf($target, stateOn)) {
                    cb()
                }
            })
        }
        $(document).click(function(event) {
            //console.log('externalClick-click');
            var $target = $(event.target); //элемент, на котором произошло событие
            //var isExternalClick = !$target.closest($forNode).length;
            var isExternalClick = nodeIsExternal($forNode, $target);
            if ($moreNodes && $moreNodes.length) $moreNodes.each(function(){
                isExternalClick *= nodeIsExternal($(this), $target);
            })
            //console.log('external-click', { is: isExternalClick });
            if(isExternalClick && stateOn($target)) {
                cb()
            }
        });
    }
})(jQuery);

<? return; ?>
//eg

$menu.externalClick(function(){
    return isOpen;
}, function(){
    console.log('externalClick-cb');
    actClick();
})

//dd
$.fn.extend({
    externalClick: function(cb) {
        console.log('externalClick');
        $(document).click(function(event) {
            var $forNode = $(this);
            var $target = $(event.target);
            var isExternalClick = !$target.closest($forNode).length;
            //console.log('external-click', { is: isExternalClick });
            if(isExternalClick && isOpen) {
                cb()
            }
        });
    }
});