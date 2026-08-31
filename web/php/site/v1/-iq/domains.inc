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

//Development / testing / acceptance / Staging / Production
//id - версия проекта
define('projectVersion', domainType === 'pro' ? 'Production' : 'Development');
define('devMod', projectVersion === 'Development');
define('productionMod', projectVersion === 'Production');
//define('demoMod', domainType === 'demo');
//define('isBlog', domainType === 'blog');

//isset($_COOKIE['ver-pro']) ? !!json_decode($_COOKIE['ver-pro']) :

/*if (isBlog) {
	$this->_cfgUpdate(array('opt' => array('base_pid' => 'dev-blog')));
}*/
