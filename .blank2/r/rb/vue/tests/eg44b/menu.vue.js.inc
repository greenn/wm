//const VOutput = {
_Page.component('v-menu', {
    template: '#v-menu',
    props: ['route-name', 'onNewRoute'],
    //model: ['route-name'],


    //emits: ['new-route'],

    data(){
        var self = this;
        return {
            //routeName: '',
            list: [
                { title: 'menu1', route: '/view/1' },
                { title: 'menu2', route: '/view/2' },
            ]
        }
    },
    methods: {
        click: function(){
            this.routeName = 'v-view1';
            console.log('click', this.routeName, arguments);
        }
    }
//}
})