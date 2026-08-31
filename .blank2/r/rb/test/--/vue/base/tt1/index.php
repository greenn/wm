<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
include_once $_SERVER['DOCUMENT_ROOT'].'/iq/test/vue/base/tt1/test-vue-base-tt1.class.php';
//include_once $_SERVER['DOCUMENT_ROOT'].'/metro-targets/iq.inc';

//$Self = _rw::name('test-vue-base-tt1');
//_source::req_cmpt('rw', $self_nc, 'filter-button', 2);

$Self = _rt::name('test-vue-base-tt1');
//dx($Self::_cfg(), $Self::cfg('rName'));


//$Self::req_css(1, 'app');
//_metro::req_css('ui', 'css/ft');
_rb::req_css('lay', 'flex');
_rb::req_css('page', 'css/aq');

$_body = $Self::tpl('app');

print rb_tpl('page', 'page', array(
	'body' => $_body,

	'favicon' => array(
		'href' => '/metro-targets/src/favicon/portal-favicon.ico'
	),

	'pageTitle' => 'VUE BASE TT1 — '._pro('page-title-suffix'),

	'raw-source' => join(newline2, array(
		//_css::googleFontsLinks(),
		//_css::fontsLinks(),
		//rb('aos', 'init_js', true, true),
		'<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">',
		//rb('seo', 'ya_metrika', '94297436'),
	)),

	'webkit' => array(
		'vue-env-2',
		'vuex',
		'moment'
	),
));