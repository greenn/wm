<?
//https://codepen.io/team/Vue/pen/e1cea580e91d6952eb0ae17bfb7c379d
?>
const Demo = {
    data() {
        return {
            items: [1, 2, 3, 4, 5, 6, 7, 8, 9]
        };
    },
    methods: {
        shuffle() {
            this.items = _.shuffle(this.items);
        }
    }
};

Vue.createApp(Demo).mount("#flip-list-demo");
