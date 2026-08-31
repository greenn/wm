<?
//https://monsterlessons.com/project/lessons/peredaem-dannye-iz-child-v-parent-v-vue
?>

var App = Vue.createApp({
    data () {
        return {
        }
    },
    components: {
        LoginForm
    },
    methods: {
        onLogin (data) {
            console.log('child component said login', data)
        }
    }
})

App.mount('#app')
