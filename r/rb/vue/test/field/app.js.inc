<?
//https://v3.ru.vuejs.org/ru/guide/transitions-state.html#%D0%BF%D1%80%D0%B8%D0%B2%D0%BD%D0%B5%D1%81%D0%B5%D0%BD%D0%B8%D0%B5-%D0%B4%D0%B8%D0%B7%D0%B0%D0%B8%D0%BD%D0%B0-%D0%B2-%D0%B6%D0%B8%D0%B7%D0%BD%D1%8C
//https://codepen.io/sdras/pen/YZBGNp
?>

Vue.createApp({
    el: '#app',
    components: {
        VField
    },
    data: function data() {
        var fields = [
            ['lpu_long_name',]
        ];

        return {
            fields: _.transform(fields, function(res, data){
                var name = data[0];
                res[name] = {
                    value: '',
                    disabled: data[1] === true,
                }
                return res;
            }, {})
        }
    },

    methods: {
        toggleDisabled: function(item){
            item.disabled = !item.disabled;
        },

        showValues: function(){
            console.log('showValues', { fields: this.fields, values: _.reduce(this.fields, function(result, item, key){
                //console.log('_reduce', { result: result, item: item, key: key })
                result[key] = item.value;
                return result;
            }, {}) });
        }
    },

    mounted: function mounted() {
    }
}).mount('#app');


