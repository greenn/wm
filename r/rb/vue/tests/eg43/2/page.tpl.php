

<div id="app2">
    <div>
        <span>sessionStorage counter: {{count}} {{message}}</span>
        <button @click="add">add</button>
    </div>
    <app-sub :count="count"></app-sub>
</div>
<div>
    Try open this page in another tab.
</div>

<script>

    Vue.use(vuejsStorage)

    //advanced example
    var app2 = new Vue({
        el: '#app2',
        data: {
            message: 'Hello',
            count: 0
        },
        storage: {
            keys: ['count'],
            //driver: vuejsStorage.drivers.sessionStorage,
            //if you want to use sessionStorage instead of localStorage
            namespace: 'app2'
        },
        components: {
            "app-sub": {
                data(){
                    return {
                        counter: 0
                    }
                },
                storage: {
                    keys: ['counter'],
                    //driver: vuejsStorage.drivers.sessionStorage,
                    namespace: 'app2'
                },
                props: ['count'],
                template: "#app-sub",
                methods: {
                    inc_global: function () {
                        this.count++
                    },
                    inc_self: function () {
                        this.counter++
                    }
                }
            }
        },
        methods: {
            add: function () {
                this.count++
            }
        }
    })
</script>