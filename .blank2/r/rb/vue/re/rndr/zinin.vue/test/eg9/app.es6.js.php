const { createApp } = Vue
const { createVuetify } = Vuetify

const vuetify = createVuetify()

const app = createApp({
    template: '#app-template',
    data: () => ({
    model: 3,
    rounded: [
        '0',
        'sm',
        'md',
        'lg',
        'xl',
        'pill',
        'circle',
    ],
}),

    computed: {
    radius () {
        let rounded = 'rounded'
        const value = this.rounded[this.model]

        if (value !== 'md') {
            rounded += `-${value}`
        }

        return rounded
    },
},
}).use(vuetify).mount('#app')