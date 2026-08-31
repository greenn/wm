let VButton = {
    template: '#cmpt-button',
    name: 'v-button',
    props: ['title'],
    created() {
        console.log('cmpt-button/created', { attrs: this.$attrs }) // { onChange: () => {}  }
    },
    data() {
        return {
            pressed: false
        }
    },
    computed: {
        styleObject: function(){
            return {
                'border-style': this.pressed ? 'dashed' : 'dotted',
                //'color': 'red',
            }
        }
    },
    methods: {
        click(){
            this.pressed = !this.pressed;
            //this.$parent.curCmptName = 'cmpt2';

            console.log('button/click', {
                //'this.$parent.curCmptName': this.$parent.curCmptName,
                //'this.$parent.changeCmpt': this.$parent.changeCmpt
                'this.$parent': this.$parent
            });

            this.$parent.changeCmpt();
        }

    }

}
//VButton = Vue.defineComponent(VButton);