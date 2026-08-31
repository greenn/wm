<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
include_once dirname(__FILE__).'/tool-css.class.php';

//$Self = _rw::name('tool-css');

print rb_tpl('page', 'page', array(
	'pageTitle' => 'CSS tools',
	'body' => rw_tpl('tool-css', 'app'),
	'webkit' => array(
		'jquery', 'lodash',
		'vue', 'vue-router', 'vue-storage', 'vue-env',
		'axios', 'emittery', 'w-storage'
	),
));



//js::req(-1, false, false, 'console.log(1)'); break;
//print rw_tpl('tool-css', 'template', array('title' => 'CSS'));