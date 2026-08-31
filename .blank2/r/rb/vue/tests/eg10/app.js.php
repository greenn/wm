<?#2.0
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$js = array();
headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra(),
	//$js['parallax'] = $Self::path('parallax', 'js.inc'),
	__FILE__
), SITE_CACHE);

?>


const app = Vue.createApp({})

app.component('alert-box', {
    template: '#alert-box',
    template_: `
        <div class="demo-alert-box">
              <strong>Error!</strong>
              <slot></slot>
        </div>
    `
})

app.mount('#app')

/////
app.component('my-checkbox', {
    template: '<div class="checkbox-wrapper" @click="check"><div :class="{ checkbox: true, checked: checked }"></div><div class="title">{{ title }}</div></div>',
    data() {
        return { checked: false, title: 'Check me' }
    },
    methods: {
        check() { this.checked = !this.checked; }
    }
});