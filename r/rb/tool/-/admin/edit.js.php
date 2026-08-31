<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
include_once $_SERVER['DOCUMENT_ROOT'].'/iq/tool/admin/tool-admin.class.php';
_needphp('headers');

$self_nc = 'tool-admin';
$Self = _rw::name($self_nc);
//dx($Self);
headers('js', 'utf8', 'nosniff', etag::ctx(
	//etag::extra(),
	__FILE__
), SITE_CACHE);

js::req('rw', $self_nc, 'api/sd.api.js.php');
?>

vue_app(function(_log){
    _log.set_({
        //'mounted': 0
    })

    var defSide = 'msg';

    return {
        _vue: {
            //provide: ['regView'],
            provide: ['regView', {
                link: true,
            }, 'linkBack'],

            routerOpts: {
                base: true,

                //q убрать hash
                //hash: false,
                //hashbang: false,
                //mode: 'history',
            },
            routes: function(){

                if(0) _log('routes', {
                    'component: admin-edit': _App._component,
                    'component: form-a': _App.component('form-a')
                });

                return [
                    { path: '/:page?/:id?/:ext(.*)*', component: _App._component },
                ];
            }
        },

        data: function(){
            if (0) _log('data', {
                props: _clearObject(this.$props),
                attrs: _clearObject(this.$attrs),
            });

            //_log('data', { $route: this.$route, '$route.params': this.$route.params });

            return {
                form: null, //заполняется из child через $parent.regView
                listing: null, //заполняется из child через $parent.regView
                msg: null,
                side: defSide
            }
        },

        methods: {
            reloadPage() {
                location.reload();
            },

            //установка значений в форму
            formData: function(data){
                this.form.setData(data);

                _log('formData', { data });
            },

            //новая форма / установка пустных значений в форму
            add: function(){
                //_log('add', { form: _clearObject(this.form) });
                this.side = 'form';
                this.form.setData(true);
            },

            onAdd: function(ctx){
                this.listing.addItem(ctx.item);
            },

            edit: function(id){
                this.side = 'form';
                this.form.setDataId(id);
            },
            onEdit: function(ctx){
                this.listing.updateItem(ctx.id, ctx.data);
            },

            onDelete: function(ctx){
                this.listing.removeItem(ctx.id);
            },


            errorReset: function(){
                this.msg = '';
            },
            error: function(set){
                _log('error', set)
                if (typeof set == 'string') set = { msg: set }
                if (!set) set = {};

                this.side = 'error'; //01
                var msg = set.msg || 'Ошибка';
                switch (set.code) {
                    //case: 'empty-id': break;
                }

                //this.msg.msg(msg);
                this.msg = msg;
                if (set.form === false) {
                    this.form.setView(false)
                }
            },

            syncState: function(route){
                _log('syncState', { route: route || this.$route, params: this.$route.params });
                var page = this.$route.params.page;
                var id = this.$route.params.id;
                this.errorReset();
                switch (page) {
                    case 'edit': {
                        if (id) {
                            this.edit(id)
                        } else {
                            this.error('empty-id')
                        }
                    } break;
                    case 'add': {
                        this.add()
                    } break;
                    case 'error': {
                        this.error(id)
                    } break;

                }

                //this.$parent.formData(item)
            },
        },

        watch: {

            $route: function (route){
                //_log('w:route', { route, params: this.$route.params });
                this.syncState();

                //_log('w:route', [route, _.startsWith(route.fullPath, "/clients"), this.$route.params.page, this.$route.params.tab]);
                //if (!_.startsWith(route.fullPath, "/clients")) return;
            }
        },

        //mounted: function() { _log('mounted') }

    }

}, function(){
    App = _App.mount('#app-edit');
}, 'admin-edit')

