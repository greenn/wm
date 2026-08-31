const LoginForm = {
    template: '#login-form',
    data () {
        return {
            email: '',
            password: ''
        }
    },
    emits: ['onLogin'],
    methods: {
        login () {
            console.log('login', [this.email, this.password])

            if (0) this.$root.onLogin({
                email: this.email,
                password: this.password
            });

            if (0) this.$parent.onLogin({
                email: this.email,
                password: this.password
            });

            if (0) this.$emit('login', {
                email: this.email,
                password: this.password
            })

            if (1) this.onLogin2({
                email: this.email,
                password: this.password
            })

        }
    }
}