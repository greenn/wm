<?/*
each js
	file has stack check stack
	or file has src-on-page //then
	else add it

    __root.addComponent

*/?>
__root.loadComponent = function(name, callback){

    $.when(
        _api.loadVueTpl(name, function(res){
            //_log('VueTpl: loaded', { name, res });
        }),
        _api.loadVueScript(name, function(res){
            _log('VueScript: loaded', { name, res });
        })
    ).then(function(tplRes, jsRes){
        var tplResponse = tplRes[0][0];
        //_log('VueCmpt: loaded', { name, tplRes, jsRes, tplResponse, 'vueId': tplResponse['vue-name'] });
        callback(name)
    })

}
