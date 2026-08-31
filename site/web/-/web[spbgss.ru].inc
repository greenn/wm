<?#6.2.0(gss)
//dx($this);

if (true && 'self-web') {
	$rootDir = $this->rootDir;
	$webDir = 'web';
	$webConnector = 'web.php';
	$webPath = join('/', array($rootDir, $webDir, $webConnector));

	include_once $webPath; //подключаем (локальный) framework Web
} else {
	$rootDir = $this->rootDir;
	$hostDir = dirname($rootDir); # {regru}/www - hosting-subdomains
	$webDir = 'web';
	$webConnector = 'web.php';
	$webPath = join('/', array($hostDir, $webDir, $webConnector));

	include_once $webPath; //подключаем (regru-vmk) framework Web
}