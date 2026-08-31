<?
    $Self = _kot::self()
?>
_vue('side-pane', function(_log, _cmd){

    return {
        _vue: {
            provide: [
                'link', //'linkBack',
            ],
        },

        data(){
            return {
                list: [],
                activeMenu: undefined
            }
        },

        methods: {
            selectMenu(item){
                //this._log('selectMenu', { item })
                this.activeMenu = item;
            },

            isSelectedMenu(item){
                return this.activeMenu === item;
            },

            syncMenuState(route) {
                var self = this;
                if (!route) {
                    route = this.$route.path;
                    if (route === '/') route = _r.titulRelRoute;
                }
                //_log('syncMenuState', { route });

                var hasReqRoute = function(item) {
                    //console.log('hasReqRoute', [item.link, route]);
                    return item.link === route;
                }

                var resList = [];

                var selectItem = function (item, state) {
                    //_log('selectItem', { item, sub: !!item.sub, state })
                    if (item.sub) item.expanded = state;
                    else if (state) self.selectMenu(item)
                }

                var verifyItems = function (list) {
                    var resItem = _.find(list, function (item) {
                        var res = hasReqRoute(item);
                        if (!res && item.sub) {
                            res = verifyItems(item.sub)
                            //if (!res) selectItem(resItem, false)
                        }
                        return res;
                    });
                    if (resItem) {
                        selectItem(resItem, true)
                    }
                    _log('syncMenuState/verifyItems', { resItem })
                    return resItem;
                }


                var res = false;
                var route_chunks = _.trimEnd(route, '/').split('/');
                do {
                    route = route_chunks.join('/')
                    //_log('verifyItems', { route, res, list: _clearObject(this.list) })
                    res = verifyItems(this.list);
                    route_chunks.pop();
                } while (route && route_chunks.length && !res)
            }

        },

        watch: {
            $route: function(route){
                this.syncMenuState(); //#K3
            },
        },

        mounted(){
            var self = this;

            if (1) Api.assignArray({
                api: 'side-menu/menu',
                this: this, //responseProp: 'list', resProp: 'list',
                cbRes: function(){
                    self.syncMenuState()
                }
            });

            if (0) Api.request.get('side-menu/menu', { tmp: moment().unix() },
                function(response){
                    //_log('api/data', { self, response, list: response.data.list });
                    _.each(response.data.list, function(item, key) {
                        self.list[key] = item
                    });
                    self.syncMenuState()
                }
            )

            /*
                var syncMenuState = _.once(this.syncMenuState);
                self.$router.afterEach(function(to, from){
                    syncMenuState()
                })
            */

        },
    }
})