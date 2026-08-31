<?#6.1.920
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

$Self = _rb::self();
$relDir = $Self::relDir();

print rb_tpl('page', 'page', array(
	'body' => $Self::tpl("$relDir/page"),

	'webkit' => array(
		'jquery',
		'lodash',
		//'llog',
		'vue', //array('vue-init', 'Editor')
		//'axios',
		//'emittery',
		//'vue-router',
	),
));