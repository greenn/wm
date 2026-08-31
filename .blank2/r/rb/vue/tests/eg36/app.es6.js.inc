<?
//https://codepen.io/team/Vue/pen/c2fc5107bd3025ceadea049b3ee44ec0
?>
const Demo = {
    data() {
        return {
            query: '',
            list: [
                { msg: 'Bruce Lee' },
                { msg: 'Jackie Chan' },
                { msg: 'Chuck Norris' },
                { msg: 'Jet Li' },
                { msg: 'Kung Fury' }] };


    },
    computed: {
        computedList() {
            var vm = this;
            return this.list.filter(item => {
                return item.msg.toLowerCase().indexOf(vm.query.toLowerCase()) !== -1;
        });
        } },

    methods: {
        beforeEnter(el) {
            el.style.opacity = 0;
            el.style.height = 0;
        },
        enter(el, done) {
            gsap.to(el, {
                opacity: 1,
                height: '1.6em',
                delay: el.dataset.index * .15,
                onComplete: done });

        },
        leave(el, done) {
            gsap.to(el, {
                opacity: 0,
                height: 0,
                delay: el.dataset.index * .15,
                onComplete: done });

        } } };



Vue.createApp(Demo).mount('#demo');