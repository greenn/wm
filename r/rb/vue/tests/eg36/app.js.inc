<?
//https://codepen.io/team/Vue/pen/c2fc5107bd3025ceadea049b3ee44ec0
?>
'use strict';

var Demo = {
    data: function data() {
        return {
            query: '',
            list: [{ msg: 'Bruce Lee' }, { msg: 'Jackie Chan' }, { msg: 'Chuck Norris' }, { msg: 'Jet Li' }, { msg: 'Kung Fury' }] };
    },

    computed: {
        computedList: function computedList() {
            var vm = this;
            return this.list.filter(function (item) {
                return item.msg.toLowerCase().indexOf(vm.query.toLowerCase()) !== -1;
            });
        }
    },

    methods: {
        beforeEnter: function beforeEnter(el) {
            el.style.opacity = 0;
            el.style.height = 0;
        },
        enter: function enter(el, done) {
            gsap.to(el, {
                opacity: 1,
                height: '1.6em',
                delay: el.dataset.index * .15,
                onComplete: done });
        },
        leave: function leave(el, done) {
            gsap.to(el, {
                opacity: 0,
                height: 0,
                delay: el.dataset.index * .15,
                onComplete: done });
        }
    } };

Vue.createApp(Demo).mount('#demo');