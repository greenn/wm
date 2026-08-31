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
        doLogin (data) {
            console.log('doLogin', data)
        }
    },
    mounted() {

    }
})

App.mount('#app')
