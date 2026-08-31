//const VButton = {
_Page.component('v-button', {
    template: '#v-button',

    props: [],
    emits: ['act'],
    _emits: { //с-валидацией
        act: function(){

            console.log('(emit)act');
            return false;
        }
    },
    methods: {
        click: function(){
            console.log('[button]click');
        }
    }
})
//}