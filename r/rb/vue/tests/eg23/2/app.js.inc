<?
//https://monsterlessons.com/project/lessons/peredaem-dannye-iz-child-v-parent-v-vue
?>

var App = Vue.createApp({
    components: {
        LoginForm
    },
    data() {
        return {

        };
    },
    methods: {
        onLogin (data) {
            console.log('child component said login', data)
        }
    },
    mounted() {

    }
})

App.mount('#app')
