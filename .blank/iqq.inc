<?#2.2.0 - простое WEB подключение
$ROOT = dirname(__FILE__); //ak $ROOT = $_SERVER['DOCUMENT_ROOT'];
include_once $ROOT.'/iq/php/iq.class.php'; //1 file

$iq = new iq(array(
	'dirRoot' => $ROOT,
	'sid' => 'qq', //blank-ww|blanq
	//'opt' => array(),
	//'data' => array(),

	'hostNames-' => array( //для доменов с субдоменами
		'pohorony.granitplace.ru',
		'vmk2.loc' => '',
	),

	'settings' => true,
	'web' => true,
	'domains' => !true,
	'req' => true,
	'css' => !true,

	//'pro' => false,

	'pro_def' => false,
	'pro' => array(
		'need' => true, # web/php/pro/pro.class.php:99 ::init_need
		/*'pro' => array( # web/php/pro/pro.class.php:132 ::init_pro
			array('css.class'),  //для css = true (но внутри нельзя использовать site())
		),*/
	),

	'init' => false

));
