<?#6.1.0(lv)
//dx($this);

if (!true && 'local') {
	$rootDir = $this->dirRoot;
	$webDir = 'web';
	$webConnector = 'web.php';
	$webPath = join('/', array($rootDir, $webDir, $webConnector));

	include_once $webPath; //подключаем (локальный) framework Web
} else {
	$rootDir = $this->dirRoot;
	$hostDir = dirname($rootDir); # {regru}/www - hosting-subdomains
	$webDir = 'web';
	$webConnector = 'web.php';
	$webPath = join('/', array($hostDir, $webDir, $webConnector));

	include_once $webPath; //подключаем (regru-vmk) framework Web
}