<?
//d('domains', $Project);

$domainType = 'alpha';
foreach (array(
	'demo' => array(
		//'gettbot.nadube.ru',
	),
	'dev' => array(
		'granitplace.ru',
		'vmk.loc',
		'gildia.nadube.ru',
		//'gettbot.ru',
	),
	'blog' => array(
		//'vmk.loc',
		'vmk.nadube.ru',
		//'gettbot.ru',
	),
	'uc' => array(
		//'gettbot.ru',
	),
	'pro' => array(
		//'gettbot.io',
		//'gettbot.ru',
	)
) as $type => $stack) {
	if (in_array(hostName, $stack)) {
		$domainType = $type;
	}
}
define('domainType', $domainType);

//id - версия проекта
define('projectVersion', domainType === 'pro' ? 'Production' : 'Development');
//!in_array($domainType, array('pro')) ? 'Development' : 'Production';
//isset($_COOKIE['ver-pro']) ? !!json_decode($_COOKIE['ver-pro']) :
//Development / testing / acceptance / Staging / Production
define('devMod', projectVersion === 'Development');
define('productionMod', projectVersion === 'Production');
define('demoMod', domainType === 'demo');
define('isBlog', domainType === 'blog');

if (isBlog) {
	$this->_cfgUpdate(array('opt' => array('base_pid' => 'dev-blog')));
}
