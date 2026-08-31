<?#1.8.1
$ROOT = dirname(__FILE__); //ak $ROOT = $_SERVER['DOCUMENT_ROOT'];
include_once $ROOT.'/iq/php/iq.class.php';

$iq = new iq(array(
	'data' => array( //_pro('company-name')
		'base-title' => 'Blank Сайт', //Сайт-Новый
		'company-name' => 'Проект Blank', //Проект Новый | Проект Сайт
	),

	'dirRoot' => $ROOT,
	'sid' => 'blank',

	'hostNames' => array(
		'blank.ru',
		'blank.loc' => '',
	),

	'opt' => array(
		'base_pid' => 'index', //pid для титульной страницы
		'qp' => true, //передача get-параметров в файлы (значение по-умолчанию)
	),

	'pro' => array(
		//'need' => true, #def = true
		'uv' => true,
		'db' => true,
		'pro' => array(
			array(
				//'jsonld.class',
				'r/site.class',
			),
		),
	),

	'init' => array(
		//'cur_iq' => true, # def 'cur_iq' => true
		//'cors' => true, # def 'cors' => true
		//'qp' => true, # def 'qp' => true
		//'aos' => true, # def 'aos' => false
		//'aos' => array(array(1)), # def 'aos' => false

		//'lang' => false, # def 'lang' => false
		//'user_v1' => false, # def 'user_v1' => false
	)

));
