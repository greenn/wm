_Root = { <?//декаларация ROOT элемента?>
    data(){
        return {
            atext: false,
        }
    },

    methods: {
        is(prop){
            return this[prop]
        },
        addComponent(){},
        updateComponent(){},
        addComponentData(){},
    },

    computed: {
        // ...
    }
}