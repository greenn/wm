<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');
headers('js', 'utf8', 'nosniff', etag::ctx(__FILE__), SITE_CACHE);
?>

vue_app(function(_log){

    return {
        _vue: {
            router: true,
            routes: function(){
                const _DefCmpt = { template: '<div>{{ $route.meta.title }}</div>' }

                return [
                    { path: '/', component: _DefCmpt, meta: { title: 'Titul' } },
                    { path: '/route', component: _DefCmpt, meta: { title: 'Route' } },

                ]
            }
        },
        data: function(){
            return {
                h1: 'Router',
            }
        },
        //beforeCreate(){ _log('BEFORE-CREATE') },
        //created(){ _log('CREATED') },
        //beforeMount(){ _log('BEFORE-MOUNTED') },
        //mounted(){ _log('MOUNTED') },
    }

}, '#app')