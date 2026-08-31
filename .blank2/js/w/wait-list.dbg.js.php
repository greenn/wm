<?#0.3.0-dbg
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');
headers('js', 'utf8', 'nosniff', etag::ctx(__FILE__), SITE_CACHE);
?>

function makeWaitList(set){
    _log.time('waitList')
    if (typeof set === 'function') set = { ready: set }
    var items = {};

    var ready = set.ready || fn.ready;

    _log('makeWaitList', { set, ready });
    var counter = 1;
    var verify = function(){
        var isReady = true;
        for (var name in items) {
            isReady *= items[name]
        }
        //isReady && ready && ready();
        isReady && ready && (ready() || _log.timeEnd('waitList'));
        return isReady;
    }
    var fn = function wait(name){
        if (!name) name = counter++;
        items[name] = false;
        _log.time('wait/' + name)
        return name;
    }
    fn.resolve = function(name){
        items[name] = true;
        var res = verify();
        //_log('wait/resolve', { name, res });
        _log.timeEnd('wait/' + name, { res })
    }
    return fn;
}
