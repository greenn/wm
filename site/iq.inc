<?#3.3.0

include_once 'php/_webConnector.class.php';

$WebConfig = connect_web(array(
	'dirRoot' => true,
	'dirConfig' => $iqSiteDir = dirname(__FILE__),

	'hostNames' => array(
		'vmk4.loc',
		'spbgss.ru',
		'spbgss.granitplace.ru',
	),
));


_iq::add_site('gss', $WebConfig + array(
	'dirSelf' => $iqSiteDir
), true);

if(0) dx(
	//_site('gss', 'getProp', 'hostName'),
	//_site('gss', 'getProp', 'fileRouter')
);