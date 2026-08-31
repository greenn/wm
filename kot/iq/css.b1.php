<?#5.2.1416

//need_pro('css.class'); //q-off
//$hasUrbanist = pro('opt', 'UrbanistFont');

//require_once(INC.'/css/font_use.php');

$cssColors = array(
	'white' => '#ffffff',
	'seasalt' => '#fafafa',
	'flash-white' => '#efefef', //slightly-grey
	'fire-red' => '#d62829',
	'blue-grey' => '#5A6472',
	'blue-azure' => '#3081E1',
		//alink
	'tekhelet' => '#551a8b', //Техелет — "сине-фиолетовый"
		//visited-alink

);

//step: добавляем проименованные название
/*
https://coolors.co/fafafa
https://yandex.ru/yandsearch?text=цвет яндекса&lr=2
https://colorscheme.ru/color-names.html
https://coolors.co/5A616F-606674
*/
$cssNamed = array(
	'main-bg' => 'seasalt',
	'side-bg' => 'white',
	'menu-sub-border' => 'warn-border',
	'r-button-bg' => 'warn-border',
	'content-bg' => 'white',
	'black-text' => 'rgba(0, 0, 0, 0.87)',
	'spinner' => '#c8c8c8', //Silver
	'spinner-bg' => '#f2f2f2', //White smoke
	'section-head-hover' => '#f5f5f5', //White smoke 2
		//closed-section head-hover
	'field-border' => 'rgba(0, 0, 0, 0.4)', //White smoke 2
	'table-border' => 'rgba(64, 77, 92, 0.25)',
	'table-th' => 'rgb(239, 239, 239)',
	'warn-border' => 'fire-red',

	//'основной-текст' => 'dark-black',
);


$ffs = array(
	'1' => array('Roboto', 'wght' => '300,400,500,700'),
);

//$n_PT = site('page', 'nc', 'text'); //page-text

$_FS = array( //$fsData
	'n'     => array('.ft-min', 11, 400),
	'sm'     => array('.ft-small', 14, 400),
	'button'     => array('.ft-button', 14, 500),
	'menu'    => array('.ft-menu', 16, 400),
	't'     => array('.ft-text', 16, 500),
	'mT'     => array('.ft-msg-text', 17, 400),
	'm'     => array('.ft-middle', 18, 500),
	'mH'     => array('.ft-msg-head', 21, 400),
	//'s'     => array('.ft-section', 29, 400),
	//'p'     => array('.ft-page', 36, 500),
	'h'     => array('.ft-high', 20, 500),
	//'hg'    => array('.ft-huge', 78, 900, 'fh' => 96 /*mn 92*/),
	//'l-hg'   => array('.ft-logo.-hg', 75, 'ls' => -3),
);


$cssSet = array(
	'ffs' => $ffs,
	'f0' => 'sans-serif',
	#~ 'f1' => 'Montserrat',


	//002
	//'fs0_' => _cssKot::dec(16, 'T'), //mq-адаптация размеров для базового размера текста

	'tr0' => '.3s ease',        // основные transition-настройки (используются почти везде)
	'tr0_t' => '.3s',           // === время из tr0

	'trq1' => '.2s '.cbn('easeOutCirc'),

	'bsh1' => '0 2px 2px 0 rgba(0,0,0,0.14),0 3px 1px -2px rgba(0,0,0,0.12),0 1px 5px 0 rgba(0,0,0,0.2)',
	'sh-c1' => '0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24)',
);

$cssData = _cssKot::prepare_set(
	array_merge($cssSet, $cssNamed, $cssColors)
);

$cssData['fs_'] = $_FS;

_cssKot::set($cssData);



_cssKot::set_mq(array(
	//const MQ6 => 1980,
	//const MQ1D => 1920,
	'max' => 1832, //$MQX,
	'plan' => 1800, //$MQX,
	//const MQ1E => 1600,
	//const MQ1C => 1366,
	//const MQ1B => 1280,
	//'MQ1' => 1214, //MQ1
	//'1' => 1214, //MQ1
	'1' => 1214, //MQ1
	'base' => '1',
	//'header' => 1214,
	'header' => '1',
	//static $_MQ1,
	//static $MQ_S,
	//static $_MQ_S,
	'2++' => 960, // 2-- / 2++ / 26
	'2+' => 877, //MQ2C / 2-2 / 2+ / 2- / 23
	'2' => 810, //MQ2
	'3+' => 667, //MQ3B
	'3' => 480, //MQ3
	//const MQ4 => 414,
	//const MQ0B => 360,
	//const MQ0 => 300,
	'min' => 360,
	//static $_MQ0,
	//static $MQZ,
));

//dx(_cssKot::$mq);