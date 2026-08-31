<?#6.1.0
//dx($this);

$rootDir = $this->dirRoot;
$hostDir = dirname($rootDir); # {OS-S17}/domains
$webDir = '18.web';
$webConnector = 'web/web.php';
$webPath = join('/', array($hostDir, $webDir, $webConnector));

include_once $webPath; //подключаем framework Web