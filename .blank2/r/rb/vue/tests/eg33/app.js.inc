<?
//https://codepen.io/team/Vue/pen/e1cea580e91d6952eb0ae17bfb7c379d
?>
const Demo = {
    data() {
        return {
            items: [1, 2, 3, 4, 5, 6, 7, 8, 9],
            nextNum: 10 };

    },
    methods: {
        randomIndex() {
            return Math.floor(Math.random() * this.items.length);
        },
        add() {
            this.items.splice(this.randomIndex(), 0, this.nextNum++);
        },
        remove() {
            this.items.splice(this.randomIndex(), 1);
        } } };



Vue.createApp(Demo).mount('#list-demo');