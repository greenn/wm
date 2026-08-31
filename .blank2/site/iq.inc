<?#3.3.0

include_once 'php/_webConnector.class.php';

$WebConfig = connect_web(array(
	'rootDir' => true,
	'configDir' => $iqSiteDir = dirname(__FILE__),
	'hostNames' => array(
		'vmk3.loc',
		'spbgss.ru',
		'spbgss.granitplace.ru',
	),
));

_iq::add_site('gss3', $WebConfig + array(
	'selfDir' => $iqSiteDir
), true);