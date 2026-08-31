<?
//edit htaaccess to replaec robots.txt with it
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

$Smp = _rb::name('sitemap');
//dx($Self::nc());

$pageList = array(
    'index',
    'testimonials',
    'contacts',

    'docs/personal-data-policy',
    'docs/privacy-policy',

    //'order',
	//'info/orthodox',

	'info/kladbischa',
	'info/kolumbarii',
	'info/morgi',
	'info/zagsy',

    'service/agent',
    'service/benefits',
    //'service/burial',
    'service/documents',
    'service/plans',
    'service/rituals',
    'service/transport',
);

$list = $Smp::collectPages($pageList);

if (1) {
    print $Smp::tpl('sitemap-xml', array('list' => $list));
    exit;
}

?>
<textarea style="width: 100%; height: 400px">
    <?=$Smp::tpl('sitemap-xml', array('list' => $list, 'header' => false))?>
</textarea>