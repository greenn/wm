<?
//https://codepen.io/team/Vue/pen/373b4429eb5769ae2e6d097fd954fd08
?>
const Demo = {
    data() {
        return {
            items: [1, 2, 3, 4, 5, 6, 7, 8, 9],
            nextNum: 10
        }
    },
    methods: {
        randomIndex() {
            return Math.floor(Math.random() * this.items.length)
        },
        add() {
            this.items.splice(this.randomIndex(), 0, this.nextNum++)
        },
        remove() {
            this.items.splice(this.randomIndex(), 1)
        },
        shuffle() {
            this.items = _.shuffle(this.items)
        }
    }
};

Vue.createApp(Demo).mount("#list-complete-demo");
