<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

//dx(pro::$cfg, pro('db'));

$kotProject = array( //cfg
	
	'dir' => $kotDir = dirname(__FILE__),
	'proDir' => "$kotDir/iq",
	//'configDir' => array('proDir'),

	'sid' => 'kot', //kod kot target
	
	'db' => pro('db'),
	'db_name' => pro('db_name'),

	'db-struct-path' => "$kotDir/iq/db.php",
	//'db-struct-path' => array('proDir', 'db.php'),

	'data' => array(
		//'page-title-suffix' => 'Admin Kot Panel',
		'page-title-suffix' => 'Admin Kot Panel • '._pro('base-title'),
		'page-title-glue' => ' • ',
	)

);

include_once $kotProject['proDir'].'/kot.pro.php';

//dx($kotProject['db']);

proKot::init($kotProject,
	array(
		'need' => true,
		'uv' => true,
		'pro' => array(
			array(
				'css',
				//'r/kot.class',
				//'r/img.class',
			),
		),
		'db' => true,
	)
);

//dx(proKot::db_struct());
//dbs::asset(proKot::db_struct()); т.к. у нас дубль из pro('db')

//_needphp('_s/init');
//_needphp('u.class');
//dx(_u::agent_info());