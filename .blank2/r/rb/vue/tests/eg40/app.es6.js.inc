<?
//https://v3.ru.vuejs.org/ru/guide/transitions-state.html#%D0%BE%D1%80%D0%B3%D0%B0%D0%BD%D0%B8%D0%B7%D0%B0%D1%86%D0%B8%D1%8F-%D0%BF%D0%B5%D1%80%D0%B5%D1%85%D0%BE%D0%B4%D0%BE%D0%B2-%D0%B2-%D0%BA%D0%BE%D0%BC%D0%BF%D0%BE%D0%BD%D0%B5%D0%BD%D1%82%D0%B0%D1%85
//https://codepen.io/team/Vue/pen/jOWQobb
?>

const app = Vue.createApp({
    data() {
        return {
            firstNumber: 20,
            secondNumber: 40 };

    },
    computed: {
        result() {
            return this.firstNumber + this.secondNumber;
        } } });



app.component('animated-integer', {
    template: '<span>{{ fullValue }}</span>',
    props: {
        value: {
            type: Number,
            required: true } },


    data() {
        return {
            tweeningValue: 0 };

    },
    computed: {
        fullValue() {
            return Math.floor(this.tweeningValue);
        } },

    methods: {
        tween(newValue, oldValue) {
            gsap.to(this.$data, {
                duration: 0.5,
                tweeningValue: newValue,
                ease: 'sine' });

        } },

    watch: {
        value(newValue, oldValue) {
            this.tween(newValue, oldValue);
        } },

    mounted() {
        this.tween(this.value, 0);
    } });


app.mount('#app');