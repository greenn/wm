<?#2.4.0(jackport-college-ncv)
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

$dir = '/fonts/jackport-ncv';
$ftn = 'JACKPORT COLLEGE NCV'; //font-name
$fn = 'JACKPORT COLLEGE NCV'; //file-name

_x('_dir', $dir);
function _bundle($fontName, $fileName){
    $dir = _x('_dir');

    $bundle = array($fontName);

    if (!is_array($fileName)) {
		$bundle []= "$dir/$fileName.ttf";
		//$bundle []= "$dir/$fileName.woff2";
    	$bundle []= "$dir/$fileName.woff";
    	//$bundle []= "$dir/$fileName.eot";
    } else {
		foreach ($fileName  as $relName){
    		$bundle []= "$dir/$relName";
		}
    }

    return $bundle;
}

$config = array(
    '400' => array(
        'weight' => 400,
        'fonts' => _bundle("$ftn", "$fn")
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