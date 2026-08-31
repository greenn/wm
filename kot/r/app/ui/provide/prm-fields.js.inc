_vue.provider['__prm-fields'] = function(__cfg){

    __cfg = _.defaults({}, __cfg, {
        'api-base': 'ui',
        'api-select': 'get-select',
    });


    return {

        _vue: {
            store: [
                //'prm',
            ],
        },

        data(){
            return {
                prm: [ //дополнительные параметры к сохранению
                    { name: '', value: '', use: true }
                ],
            }
        },

        methods: {
            prmAdd(){
                this.prm.push({ name: '', value: '', use: true })
            },
            prmDeleteLast(){
                this.prm.pop();
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