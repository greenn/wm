<?#2.5.14q
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

_needphp(
	'headers',
	'useTemplate',
	'gt'
);

$fn = 'NAMU Tryzub';

function _bundle($localName, $fileName){
    static $dirMap = array(
		'ttf' => '/fonts/namu/TTF_WEB',
		'otf' => '/fonts/namu/OTF_PS',
		'woff' => '/fonts/namu/TTF_WEB',
		'woff2' => '/fonts/namu/TTF_WEB',
	);


    $bundle = array($localName);

	foreach (array(
		'woff2',
		'woff',
		'ttf',
		'otf',
	) as $format) {
		$dir = $dirMap[$format];
		$bundle []= "$dir/$fileName.$format";
	}

    return $bundle;
}

$config = array(
    '400' => array( //Book
        'weight' => 400,
        'fonts' => _bundle('NAMU Tryzub', 'NAMU-Tryzub')
    ),
);


$css = useTemplate(INC.'/css/tpl/font.css.php', array(
    'config' => $config,
    'fontName' => $fn,
    #'filter' => $filter = gt('filter'), //отключаем здесь фильтр не нужен
    'display' => $display = gt('display'),
    //'subset' => $subset = gt('subset'),
));

headers('css', 'utf8', 'nosniff', etag::ctx(
    __FILE__//,
    #etag::extra($filter)
), SITE_CACHE); /*#cs1*/

print $css;