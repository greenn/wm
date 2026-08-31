_vue.provider['__data-list'] = function(__cfg){

    __cfg = _.defaults({}, __cfg, {
        keyProp: 'selectedKey',
        listProp: 'list',
    });

    return {
        _vue: {
            //provide: []
        },

        methods: {
            //данные элмента из списка по ключу
            getItem(key, prop){ //ak getData|getListItem|getItem
                if (!key && key !== 0) return undefined;
                var itemData = this[__cfg.listProp][key];
                //this.log('getItem', { key, list: this[__cfg.listProp], itemData: itemData })
                if (!itemData) return null;
                return prop ? itemData[prop] : itemData;
            },

            //данные выбрраного элмента из списка
            selectedItem(prop){
                var key = this[__cfg.keyProp];
                //this.log('selectedItem', { key, itemData: this.list[key] })
                return this.getItem(key, prop)
            },
        },
    }
}