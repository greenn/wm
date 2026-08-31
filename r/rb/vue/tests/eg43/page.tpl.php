
<div id="app">
    <div>
        <span>Vue counter: {{count}}</span>
        <button @click="add">add</button>
    </div>
    <div>
        <span>Vuex counter: {{vuexcount}}</span>
        <button @click="vuexadd">add</button>
    </div>
</div>
<div id="app2">
    <div>
        <span>sessionStorage counter: {{count}} {{message}}</span>
        <button @click="add">add</button>
    </div>
</div>
<div>
    Try open this page in another tab.
</div>
<script>
    Vue.use(Vuex)
    Vue.use(vuejsStorage)

    const store = new Vuex.Store({
        state: {
            count: 0
        },
        mutations: {
            increment(state) {
                state.count++
            }
        },
        plugins: [
            vuejsStorage({ namespace: 'vuex-app' ,keys: ['count']}) //call vuejsStorage with options will return a plugin
        ]
    })

    var app = new Vue({
        el: '#app',
        storage: { //provide options in storage
            keys: ['count'],
            namespace: 'app'
        },
        data: {
            count: 0
        },
        methods: {
            add: function () {
                this.count++
            },
            vuexadd: function () {
                store.commit('increment')
            }
        },
        computed: {
            vuexcount() {
                return store.state.count
            }
        }
    })

    //advanced example
    var app2 = new Vue({
        el: '#app2',
        data: {
            message: 'Hello',
            count: 0
        },
        storage: {
            keys: ['count'],
            driver: vuejsStorage.drivers.sessionStorage,
            namespace: 'app2'
        },
        methods: {
            add: function () {
                this.count++
            }
        }
    })
</script>