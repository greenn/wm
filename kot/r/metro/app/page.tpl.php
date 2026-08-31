<?
$Self = _kot::self();

//$Self::req_css(1, 'app');
//_kot::req_css('ui', 'css/ft');
_rb::req_css('lay', 'flex');
_rb::req_css('page', 'css/aq');
_rb::req_css('page', 'css/reset');

$Self::req_css('ft');

$_ctx = $Self::tempCtx(array());

$_body = $Self::tpl('app');
$a_body = array();
//$a_body []= 'pane="true"';

print rb_tpl('page', 'page', array(
	'a_body' => join(' ', $a_body),
	'body' => $_body,

	'favicon' => array(
		'href' => '/kot/src/favicon/portal-favicon.ico'
	),

	'pageTitle' => _pro('page-title-suffix'),

	'raw-source' => join(newline2, array(
		//_cssKot::googleFontsLinks(),
		_cssKot::fontsLinks(),
		//rb('aos', 'init_js', true, true),
		'<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">',
		isMe ? '' : rb('seo', 'ya_metrika', '94297436'),
	)),

	'webkit' => array(
		'vue-env-2',
		'vuex',
		'moment'
	),
));