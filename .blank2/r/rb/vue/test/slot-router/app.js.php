<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');
headers('js', 'utf8', 'nosniff', etag::ctx(__FILE__), SITE_CACHE);
?>
vue_app(function(_log){
    _log('0');
    return {

        _vue: {
            routes: function(){
                const _DefCmpt = { template: '<p>Page Not Found</p>' };
                const _RedCmpt = { template: '{{ $route.path }}' };
                return [
                    //{ path: '/:page?/:tail(.*)*', component: _DefCmpt },
                    { path: '/green', component: { template: 'green' } },
                    { path: '/:pathMatch(.*)*',
                        components: {
                            'default': _DefCmpt,
                            'RCmpt': _RedCmpt
                        },

                    },
                ]
            }
        },


        data: function(){
            return {}
        },
        methods: {
            addBlueRoute: function(){
                this.blueRoute = this.$router.addRoute({
                    name: 'blue',
                    path: '/blue',
                    component: {
                        template: '<span>blue</span>'
                    }
                });
            },
            addBlueRoute2: function(){
                this.blueRoute = this.$router.addRoute({
                    name: 'blue',
                    path: '/blue',
                    component: {
                        template: '<span>blue2</span>'
                    }
                });
            },
            removeBlueRoute: function(){
                //https://router.vuejs.org/guide/advanced/dynamic-routing.html#removing-routes
                //this.$router.removeRoute('/blue');
                //this.blueRoute && this.blueRoute(); //OK
                this.blueRoute('blue'); //OK
            },
        }
    }

}, function(){
    App = _App.mount('#app');
})