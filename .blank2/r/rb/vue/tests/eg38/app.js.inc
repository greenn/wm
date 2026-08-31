<?
//https://v3.ru.vuejs.org/ru/guide/transitions-state.html#%D0%B0%D0%BD%D0%B8%D0%BC%D0%B0%D1%86%D0%B8%D1%8F-%D1%81%D0%BE%D1%81%D1%82%D0%BE%D1%8F%D0%BD%D0%B8%D1%8F-%D1%81-%D0%BF%D0%BE%D0%BC%D0%BE%D1%89%D1%8C%D1%8E-%D0%BD%D0%B0%D0%B1%D0%BB%D1%8E%D0%B4%D0%B0%D1%82%D0%B5%D0%BB%D0%B5%D0%B8
?>

const Demo = {
    data() {
        return {
            number: 0,
            tweenedNumber: 0
        }
    },
    computed: {
        animatedNumber() {
            return this.tweenedNumber.toFixed(0)
        }
    },
    watch: {
        number(newValue) {
            gsap.to(this.$data, { duration: 0.5, tweenedNumber: newValue })
        }
    }
}

Vue.createApp(Demo).mount('#animated-number-demo')