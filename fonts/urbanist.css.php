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
	_fonts::output('/fonts/urbanist', true);
	_fonts::output(array(
		'dir' => '/fonts/urbanist',
		'styles' => '100,100i,.....,900,900i',
		'files' => true,
		'bfn' => 'Urbanist', //base font name
	));

*/
//$dir = '/fonts/urbanist';
$dir = '/fonts/urbanist2';
$dir = '/fonts/urbanist3/ttf';
$dir = '/fonts/urbanist3/webfonts';
$fn = 'Urbanist';

_x('_dir', $dir);
function _bundle($fontName, $fileName){
    $dir = _x('_dir');

    $bundle = array($fontName);

    if (is_array($fileName)) {
    	foreach ($fileName  as $relName){
    		$bundle []= "$dir/$relName";
    	}
    } else {
    	//$bundle []= "$dir/$fileName.ttf";
    	$bundle []= "$dir/$fileName.woff2";
    }

    return $bundle;
}

$config = array(
    '100' => array(
        'weight' => 100,
        'fonts' => _bundle('Urbanist Thin', 'Urbanist-Thin')
    ),
    '100i' => array(
        'weight' => 100, 'italic' => true,
        'fonts' => _bundle('Urbanist Thin Italic', 'Urbanist-ThinItalic')
    ),

	'200' => array(
        'weight' => 200,
        'fonts' => _bundle('Urbanist Extra Light', 'Urbanist-ExtraLight')
    ),
    '200i' => array(
        'weight' => 200, 'italic' => true,
        'fonts' => _bundle('Urbanist Extra Light Italic', 'Urbanist-ExtraLightItalic')
    ),
    
    '300' => array(
        'weight' => 300,
        'fonts' => _bundle('Urbanist Light', 'Urbanist-Light')
    ),
    '300i' => array(
        'weight' => 300, 'italic' => true,
        'fonts' => _bundle('Urbanist Light', 'Urbanist-LightItalic')
    ),

    '400' => array(
        'weight' => 400,
        'fonts' => _bundle('Urbanist', 'Urbanist-Regular')
    ),
    '400i' => array(
        'weight' => 400, 'italic' => true,
        'fonts' => _bundle('Urbanist Italic', 'Urbanist-Italic')
    ),

    '500' => array(
        'weight' => 500,
        'fonts' => _bundle('Urbanist Medium', 'Urbanist-Medium')
    ),
    '500i' => array(
        'weight' => 500, 'italic' => true,
        'fonts' => _bundle('Urbanist Medium Italic', 'Urbanist-MediumItalic')
    ),
    
    '600' => array(
        'weight' => 600,
        'fonts' => _bundle('Urbanist Semi Bold', 'Urbanist-SemiBold')
    ),
    '600i' => array(
        'weight' => 600, 'italic' => true,
        'fonts' => _bundle('Urbanist Semi Bold Italic', 'Urbanist-SemiBoldItalic')
    ),

    '700' => array(
        'weight' => 700,
        'fonts' => _bundle('Urbanist Bold', 'Urbanist-Bold'),
        'fonts-' => _bundle('Urbanist Bold', array(
        	'Urbanist-Bold.eot?#iefix',
        	'Urbanist-Bold.otf',
        	'Urbanist-Bold.svg#Urbanist-Bold',
        	'Urbanist-Bold.ttf',
        	'Urbanist-Bold.woff',
        	'Urbanist-Bold.woff2',
        ))
    ),
    '700i' => array(
        'weight' => 700, 'italic' => true,
        'fonts' => _bundle('Urbanist Bold Italic', 'Urbanist-BoldItalic')
    ),
    
    '800' => array(
        'weight' => 800,
        'fonts' => _bundle('Urbanist Extra Bold', 'Urbanist-ExtraBold')
    ),
    '800i' => array(
        'weight' => 800, 'italic' => true,
        'fonts' => _bundle('Urbanist Extra Bold Italic', 'Urbanist-ExtraBoldItalic')
    ),

    '900' => array(
        'weight' => 900,
        'fonts' => _bundle('Urbanist Black', 'Urbanist-Black'),
        'fonts-' => _bundle('Urbanist Black',  array(
        	'Urbanist-Black.eot?#iefix',
        	'Urbanist-Black.otf',
        	'Urbanist-Black.svg#Urbanist-Black',
        	'Urbanist-Black.ttf',
        	'Urbanist-Black.woff',
        	'Urbanist-Black.woff2',
        ))
    ),
    '900i' => array(
        'weight' => 900, 'italic' => true,
        'fonts' => _bundle('Urbanist Black Italic', 'Urbanist-BlackItalic')
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