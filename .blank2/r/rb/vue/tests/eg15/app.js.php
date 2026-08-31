<?#2.0
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
	'headers',
	'dirUrl'
);

$js = array();
headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra(),
	//$js['parallax'] = $Self::path('parallax', 'js.inc'),
	__FILE__
), SITE_CACHE);

$dirUri = dirUrl(__FILE__);


#== https://coderoad.ru/54475900/Vue-%D0%BA%D0%BE%D0%BC%D0%BF%D0%BE%D0%BD%D0%B5%D0%BD%D1%82%D1%8B-%D0%B2%D0%BD%D1%83%D1%82%D1%80%D0%B8-%D0%BA%D0%BE%D0%BC%D0%BF%D0%BE%D0%BD%D0%B5%D0%BD%D1%82%D0%B0#54476366

?>

const App = Vue.createApp({
    //components: {}
})

App.component('Tabs', {
    template: `
    <div class="tab-container">
      <slot></slot>
    </div>
  `
})

App.component('Tab', {
    template: `
    <div class="tab">
      <strong>{{title}}</strong>
      <slot></slot>
    </div>
  `,

    props: ['title']
})

App.mount('#app')
