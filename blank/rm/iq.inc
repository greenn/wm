<?
if (defined('BLANK_RM_BOOTSTRAPPED')) return;
define('BLANK_RM_BOOTSTRAPPED', true);

$wmRoot = realpath(dirname(__FILE__).'/../..');
if ($wmRoot === false || !is_file($wmRoot.'/web/web.php')) {
    throw new RuntimeException('blank-rm-web-unavailable');
}

if (defined('ROOT') && realpath(ROOT) !== $wmRoot) {
    throw new RuntimeException('blank-rm-root-conflict');
}

$GLOBALS['ROOT'] = $wmRoot;
include_once $wmRoot.'/web/web.php';

_needphp(
    'site/v2/iq',
    'site/v2/source.class',
    'site/v2/r/rt.class'
);

_iq::add_pro('blank-rm', array(
    'selfDir' => dirname(__FILE__),
    'php' => 'blank-rm.env.inc',
    'css' => false,
    'wdDir' => false,
    'pagesDir' => false,
    'routerDir' => false,
    'rMain' => 'blankRm',
    'env' => array(
        'r' => 'blankRm',
    ),
), true);
