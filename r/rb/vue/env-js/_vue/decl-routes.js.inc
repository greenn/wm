var cfgRoutes = _cfg.routes;
_cmd.useRouter = _cfg.hasOwnProperty('router') ? _cfg.router : !!_cfg.hasOwnProperty('routes');
if (typeof _cmd.useRouter == 'function') _cmd.useRouter = _cmd.useRouter();
//_log('APPEND-ROUTES', _cmd.useRouter, _cfg);
if (_cmd.useRouter && cfgRoutes) {
    AppRoutes.push([cfgRoutes, name, decl]);
    if(0) AppRoutes.push({
        cfg: cfgRoutes,
        name: name,
        decl: decl,
    });
}