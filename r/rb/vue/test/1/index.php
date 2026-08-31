<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

$Self = _rt::self();
$relDir = $Self::relDir();

print rb_tpl('page', 'page', array(
	'body' => $Self::tpl("$relDir/page"),
	'webkit' => array(
		'jquery', 'lodash',
		//'llog',
		'vue',
		'axios', 'emittery'
		//array('vue-init', 'Editor')
	),
));