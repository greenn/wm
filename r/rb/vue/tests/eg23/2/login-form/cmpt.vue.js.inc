const LoginForm = {
    template: '#login-form',
    props: ['onLogin'],
    data () {
        return {
            email: '',
            password: ''
        }
    },
    methods: {
        login () {
            this.onLogin({
                email: this.email,
                password: this.password
            })
        }
    }
}