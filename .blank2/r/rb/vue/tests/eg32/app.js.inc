<?
//https://v3.ru.vuejs.org/ru/guide/computed.html#%D0%BC%D0%B5%D1%82%D0%BE%D0%B4%D1%8B-%D0%BD%D0%B0%D0%B1%D0%BB%D1%8E%D0%B4%D0%B0%D1%82%D0%B5%D0%BB%D0%B8
//https://codepen.io/team/Vue/pen/GRJGqXp
?>
const watchExampleVM = Vue.createApp({
    data() {
        return {
            question: '',
            answer: 'Questions usually contain a question mark. ;-)'
        }
    },
    watch: {
        // whenever question changes, this function will run
        question(newQuestion, oldQuestion) {
            if (newQuestion.indexOf('?') > -1) {
                this.getAnswer()
            }
        }
    },
    /*
    methods: {
        getAnswer() {
            this.answer = 'Thinking...'
            axios
                .get('https://yesno.wtf/api')
                .then(response => {
                this.answer = response.data.answer
        })
        .catch(error => {
                this.answer = 'Error! Could not reach the API. ' + error
        })
        }
    }
    */
    methods: {
        getAnswer: function getAnswer() {
            var _this = this;

            this.answer = 'Thinking...';
            axios.get('https://yesno.wtf/api').then(function (response) {
                _this.answer = response.data.answer;
            }).catch(function (error) {
                _this.answer = 'Error! Could not reach the API. ' + error;
            });
        }
    }
}).mount('#watch-example')
