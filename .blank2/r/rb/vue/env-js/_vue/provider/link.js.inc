
Provider._linkAddr = function(opt){
    opt = _.defaults(opt, {
        baseUri: '',
        startPage: '',
    })

    if (_.startsWith(opt.baseUri, '/')) {
        opt.baseUri = _.trimStart(opt.baseUri, '/');
    }

    return function linkAddr(page, asHref){
        if (_.isArray(page)) page = page.join('/');
        var uriChunks = [''];
        if (opt.startPage) uriChunks.push(opt.startPage);
        if (page) uriChunks.push(page);
        if (asHref && opt.baseUri) uriChunks.splice(1, 0, opt.baseUri);
        return uriChunks.join('/')
    }
}

Provider._linkHref = function(opt){
    opt = _.defaults(opt, {
        baseUri: '',
        startPage: '',
    })

    if (_.startsWith(opt.baseUri, '/')) {
        opt.baseUri = _.trimStart(opt.baseUri, '/');
    }

    return function linkHref(page/*|startPage, page*/){
        var startPage = opt.startPage;
        if (arguments.length === 2) {
            page = arguments[2];
            startPage = arguments[1];
        }

        if (_.isArray(page)) page = page.join('/');
        if (_.startsWith(page, '/')) {
            page = _.trimStart(page, '/');
        }

        var uriChunks = [''];
        if (startPage) uriChunks.push(startPage);
        if (page) uriChunks.push(page);
        if (opt.baseUri) uriChunks.splice(1, 0, opt.baseUri);
        return uriChunks.join('/')
    }
}


//q startUri = false ~ link: false
Provider._link = function(startUri){

    <?/*
    if (baseUri === true || baseUri === undefined) {
        baseUri = _vue.baseUri;
        //step: проверка, чтобы не заканчивалось на /, иначе glue даст два //
        if (baseUri.slice(-1) === '/') baseUri = baseUri.slice(0, -1);
    }
    */?>

    if (typeof startUri === 'string') {
        //step: проверка, чтобы не заканчивалось на /, иначе glue даст два //
        if (startUri.slice(-1) === '/') startUri = startUri.slice(0, -1);
    } else {
        startUri = '';
    }


    //_log('Provider._link', { startUri, args: Array.prototype.slice.call(arguments)  });

    return function link(/*uri1, uriN*/){
        var route = Array.prototype.slice.call(arguments);

        //step: убираем # или /# в начале uri
        var orig_route = route[0]; //dbg
        var prefix_rg = /^(\/?#)/; //убираем # или /#
        route[0] = route[0].replace(prefix_rg, '');
        var normalize_route = route[0]; //dbg

        if (startUri) route.unshift(startUri);
        route = route.join('/');

        route = '/' + _.trimStart(route, '/');

        //this._log('m:link', { orig_route, normalize_route, route }); return false; //dbg
        //this.clog('link', { route });

        this.$router.push(route);
        return false;
    }
};

Provider.linkBack = function(){
    this.$router.go(-1);
    return false;
};


ProviderDep.linkTitul = ['link'];
Provider._linkTitul = function(titulLink){
    if (titulLink === true) titulLink = '/';
    return function linkTitul(){
        //this._log('linkTitul', { titulLink });
        this.link(titulLink);
        return false;
    }
};


ProviderDep.linkRel = ['link'];
Provider._linkRel = function(startUri){
    //_log('linkRel', { startUri })
    return function linkRel(subUri){
        if (!startUri || startUri === true) startUri = this.$route.path;
        var route = [
            _.trimEnd(startUri, "/"),
            _.trimStart(subUri, "/")
        ].join('/');

        //_log('m:linkRel', { route, startUri, subUri });

        this.link(route);
        //return false;
    }
};

ProviderDep.linkPar = ['link'];
Provider.linkPar = function(depth){
    if (!depth || depth === true) depth = 1;
    var route = this.$route.path;

    var parts = route.split("/");
    parts.splice(-depth);
    var par = parts.join("/");

    //_log('m:linkPar', { route, parts, par});
    this.link(par);
};