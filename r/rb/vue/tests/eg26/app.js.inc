<?
//https://v3.ru.vuejs.org/ru/examples/select2.html
//https://codepen.io/team/Vue/pen/eYZpwOB
?>
const app = Vue.createApp({
    template: '#demo-template',
    data() {
        return {
            selected: 2,
            options: [
                { id: 1, text: 'Hello' },
                { id: 2, text: 'World' }
            ]
        }
    }
})

app.component('select2', {
    props: ['options', 'modelValue'],
    template: '#select2-template',
    mounted() {
        const vm = this
        $(this.$el)
        // init select2
            .select2({ data: this.options })
            .val(this.modelValue)
            .trigger('change')
            // emit event on change.
            .on('change', function() {
                vm.$emit('update:modelValue', this.value)
            })
    },
    watch: {
        modelValue(value) {
            // update value
            $(this.$el)
                .val(value)
                .trigger('change')
        },
        options(options) {
            // update options
            $(this.$el)
                .empty()
                .select2({ data: options })
        }
    },
    unmounted() {
        $(this.$el)
            .off()
            .select2('destroy')
    }
})

app.mount('#el')