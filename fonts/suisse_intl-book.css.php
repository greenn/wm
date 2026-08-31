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

$dir = '/fonts/suisse_intl';
$ftn = 'Suisse Intl Book'; //font-name
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
	'400' => array(
		'weight' => 400,
		'fonts' => _bundle("$ftn", "$fn-Book")
	),
	'400i' => array(
		'weight' => 400, 'italic' => true,
		'fonts' => _bundle("$ftn Italic", "$fn-BookItalic")
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