<?#5.2.1416

//need_pro('css.class'); //q-off
//$hasUrbanist = pro('opt', 'UrbanistFont');

//require_once(INC.'/css/font_use.php');

$cssColors = array(
	'black' => '#000000',
	'white' => '#ffffff',
	'green' => '#82FC7E',
	'violet' => '#D37FFA',
	'grey' => '8E8E8E',

		//'link-underline' => array('#8ecff9', '#eaf6fe'),
);

//step: добавляем проименованные название
$cssNamed = array(
	'main-bg' => '#0b0b0f',
	'black-bg' => 'black',

	//'основной-текст' => 'dark-black',
);


$ffs = array(
	//oo > rp/page/page.tpl.php
	'1' => array('Montserrat', 'wght' => '400,500,600,700,800,900'),

	/*'2' => array('Urbanist', 'wght' => '700,900',
		'local' => 'urbanist',
		//'raw' => '/fonts/urbanist.css',
		//'raw' => '/fonts/urbanist-max.css',
		//'raw' => '/fonts/urbanist-max.re.css',
	),*/
	//'3' => array('Inter', 'wght' => '500,700'),

	//family=Roboto:ital,wght@0,100;1,100 > 'ital,wght' => '0,100;1,100'
	/*'1' => _css::fontUrl(array(
		'url' => 'https://fonts.googleapis.com/css2?family=Roboto',
		'filter' => array()
	))*/
);

$n_PT = site('page', 'nc', 'text'); //page-text

$_FS = array( //$fsData
	'n'     => array('.ft-min', 14, 400),
	'sm'    => array('.ft-small', 16, 400, 'mq' => array(2 => 15)),
		//intro-reg_button > 10
	't-d'   => array('.ft-text.-dec', 17, 400), //, 'mq' => array(2 => 16)),
	//security-feature-content fh 21
	//security-feature-content > 15/400 fh17
	't'     => array('.ft-text', 18, 500),
		// faq-text > 12
	't-i'   => array(".ft-text.-inc, .$n_PT P", 20),
		//about-graph-date > 10
		// intro-partners-title > 11.3
	//'l'     => array('.ft-link', 16),
	'm-d'   => array('.ft-middle.-dec', 22),
		//security-features-title 'ff' => 'Urbanist', 900 > 2
	'm'     => array('.ft-middle', 24),
		//security-feature-title > 20
		//security-button-large > 12/500
		//plan-step-title > 20
		//plan-step-note > 17
		//inro-reg_button > 12
	's-d2'  => array('.ft-section.-dec2', 25, 400),
		//about-text > 14
	's-d'   => array('.ft-section.-dec', 26, 700, 'mq' => array(2 => 17)),
		//landing-features-title
		//plan-button
		//stats-title !2
	's'     => array('.ft-section', 29, 400),
		//security-features-section - fh 36
		//security-intro-text - > 14(500>600)
		//about-graph-description - > 19
		//landing-intro-text > 14
	's-i'   => array(".ft-section.-inc, .$n_PT H2", 32, 700),
		//about-graph-title - > 16

	'p'     => array('.ft-page', 36, 500),
	'l-d'   => array('.ft-large.-dec', 40, 700),
	'lg'    => array('.ft-large', 50, 700),
		//about-headline > 27
	'lg-i'  => array('.ft-large.-inc', 55),
		//about_us-quote
	'h-d'   => array('.ft-high.-dec', 60, 900, 'ff' => "Urbanist",
		'use_alt' => !$hasUrbanist, 'alt' => array('ff' => 'Montserrat', 'fw' => 700, 'ls' => -2.2)
	),
	'h'     => array('.ft-high', 64, 800),
		//about_us-h1
	'h-i'   => array('.ft-high.-inc', 68, 700, 'mq' => array(2 => 47)),
		//landing-features-point
	'hg-d'  => array('.ft-huge.-dec', 74, 'ff' => 'Urbanist', 900,
		'use_alt' => !$hasUrbanist, 'alt' => array('ff' => 'Montserrat', 'fw' => 500, 'ls' => 1.8, 'fh' => 89),
	),
		//about_us-headline-text
		//faq-h1 > 22
		//landing-intro-title > 30
	'hg'    => array('.ft-huge', 78, 900, 'fh' => 96 /*mn 92*/),
		//security-page-title m2 > 20

	'l1'     => array('.ft-logo .-fc', 18, 'fc' => false),
	'l'     => array('.ft-logo', 22),

	'l-i1'   => array('.ft-logo.-inc .-fc', 27, 'fc' => false),
	'l-i'   => array('.ft-logo.-inc', 34),
	//large
	'l-lg1'   => array('.ft-logo.-lg .-fc', 30, 'fc' => false),
	'l-lg'   => array('.ft-logo.-lg', 40),
	//huge
	'l-hg1'   => array('.ft-logo.-hg .-fc', 56, 'fc' => false),
	'l-hg'   => array('.ft-logo.-hg', 75, 'ls' => -3),
);


$cssSet = array(
	'ffs' => $ffs,
	'f0' => 'sans-serif',
 #~ 'f1' => 'Montserrat',
 #~ 'f2' => 'Urbanist',
 #~ 'f3' => 'Inter',


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

//dx(_css::$mq);