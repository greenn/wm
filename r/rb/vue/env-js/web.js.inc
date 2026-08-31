<?#2.2.0 ?>
const WebHelper = function(cfg){ //PageHelper|WebPage|VuePage|RootPage
    if (!cfg) cfg = {};
    var _log = Log.for('Web');

    return {

        //выставляем document.title для страницы от cfg (pik-app-env.js.php:59)
        pageTitle: (function(){
            var _cfg = cfg['page-title'] || {};
            var baseTitle = _cfg.suffix || 'Web';
            return function(title){
                //_log('pageTitle', { title, _cfg })
                if (_.isArray(title)) title = title.join(_cfg.glue || ' • ');
                document.title = [
                    //prefixTitle ? prefixTitle + ' ' : '',
                    title ? title + ' | ' : '',
                    baseTitle
                ].join('');
            }
        })()
    }
}