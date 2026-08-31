_vue('v-menu', function(_log, _cmd){
    var _self;


    return {
        template: '#v-menu',
        _vue: {
            routes: function(){
                const _Page404 = _App.component('page-404');
                _log('routes', { _Page404: _Page404 });
                return [
                    { path: '/:page/:tail(.*)*', component: _Page404 },
                ]
            },
            provide: {
                '_m:link': ''
            }
        },

        data: function(){
            return {
                list: []
            }
        },

        methods: {
            //07
            link: function(){
                //_log('--', _app('page-404'), this.$route);
                this.syncContent()
                return this._link.apply(this, arguments)
            },

            syncContent: function(){
                _log('syncContent', this.$route);
                _app('page-404').content = this.$route.params.tail[0];
            },

            addMenu(item){

                if (typeof item == 'string') {
                    var link = item;
                    item = { link: link, text: link }
                }
                item.click = function(){
                    //_self.$routeTo(item.link)
                    _log('click', { item, 'this.$routeTo' : _self.$routeTo })
                    //_self.$router.push(item.link);
                    _self.link(item.link);
                }
                this.list.push(item);
            }
        },

        watch: {
            $route: function (route){
                _log('w:route', { route: route });

                this.syncContent();
            }
        },

        mounted: function() {
            _self = this
            this.addMenu('page/1');
            this.addMenu('page/2');
        }
    }
})