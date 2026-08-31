//const VOutput = {
_Page.component('v-content', {
    template: '#v-content',

    data(){
        return {
            contentHtml: '-'
        }
    },
    props: ['route-view'],
    mounted: function(){
        console.log('content-init', {
            'routeView': this.routeView
        })
    }

//}
})