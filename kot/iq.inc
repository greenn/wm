<?

include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
$iq = cur_iq(true);


_x('dbg', true);

/*_iq::create('kot', array(), array(
	'pro-class' => 'proKot',
	'pro-func' => 'proKot',
	'pro-need' => 'need_kot',
	'css-class' => '_cssKot',
	'css-func' => '_cssKot',
	'r-class' => 'kot',
	'r-class-man' => '_kot',
	'i' => 'kot_i',
	'r-func' => 'kot',
	'r-tpl' => 'kot_tpl',
	'r-tpl-man' => 'kot_tpl_',
	'r-vtpl' => 'kot_vtpl',
	'r-api' => 'api_kot',
	'mc' => 'mcKot',
	'dbs' => 'dbsKot',
));*/

$KOT = new iq(array(
	'settings' => false,
	'web' => false,
	'domains' => false,



	'theme' => 'dhaka',

	'data' => array( //_proKot('domainName')
		//'page-title-suffix' => 'Admin Kot Panel',
		'page-title-suffix' => 'Admin Kot Panel • '._pro('base-title'),
		'page-title-glue' => ' • ',
		'portal-name' => 'blank.loc',

		'bg-num' => 4,

		//_proKot('admin', 'page-title-suffix')
		'admin' => array(
			'baseUrl' => '/admin',
			'admin-title' => 'Панель Администрирования',
			'page-title-suffix' => 'Панель Администрирования • '._pro('company-name'),
			'page-title-glue' => ' • ',
		),
	),


	'dirRoot' => dirname(__FILE__), //~ /kot/
	#def 'nameDirIq' => 'iq',
	'sid' => 'kot', //kod kot target
	'db' => $iq->db,
	'db_name' => $iq->db_name,
	'pathDbStruct' => array('dirIq', 'nameFileDbStruct'),
	'nameFileDbStruct' => 'db.php',

	'req' => array(
		'dirIq' => array(
			'kot.pro.php' => true,
			'kmod.class.php' => true,
			//'pik.class.php' => true,
			'admin.class.php' => true,
		)
	),


	//'pro_def' => false,
	'proClass' => 'proKot',
	'pro' => array(
		#def 'need' => true,
		'uv' => true,
		'db' => !true,
		'pro' => array(null), //скидываем pro-классы по умолчанию
		/*'pro~' => array(
			null, //reset defaults (binded in iq.class - iq/php/iq.class.php:52)
			array(
				//оносительно kot-директории: kot/iq
						//остальные классы уже подгруженны в cur_iq()
				'css',
				'css-pik',
			),
		),*/

	),

	'css' => array(
		array('dirIq', 'css.php'),
		array('dirIq', 'css-admin.php'),
	),


));
//dx(pro::$cfg, pro('db'));
//dx(_cssKot('seasalt'));

_kot::need('hp');
_rt::need('api');

//dx(111);