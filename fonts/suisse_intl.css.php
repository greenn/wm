<?#2.3.13
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
/*
	oo
		iq/php/font-.class.php
        web/inc/css/tpl/font-conf.eg.css.php
*/
_needphp(
	'headers',
	'useTemplate',
	'gt',
	'x.class/_x'
);

/*
	id'q
		_fonts::output('/fonts/$ftn', true);
		_fonts::output(array(
			'dir' => '/fonts/Urbanist',
			'styles' => '100,100i,.....,900,900i',
			'files' => true,
			'bfn' => 'Urbanist', //base font name
		));
*/
$dir = '/fonts/suisse_intl';
$ftn = 'Suisse Intl'; //font-name
$fn = 'SuisseIntl'; //file-name

_x('_dir', $dir);
function _bundle($fontName, $fileName){
    $dir = _x('_dir');

    $bundle = array($fontName);

    if (!is_array($fileName)) {
		//$bundle []= "$dir/$fileName.ttf";
		//$bundle []= "$dir/$fileName.woff2";
    	$bundle []= "$dir/$fileName.otf";
    } else {
		foreach ($fileName  as $relName){
    		$bundle []= "$dir/$relName";
		}
    }

    return $bundle;
}

$config = array(
    '100' => array(
        'weight' => 100,
        'fonts' => _bundle("$ftn Thin", "$fn-Thin")
    ),
    '100i' => array(
        'weight' => 100, 'italic' => true,
        'fonts' => _bundle("$ftn Thin Italic", "$fn-ThinItalic")
    ),

	'200' => array(
        'weight' => 200,
        'fonts' => _bundle("$ftn Ultra Light", "$fn-UltraLight")
    ),
    '200i' => array(
        'weight' => 200, 'italic' => true,
        'fonts' => _bundle("$ftn Ultra Light Italic", "$fn-UltraLightItalic")
    ),
    
    '300' => array(
        'weight' => 300,
        'fonts' => _bundle("$ftn Light", "$fn-Light")
    ),
    '300i' => array(
        'weight' => 300, 'italic' => true,
        'fonts' => _bundle("$ftn Light", "$fn-LightItalic")
    ),

    '400' => array(
        'weight' => 400,
        'fonts' => _bundle("$ftn", "$fn-Regular")
    ),
    '400i' => array(
        'weight' => 400, 'italic' => true,
        'fonts' => _bundle("$ftn Italic", "$fn-Italic")
    ),

	'450' => array(
        'weight' => 450,
        'fonts' => _bundle("$ftn", "$fn-Book")
    ),
    '450i' => array(
        'weight' => 450, 'italic' => true,
        'fonts' => _bundle("$ftn Book Italic", "$fn-BookItalic")
    ),
    '500' => array(
        'weight' => 500,
        'fonts' => _bundle("$ftn Medium", "$fn-Medium")
    ),
    '500i' => array(
        'weight' => 500, 'italic' => true,
        'fonts' => _bundle("$ftn Medium Italic", "$fn-MediumItalic")
    ),
    
    '600' => array(
        'weight' => 600,
        'fonts' => _bundle("$ftn Semi Bold", "$fn-SemiBold")
    ),
    '600i' => array(
        'weight' => 600, 'italic' => true,
        'fonts' => _bundle("$ftn Semi Bold Italic", "$fn-SemiBoldItalic")
    ),

    '700' => array(
        'weight' => 700,
        'fonts' => _bundle("$ftn Bold", "$fn-Bold"),
    ),
    '700i' => array(
        'weight' => 700, 'italic' => true,
        'fonts' => _bundle("$ftn Bold Italic", "$fn-BoldItalic")
    ),

	/*
    '800' => array(
        'weight' => 800,
        'fonts' => _bundle("$ftn Extra Bold", "$fn-ExtraBold")
    ),
    '800i' => array(
        'weight' => 800, 'italic' => true,
        'fonts' => _bundle("$ftn Extra Bold Italic", "$fn-ExtraBoldItalic")
    ),
*/
    '900' => array(
        'weight' => 900,
        'fonts' => _bundle("$ftn Black", "$fn-Black"),
	),
    '900i' => array(
        'weight' => 900, 'italic' => true,
        'fonts' => _bundle("$ftn Black Italic", "$fn-BlackItalic")
    ),
);


$css = useTemplate(INC.'/css/tpl/font.css.php', array(
    'config' => $config,
    'fontName' => $ftn,
    'filter' => $filter = gt('filter'),
    'display' => $display = gt('display'),
    //'subset' => $subset = gt('subset'),
));

headers('css', 'utf8', 'nosniff', etag::ctx(
    __FILE__,
    etag::extra($filter)
), SITE_CACHE); /*#cs1*/

print $css;