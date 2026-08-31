const LoginForm = {
    template: '#login-form',
    //props: ['onLogin'],
    emits: ['emitLogin'],
    data () {
        return {
            email: '',
            password: ''
        }
    },
    methods: {
        submitLogin () {
            this.$emit('emitLogin', {
                email: this.email,
                password: this.password
            })
        }
    }
}