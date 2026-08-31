var _Api = WebApi({ log: 'VueApi'});

var _api = {

    loadVueScript(cmptPath, callback, fallback){
        var orig_cmptPath = cmptPath; //dbg

        if (_.isArray(cmptPath)) cmptPath = cmptPath.join('/'); //case: ['rp', 'id', 'mod-test']
        if (_.isObjectLike(cmptPath)) {
            cmptPath = orig_cmptPath.path;
            //_log('???', { clone: _clone(orig_cmptPath), path: orig_cmptPath.path });
        }

        //_log('loadVueScript', { cmptPath, orig_cmptPath }, [_.isArray(orig_cmptPath), _.isObjectLike(orig_cmptPath)])

        if (1) var $process = _Api.request.get('rb/vue/decl/js', {
            path: cmptPath, //eg: rp/id/mod-test
        }, function(response){
            //_log('loadVueScript/api-res', { response })
            //$process.solve()
            callback();
        }, true)

        _log('loadVueScript/$', { $process })
        
        //_log('oo', { uri: _Api.uri('rb/vue/decl/js', { path: cmptPath }) })
        //выполняет скрипть
        if (0) var $process = $.getScript(
            _Api.uri('rb/vue/decl/js', { path: cmptPath })
        )
            .done(function(script, textStatus ) {
                //_log('loadVueScript/getScript/res', { script, textStatus })
                callback();
                //$process.solve()
            })
            .fail(function(jqxhr, settings, exception) {
                _log('loadVueScript/getScript/error', { jqxhr, settings, exception });
            });

        return $process;
    },

    loadVueTpl(cmptPath, callback, fallback){
        var $process = _Api.request.get('rb/vue/decl/tpl', {
            path: cmptPath, //eg: rp/id/mod-test
        }, function(response){
            _log('loadVueScript/api-res', { response })

            $(response['vue-tpl-script']).appendTo('HEAD');

            callback();
            //$process.solve(response)
            //callback();
        }, true);

        return $process;
    },

};

