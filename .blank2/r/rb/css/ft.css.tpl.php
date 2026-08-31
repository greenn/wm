<?#6.1.1
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

$Self = _rb::self();

$sections = array();
$sections['ft'] = $Self::path('ft.css.inc');
$sections['ft/ftq'] = $Self::path('ft/ftq.css.inc');
$sections['ft/fs'] = $Self::path('ft/fs.css.inc');
$sections['ft/fw'] = $Self::path('ft/fw.css.inc');
$sections['ft/fc'] = $Self::path('ft/fc.css.inc');
$sections['ft/ffs'] = $Self::path('ft/ffs.css.inc');
$sections['ft/vars'] = $Self::path('ft/vars.css.inc');
///$sections['ft/mq'] = $Self::path('ft/mq.css.inc');

$sections = array(
	'base' => true,
	'fq' => true,
    'ftq' => true,
    'fs' => true, //font-sizes
    'fw' => true, //font-weights
    'fc' => true, //colors
	'ffs' => true, //font-family
	'vars' => true, //
	///'mq' => true,
	'custom' => true,
);

$_ctx = $Self::tempCtx(array(
	'headers' => true,
	//'class' => '_css',
	'method' => '_css',
	'class' => true,
	'sections' => array(),
	'order' => array(),
	'_css' => array(), //{a} спущенные сверху настройки css
	'css' => '', //{s} переданный css / customCss
));
//$class = $_ctx['class'];
//${$class} | call_user_func_array(array(${$class}, 'val'), array('prop'))

$showHeaders = $_ctx['headers'];

$customCss = $_ctx['css'];
$_css = $_ctx['_css'];

$method = $_ctx['method'];
$class = $_ctx['class'] === true ? $method : $_ctx['class'];
$sections = array_replace($sections, $_ctx['sections']);
$order = $_ctx['order'];
if (!$order) $order = array_keys($sections);



$etagCtx = array(
    //pcss_etag_ctx('transition'),
    //etag::extra(),
     __FILE__
);
if (is_array($showHeaders)) {
	$etagCtx += $showHeaders;
}

foreach ($order as $sectionName) {
    if (_prop($sections, $sectionName)) {
		$etagCtx []= $Self::path("ft/$sectionName.css.tpl.php");
    }
}

//dx($etagCtx, $sections);
if ($showHeaders) {
	headers('css', 'utf8', 'nosniff',
		call_user_func_array('etag::ctx', $etagCtx)
	);
} else {
	//get headers
}


foreach ($order as $sectionName) {
    if (_prop($sections, $sectionName)) {
        $ctx = array(
            'method' => $method,
            'class' => $class,
        );
        switch ($sectionName) {
            case 'base': {
                if (_prop::has($_css, 'fs0')) {
                    $ctx['fs0'] = $_css['fs0']; //_prop($_css, 'fs0');    
                }                 
            } break;
            case '-': {} break;
        }

        print $Self::tpl("ft/$sectionName.css", $ctx);
    }
}

print $customCss;