<?#6.0.1
//dx($this);

$rootDir = $this->dirRoot;
$hostDir = dirname($rootDir); # {OS-S17}/domains
$webDir = '/18.web';
$webConnector = '/web/web.php';
$webPath = join('', array($hostDir, $webDir, $webConnector));

include_once $webPath; //подключаем framework Web

$catalogDomain = 'catalog.vmk.loc';
$catalogHostDir = $hostDir."/$catalogDomain";
return array(
	'catalog-data-path' => $catalogHostDir,
	'catalog-host-name' => $catalogDomain,
);