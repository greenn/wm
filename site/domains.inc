<?#2.0.2
//d('domains', $Project);

/*
	логично запускать в run
	данные брать из site
		где указан реф, из какого pro их брать
	при том что данные константы, пока что мало где используются

*/
$domainType = 'alpha';
foreach (array(
	'dev' => array(
		'vmk3.loc',
		'gss3.loc',
	),
	'pro' => array(
		'spbgss.ru',
	)
) as $type => $stack) {
	if (in_array(hostName, $stack)) {
		$domainType = $type;
	}
}
define('domainType', $domainType);

define('projectVersion', domainType === 'pro' ? 'Production' : 'Development');
define('devMod', projectVersion === 'Development');
define('productionMod', projectVersion === 'Production');
