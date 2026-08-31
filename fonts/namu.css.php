<?#2.5.14
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
/*
	oo
		iq/php/font-.class.php
        web/inc/css/tpl/font-conf.eg.css.php
	eg gpt

	src: url('NAMU-Pro.woff2') format('woff2'), / * Modern Browsers * /
       url('NAMU-Pro.woff') format('woff'), /* Older Browsers * /
       url('NAMU-Pro.ttf') format('truetype'), /* iOS and Android 4.1-4.3 * /
       url('NAMU-Pro.otf') format('opentype'), /* Older browsers that support OTF * /
       url('NAMU-Pro.eot'); /* IE6-IE8 * /

*/
_needphp(
	'headers',
	'useTemplate',
	'gt'//,
	//'x.class/_x'
);

/*
	_fonts::output('/fonts/urbanist', true);
	_fonts::output(array(
		'dir' => '/fonts/urbanist',
		'styles' => '100,100i,.....,900,900i',
		'files' => true,
		'bfn' => 'Urbanist', //base font name
	));

*/

$fn = 'NAMU';

function _bundle($localName, $fileName){
    static $dirMap = array(
		//'ttf' => '/fonts/namu/Desktop/TTF',
		//'ttf' => '/fonts/namu/ttf',
		'ttf' => '/fonts/namu/TTF_WEB',

		//'otf' => '/fonts/namu/Desktop/OTF',
		'otf' => '/fonts/namu/OTF_PS',

		'woff' => '/fonts/namu/TTF_WEB',
		//'woff' => '/fonts/namu/Web',

		//'woff2' => '/fonts/namu/TTF_WEB',
		'woff2' => '/fonts/namu/Web',

		'eot' => '/fonts/namu/Web',
	);


    $bundle = array($localName);

	foreach (array(
		'woff2',
		'woff',
		'ttf',
		'otf',
		'eot',
	) as $format) {
		$dir = $dirMap[$format];
		$bundle []= "$dir/$fileName.$format";
	}

    return $bundle;
}

$config = array(
    '100' => array( //Thin
        'weight' => 100,
        'fonts' => _bundle('NAMU 1400', 'NAMU-1400')
    ),

	'200' => array( //ExtraLight
        'weight' => 200,
        'fonts' => _bundle('NAMU 1600', 'NAMU-1600')
    ),

    '300' => array( //Light
        'weight' => 300,
        'fonts' => _bundle('NAMU 1750', 'NAMU-1750')
    ),

    '400' => array( //Book
        'weight' => 400,
        'fonts' => _bundle('NAMU 1850', 'NAMU-1850')
    ),

    '500' => array(
        'weight' => 500, //Medium
        'fonts' => _bundle('NAMU 1910', 'NAMU-1910')
    ),

    /*'600' => array( //SemiBold
        'weight' => 600,
        'fonts' => _bundle('Urbanist Semi Bold', 'Urbanist-SemiBold')
    ),*/

    '700' => array( //Bold
        'weight' => 700,
        'fonts' => _bundle('NAMU 1960', 'NAMU-1960')
    ),

    '800' => array( //Heavy
        'weight' => 800,
        'fonts' => _bundle('NAMU 1990', 'NAMU-1990')
    ),


    '900' => array( //Black
        'weight' => 900,
        'fonts' => _bundle('NAMU 1930', 'NAMU-1930')
    ),

);


$css = useTemplate(INC.'/css/tpl/font.css.php', array(
    'config' => $config,
    'fontName' => $fn,
    'filter' => $filter = gt('filter'),
    'display' => $display = gt('display'),
    //'subset' => $subset = gt('subset'),
));

headers('css', 'utf8', 'nosniff', etag::ctx(
    __FILE__,
    etag::extra($filter)
), SITE_CACHE); /*#cs1*/

print $css;