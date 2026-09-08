<?
// This example uses the shared WM web and an isolated v2 project environment.
if (defined('BLANK_RM_READY')) return;
$wmRoot = realpath(__DIR__.'/../..');
if (!$wmRoot || !is_file($wmRoot.'/web/web.php')) {
    throw new RuntimeException('blank-rm-web-missing');
}
if (defined('ROOT') && realpath(ROOT) !== $wmRoot) {
    throw new RuntimeException('blank-rm-root-conflict');
}
$GLOBALS['ROOT'] = $wmRoot;
include_once $wmRoot.'/web/web.php';
_needphp('site/v2/iq', 'site/v2/source.class', 'site/v2/r/rt.class');

_iq::add_pro('blank-rm', array(
    'selfDir' => __DIR__,
    'php' => 'blank-rm.env.inc',
    'css' => false,
    'pagesDir' => false,
    'routerDir' => false,
    'wdDir' => false,
    'rMain' => 'blankRm',
    'env' => array('r' => 'blankRm'),
), true);
define('BLANK_RM_READY', true);
