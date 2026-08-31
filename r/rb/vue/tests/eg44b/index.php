<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

$Self = _rt::self();
$relDir = $Self::relDir();

print rb_tpl('page', 'page', array(
	'body' => $Self::tpl("$relDir/page"),
	'webkit' => array(
		#wd
		'jquery', 'lodash',
		//'llog',
		#vue-app
			'vue', 'vue-router',
			'axios', 'emittery'
			//array('vue-init', 'Editor')
	),
));