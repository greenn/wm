<?#7.0.0

_x('dbg-ck', true);
_cssAdmin::init(array(
	'dir' => dirname(__FILE__).'/css-admin',
	'prm' => 'admin-prm.inc',
	'colors' => 'admin-colors.inc',
	'fonts' => 'admin-fonts.inc',
	'mq' => 'admin-mq.inc',
));

//dx(_cssAdmin::$db);