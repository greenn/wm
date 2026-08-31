<?
//https://codepen.io/team/Vue/pen/373b4429eb5769ae2e6d097fd954fd08https://v3.ru.vuejs.org/ru/guide/transitions-list.html#%D0%B4%D0%B8%D0%BD%D0%B0%D0%BC%D0%B8%D1%87%D0%B5%D1%81%D0%BA%D0%B8%D0%B5-%D0%BF%D0%B5%D1%80%D0%B5%D1%85%D0%BE%D0%B4%D1%8B
?>


var app = Vue.createApp({
    data: function data() {
        return {
            show: true,
            fadeInDuration: 1000,
            fadeOutDuration: 1000,
            maxFadeDuration: 1500,
            stop: true
        };
    },
    mounted: function mounted() {
        this.show = false;
    },

    methods: {
        beforeEnter: function beforeEnter(el) {
            el.style.opacity = 0;
        },
        enter: function enter(el, done) {
            var vm = this;
            Velocity(el, { opacity: 1 }, {
                duration: this.fadeInDuration,
                complete: function complete() {
                    done();
                    if (!vm.stop) vm.show = false;
                }
            });
        },
        leave: function leave(el, done) {
            var vm = this;
            Velocity(el, { opacity: 0 }, {
                duration: this.fadeOutDuration,
                complete: function complete() {
                    done();
                    vm.show = true;
                }
            });
        }
    }
});

app.mount('#dynamic-fade-demo');