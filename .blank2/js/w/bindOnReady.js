//0.3.9
function bindOnReady(set, waitMore){
    if (!set.interval) set.interval = 20;
    if (!set.waitMore) set.waitMore = waitMore || 0;
    if (!set.stopAfter) set.stopAfter = [5000, function(){}];
    document.addEventListener('DOMContentLoaded', function() {
        var $nodes;
        var inited = false;
        var tid = setInterval(function(){
            $nodes = set.nodes();
            //console.log(tRCLICK += 20)
            if ($nodes.length) {
                clearInterval(tid);
                setTimeout(function(){
                    inited = true;
                    set.bind($nodes);
                }, set.waitMore)
            }
        }, set.interval);

        if (set.stopAfter) setTimeout(function(){
            if (!inited) {
                clearInterval(tid);
                console.log(`bindOnReady stopped after ${set.stopAfter[0]}`, { set })
                set.stopAfter[1]();
            }
        }, set.stopAfter[0])

    });

}