<?
$Self = _rw::name('tool-admin');
$_ctx = $Self::tempCtx(array(
	'id' => $Self::nc()
));
$id = $_ctx['id'];
?>
_vue('<?=$id?>', function(_log, _cmd){

    var setFields = function(){

    }

    return {
        _vue: {},
        data: function(){
            return {
                sd: this.$attrs.sd,
                struct: null,
                values: {},
                name: undefined,
                trigger: 1
            }
        },

        methods: {

            getStruct_: function(cb){
                if (this.struct) {
                    cb(this.struct)
                } else {
                    var self = this;
                    api.sd_struct(this.sd, function(response, request){
                        _log('mounted|api-struct', { response, request, struct: response.struct })
                        self.struct = response.struct;
                        cb(self.struct)
                    })    
                }
            },

            //_getStruct: async function(){
            async _getStruct(){
                if (!this.struct) {
                    var res = await api_('sd_struct', this.sd);
                    this.struct = res.struct;
                }
            },
            
            //устанавливаем тип формы и данные
            setView: function(name, values){
                _log('setView', { name, values })
                var self = this;
                this.values = {};

                this.$nextTick(function(){
                    self.name = name;
                    if (values) self.values = values;
                })
            },

            //устанавливаем даные для формы
            setData: async function(values){
                //_log('setData', { values, 'cur-values': this.values });
                if (values) {
                    if (values === true) {
                        //case: create
                        <? $v = 'v2'; ?>
                        <? if ($v == 'v1') { ?>
                            var self = this;
                            this.getStruct_(function(){
                                var setValues = _.transform(self.struct, function(result, info, name){
                                    result[name] = ''
                                }, {})
                                //_log('setData/true', { struct: self.struct, 'cur-values': self.values, setValues });
                                self.setView('create', setValues)
                            })
	                    <? } ?>
	                    <? if ($v == 'v2') { ?>
                            await this._getStruct();                         
                            var setValues = _.transform(this.struct, function(result, info, name){
                                result[name] = ''
                            }, {})
                            //_log('setData/true', { struct: self.struct, 'cur-values': self.values, setValues });
                            this.setView('create', setValues)
	                    <? } ?>
                    } else {
                        //case: edit
                        this.setView('edit', values)
                    }
                } else {
                    this.setView('idle', values)
                }
            },

            //устанавливаем даные для формы по id
            setDataId: function(id){
                var self = this;
                //_log('setDataId', { sd: self.sd, id });

                api.sd_get(self.sd, id, function(item){
                    _log('api-get', { id, item });
                    self.setData(item)
                }, function(error_msg){
                    self.$root.error(error_msg)
                })
            },


            update: function(){
                var self = this;
                //if (!id || id === true) id = this.values.id;
                var id = this.values.id;
                var data = this.values;
                _log('update', { id, data });
                api.sd_update(this.sd, id, data, function(response){
                    _log('update-res', { response });
                    self.$emit('update', response)
                })
            },

            create: function(){
                var self = this;
                var data = this.values;
                api.sd_create(this.sd, data, function(response){
                    _log('create-res', { response });
                    self.close();
                    self.$emit('create', response)
                })
            },

            close: function(){
                _log('close');
                this.setData(false) //|| this.setView('idle')
            },

            remove: function(){
                var self = this;
                //_log('remove', { id, 'values.id': this.values.id });
                //if (!id || id === true) id = this.values.id;
                var id = this.values.id;
                if (confirm(`remove #${id}`)) {
                    api.sd_remove(this.sd, id, function(response){
                        _log('remove-res', { response });
                        self.close();
                        self.$emit('remove', response)
                        /*if (self.$parent.onRemoveItem) {
                            self.$parent.onRemoveItem(id, response, self.values)
                        }*/
                    }, function(){
                        _log.warn('remove-error', [...arguments]);
                    })


                }

            },

        },
        computed: {
            has_value: function(){
                return Object.keys(this.values).length
            }
        },
        /*beforeCreate: function(){
            _log('beforeCreate')
        },
        activated: function(){
            _log('activated')
        },
        created: function(){
            _log('created')
        },*/
        beforeMount: function(){

        },


        mounted: function() {
            //_log('mounted')
            if (this.$parent.regView) this.$parent.regView(this, 'form')

            var self = this;
            api.sd_struct(this.sd, function(response, request){
                _log('mounted|api-struct', { response, request, struct: response.struct })
                self.struct = response.struct;
            })
        }
    }
})