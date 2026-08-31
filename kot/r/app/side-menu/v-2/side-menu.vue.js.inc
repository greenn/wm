<?
$Self = _kot::self();
//$n = $Self::nc();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc'));  //'side-menu'
?>
_vue('<?=$vueName?>', function(_log, _cmd){

    var optRememberExpanding = !true;
    return {
        _vue: {
            provide: [
                'link',
            ],
        },

        props: [
            'list',
            'depth', //er
            'ftLink', //'ftSubLink',

            'mock', //wd
        ],

        <?if (0) { ?>

        inheritAttrs: false,
        //v-bind="filteredAttrs"
        computed: {
            filteredAttrs() {
                // Фильтрация атрибутов для передачи только 'cp', 'cd' и 'c-t'
                const { cp, cd, 'c-t': ct } = this.$attrs;
                return { cp, cd, 'c-t': ct };
            }
        },
	    <?} ?>

        data(){
            return {
                isRoot: false,
                _index: _cmd.curIndex(),
                items: this.$props.list,
                map: {},
                expanded: false,
                ls: _storage.namespaceHandler('<?=$vueName?>'),
            }
        },

        beforeRouteEnter(to, from, next) {
            _log('beforeRouteEnter', { to, from, next })
        },

        beforeRouteLeave(to, from, next) {
            _log('route-change', { to, from, next })
        },

        beforeRouteUpdate(to, from, next) {
            _log('beforeRouteUpdate', { to, from, next })
        },



        methods: {
            //раскрытие меню
            itemExpand: function(item, newValue){
                //if (!item) return;
                item.expanded = newValue;

                if (optRememberExpanding) {
                    this.ls.set(['expand', item.sid], newValue);
                }
            },

            itemExpandToggle: function(item){
                var oppositeValue = !item.expanded;
                //_log('itemExpandToggle', { item: _cc(item), oppositeValue })
                this.itemExpand(item, oppositeValue)
            },

            //используем запоминание расскрытых элементов
            syncExpanding(){
                //_log('syncExpanding', { state: this.ls.get('itemExpand') });
                var self = this;
                _.each(this.ls.get('expand'), function(state, sid){
                    self.map[sid].expanded = state
                })
            },


            //click по меню
            menuClick: function(item){
                if (item.sub) {
                    this.itemExpandToggle(item);
                } else {
                    this.link(item.link);
                    //this.applyParentMethod('side-pane', 'selectMenu', item);
                }
            },

            //загружаем данные для меню
            rootLoad: function(){
                ApiKot.assignArray({
                    //dbg: 1,
                    responseDef: false,
                    api: 'side-menu/v0/list', data: { mock: this.mock },
                    this: this, //responseProp: 'list', resProp: 'list',
                    resProp: 'items',
                    cbRes: this.rootInit
                });
            },

            //инициализируем root-данные
            rootInit(){
                this.isRoot = true;
                this.makeMapMenu();

                //_log('rootInit', { items: _cc(this.items), map: _cc(this.map) })


                if (optRememberExpanding) this.syncExpanding()

                this.syncActiveItem();
                this.onRouteChange(function(to, from){
                    this.syncActiveItem()
                });

            },

            // создаём пронумерованную карту элементом по sid
            makeMapMenu(){
                var map = {};
                var iterate = function(data, cb, parSid){
                    _.each(data, function(item, index){
                        cb(item, parSid);
                        if (item.sub) {
                            iterate(item.sub, cb, item.sid)
                        }
                    })
                }

                iterate(this.items, function(item, parSid){
                    item.parSid = parSid;
                    map[item.sid] = item;
                })


                this.map = map;
            },

            syncActiveItem(){


                var activeItem;
                var curPath = this.$route.meta.baseUrl || this.$route.path;
                _.each(this.map, function(item){
                    var isActive = item.link === curPath;
                    item.active = isActive;
                    if (isActive) activeItem = item;
                });

                if (activeItem) this.itemBackExpand(activeItem)

                if (0) _log('syncActiveItem', {
                    $route: this.$route,
                    activeItem,
                    curPath
                })
            },

            
            itemBackExpand(item){
                //_log('itemBackExpand', { item: _cc(item), parSid: item.parSid })
                if (item.parSid >= 0) {
                    var parItem = this.map[item.parSid]
                    this.itemExpand(parItem, true)

                    //_log('itemBackExpand', { parItem: _cc(parItem), parSid: parItem.parSid })
                    this.itemBackExpand(parItem);
                }
            },

            onRouteChange(cb){
                var self = this;
                /*
                    var Router = _aKot.getRouter();
                    Router.beforeEach(function(to, from, next){
                        console.log('Маршрут собирается измениться:', from.path, '->', to.path);
                        next();
                    })
                */

                this.$watch('$route', function (to, from) {
                    cb.call(self, to, from)
                });


            },
        },


        mounted(){
            if (!this.items) {
                //_log('mounted root');
                this.rootLoad()
            } else {
                //here: использование отрисовка суб меню через свой же компонент
                //this.makeMapMenu(); //01
            }
        }
    }
})