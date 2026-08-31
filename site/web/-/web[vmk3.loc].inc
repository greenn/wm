<?#6.2.1
//dx($this);

$rootDir = $this->rootDir;
//echo '<pre>', var_export($rootDir), '</pre>'; exit;
//echo '<pre>', var_export($this), '</pre>'; exit;
$hostDir = dirname($rootDir); # {OS-S17}/domains
$webDir = '18.web';
$webConnector = 'web/web.php';
$webPath = join('/', array($hostDir, $webDir, $webConnector));

include_once $webPath; //подключаем framework Web