_vue.provider['__set-fields'] = function(__cfg){

    __cfg = _.defaults({}, __cfg, {
        'Api': ApiKMod,
        'api-base': 'ui',
        'api-select': 'get-select',
    });

    var Api = __cfg.Api

    return {

        data(){
            return {
                set: {
                    //oo kot/r/mod/guzzler/main.vue.js.inc:37
                }
            }
        },

        methods: {

            updateSelect(name){
                var self = this;
                self.busy[name] = true;
                Api.get(`${__cfg['api-base']}/${__cfg['api-select']}`, { name }, function(responseData){
                    //self?.set[name]?.select = responseData?.options;
                    //_log('get-select/api', { responseData })
                    self.set[name].select = responseData.options || [];
                    self.busy[name] = false;
                })
            },

        },

        mounted(){
            var self = this;
            _.each(this.set, function(item, name){
                if (item.select) self.updateSelect(name);
            })
        }

    }
}