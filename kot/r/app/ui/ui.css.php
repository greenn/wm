<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp('headers');

$oo = gt_on('oo'); //dbg
$v6 = gt_on('v6', true); //by design

$Self = _kot::self();
$n = $Self::nc();

$tr = _cssKot('tr0');
$trq = _cssKot('trq1');

$css = array();
$cssDir = $Self::path(); //same $Self::relDir();
headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    $css['icons'] = "$cssDir/css/icons.css.inc",
    $css['eff'] = "$cssDir/css/eff.css.inc",
	$css['spinner'] = "$cssDir/css/spinner.css.inc",
	$css['busy'] = "$cssDir/css/busy.css.inc",
    __FILE__
));

?>

<? include $css['icons'] ?>

<? //include $css['busy'] ?>

<? //include $css['eff'] ?>

<? //include $css['spinner'] ?>