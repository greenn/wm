<?
$Self = _kot::self();



_rb::req_css(-3, 'css', 'aq'); # r/rb/css/aq.css.php
_rb::req_css(-3, 'css', 'flex'); # r/rb/css/flex.css.php
_rb::req_css(-1, 'css', 'reset'); # r/rb/css/css/reset.css.php
$Self::req_css('ft');



$_ctx = $Self::tempCtx(array(
	'body' => true, //case Base
	'a_body' => array(),
	'favicon' => array(),
	'baseUri' => '',
));



$_body = $_ctx['body'];
$a_body = $_ctx['a_body'];

if ($_body === true) {
	//case base


	$_body = $Self::tpl('kot-app', array(
		'baseUri' => $_ctx['baseUri']
	));


	$_a = array();
	//$_a []= 'pane="true"';

	$bgN = gt('bg', _proKot('bg-num'));
	$_a []= "bg=\"$bgN\"";

	$a_body = array_merge($a_body,$_a);
}


print rb_tpl('page', 'page', array(
	'a_body' => join(' ', $a_body),
	'body' => $_body,

	'favicon' => array(
			//oo https://icons8.com/icons/set/cat--orange
		//'href' => '/kot/img/favicon/icons8-cat-96.png',
		//'href' => '/kot/img/favicon/icons8-black-cat-96.png',
		//'href' => '/kot/img/favicon/icons8-pet-commands-summon-96.png',
		//'href' => '/kot/img/favicon/icons8-comics-96.png',
		'href' => '/kot/img/favicon/cat-icon-11-64.ico',
	),

	'pageTitle' => _pro('page-title-suffix'),

	'raw-source' => join(newline2, array(
		//_cssKot::googleFontsLinks(),
		_cssKot::fontsLinks(),
		//rb('aos', 'init_js', true, true),
		///'<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">',
		//isMe ? '' : rb('seo', 'ya_metrika', pro('ya-metrika')),
	)),

	'webkit' => array(
		'vue-env-2',
		'vuex',
		'moment'
	),
));