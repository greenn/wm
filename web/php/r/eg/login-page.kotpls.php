<?
include_once $_SERVER['DOCUMENT_ROOT'].'/app/iq.php';
_needphp('headers', 'r');

$r1 = ar(__FILE__, R_BASE, 'login');
$r2 = ar(__FILE__, R_BASE);
$r3 = ar(__FILE__, R_RELATIVE);

dx($r1, $r2, $r3);

//$сache = $r->cache_etag_kotpls();

//$r->cache_etag('kotpls',__FILE__, 'tpl');
//$r->cache_etag_kotpls(__FILE__, 'tpl');
$r->cache_etag_kotpls = array('etag_file' => __FILE__);
$r->cache = $r->cache_etag_js;

dx($r);

headers('html', 'utf8', 'nosniff', $r->cache); //$rr->headers('kotpls');

?>