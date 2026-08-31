<?
//https://v3.ru.vuejs.org/ru/examples/modal.html
//https://codepen.io/team/Vue/pen/mdPoyvv
?>
const app = Vue.createApp({
    data() {
        return {
            showModal: false };

    } });


app.component("modal", {
    template: "#modal-template" });


app.mount('#app');