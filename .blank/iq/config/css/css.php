<?#5.4.13
$cssColors = array(
	'black' => '#000000',
	'white' => '#ffffff',
);

/*
b - ярче / с - контраст / d - темнее
l - светлее / p|m - тусклее
s - насыщенный

https://coolors.co/012c49-21688a

*/

//step: добавляем проименованные название
$cssNamed = array(
		'bg-main' => 'white',

	//'tc-base' => '#011e2f', //Prussian blue
	//'tc-base' => '#21688a', //Prussian blue
	'tc-base' => '#012c49', //Prussian blue
		#https://coolors.co/0a495a-143140-012c49

	'site-w' => 1060 + 30*2, //для .site-w
	'site-ph' => 30, //для .site-w


		'tc-content' => '#999999',

		'c1' => 'slate-grey', //67829E |
		'c2' => 'china-rose', //AF4F72
		'c3' => 'english-violet',

	//'основной-текст' => 'dark-black',
);


//Thin 100 / Extra-light 200 / Light 300 / Regular 400 / Medium 500
//Semi-bold 600 / Bold 700 / Extra-bold 800 / Black 900
$ffs = array(1 => array('Exo 2', 'wght' => '300,400,500,600,700'));
$ffs []= array('Roboto', 'wght' => '300,400,500,700,900');

//$ffs []= array('Shantell Sans');
$ffs []= array('Pacifico');
$ffs []= array('Marck Script');

//$ffs []= array('NAMU Pro', 'wght' => '400', 'local' => 'namu-pro'); //oo http://vmk.loc/test/font/namu.php
//$ffs []= array('Roboto', 'wght' => '300,400,500,700,900');
//$ffs []= array('Material Icons', 'wght' => '');
//$ffs []= array('Material Symbols Outlined', 'wght' => '');



//$n_PT = site('page', 'nc', 'text'); //page-text
//dx($n_PT);

$_FS = array( //$fsData
	//'n'     => array('.ft-min', 14, 400),
	//'sm'    => array('.ft-small', 16, 400, 'mq' => array(2 => 15)),
	't'     => array('.ft-text', 18, 500),
	//'l-hg'   => array('.ft-logo.-hg', 75, 'ls' => -3),
);


$cssSet = array(
	'ffs' => $ffs,
	'f0' => 'sans-serif',
 #~ 'f1' => 'Montserrat',


	//002
	//'fs0_' => _css::dec(16, 'T'), //mq-адаптация размеров для базового размера текста

	'tr0' => '.3s ease',        // основные transition-настройки (используются почти везде)
	'tr0_t' => '.3s',           // === время из tr0

	'trq1' => '.2s '.cbn('easeOutCirc'),

	'bsh1' => '0 2px 2px 0 rgba(0,0,0,0.14),0 3px 1px -2px rgba(0,0,0,0.12),0 1px 5px 0 rgba(0,0,0,0.2)',
	'sh-c1' => '0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24)',
);

$cssData = _css::prepare_set(
	array_merge($cssSet, $cssNamed, $cssColors)
);

$cssData['fs_'] = $_FS;

_css::set($cssData);

_css::set_mq(array(
	'max' => 1275,
	'site' => _css('site-w'), //1120
	'min' => 360,

));

if (0) _css::set_mq(array(
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
	#'base' => '1',
	'base' => 1366,
	'mqr' => 1366,
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

//dx(_css::$mq);