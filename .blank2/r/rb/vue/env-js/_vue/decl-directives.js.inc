var cfgDirectives = _cfg.directives;

if (cfgDirectives) {

    if (_.isArray(cfgDirectives)) cfgDirectives = _.transform(cfgDirectives, function(res, name, directive/*index на самом деле, просто надо объявить переменную*/){
        directive = true;
        if (_.isArray(name)) {
            directive = name[1];
            name = name[0];
        }
        res[name] = directive ;
    }, {});

    //_log('cfgDirectives', { cfgDirectives, AppDirectives });

    _.each(cfgDirectives, function(directive, name){
        if (!AppDirectives[name]) {
            if (directive === true) {
                directive = _AppDirectives[name];
            }
            if (directive) {
                AppDirectives[name] = directive;
                //_log('addDirective', { name, directive })
                _vue.init_directive(name, directive);
            }
        }
    })

    //_log('addDirectives', { org: _cfg.directives, list: cfgDirectives, AppDirectives });

}