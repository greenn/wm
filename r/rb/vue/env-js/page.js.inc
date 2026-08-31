const Page = (function(){
    var baseTitle = document.title;

    var buildUri = function(baseChunks, pages, query){
        //var chunks = ['patient'].concat(pages)
        var uri = baseChunks.concat(pages).join('/');
        if (query) {
            uri += '?' + _.transform(query, function(res, value, name){
                res.push([name, value].join('='))
                return res;
            }, []).join('&')
        }
        return uri;
    };
    return {

        buildRoute: function(basePage, pages, query){
            return buildUri(['', basePage], pages, query);
        },

        buildUri: function(basePage, pages, query){
            return buildUri(['#', basePage], pages, query);
        },
        route: function(uri, query){
            router.push({ path: uri, query: query })
        },

        prepareViews: function(viewsData){
            return _.each(viewsData, function(view, name){
                view.name = name;
                if (!view.hasOwnProperty('page')) view.page = name;

                if (!view.hasOwnProperty('tpl')) view.tpl = name;
                if (view.wd) view.tpl += '-wd';

                //if (!view.hasOwnProperty('uri')) view.uri = name;
                //if (!view.hasOwnProperty('tpl')) view.tpl = name;
                if (!view.hasOwnProperty('menu')) view.menu = view.title;
                //if (!view.hasOwnProperty('parMenu')) view.par = view.page;
            });
        },

        setTitle: function(title){
            //console.log('PAGE:setTitle', [title, baseTitle]);
            if (_.isArray(title)) title = title.join(' • ');
            document.title = [
                //prefixTitle ? prefixTitle + ' ' : '',
                title ? title + ' | ' : '',
                baseTitle
            ].join('');
        },

    }
})()