<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');
headers('js', 'utf8', 'nosniff', etag::ctx(__FILE__), SITE_CACHE);
?>

function makeWaitList(set){
    if (typeof set === 'function') set = { ready: set }
    var items = {};
    var fn = function waitList(name){
        items[name] = $.Deferred();
    }
    fn.resolve = function(name){
        items[name].resolve();
    }
    fn.init = function(){
        $.when.apply($, _.transform(items, function (list, item) {
            list.push(item)
        }, [])).then(set.ready || fn.ready);
    }
    fn.onReady = function(cb){
        set.ready = cb
    }
    return fn;
}
