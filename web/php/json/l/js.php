<?

_needphp('j');
define('jpSite', WEB.'/data/site.json.php');
define('jpCompany', WEB.'/data/tf-bnk.json.php');
define('jpPagelist', WEB.'/data/pagelist.json.php');
define('jpPidlist', WEB.'/data/pidlist.json.php');
define('jpModlist', WEB.'/data/modlist.json.php');

_needphp('r');
$rStack = array();

define('rProds', 'products'); $rStack []= 'rProds';

$vMM = gfv('mmv', array(
	'1b' => 'v1',
	'2b' => 'v2',
	'3' => 'v3',
	'4' => 'v4'
), '4');
define('rMainMenu', "top-menu/$vMM"); $rStack []= 'rMainMenu';

$vTB = gf_is('block-menu', 'v1') ? '/v1' : '';
define('rblocksMenu', "block-menu$vTB"); $rStack []= 'rblocksMenu';

define('rSearch', 'search/v2'); $rStack []= 'rSearch';

define('rSitemap', 'sitemap'); $rStack []= 'rSitemap';

//dx($rStack);
foreach ($rStack as $rn) {
	$Name = substr($rn, 1);

	define("rn$Name", rDir.'/'.constant($rn));
	define("rp$Name", rPath.'/'.constant($rn));
}