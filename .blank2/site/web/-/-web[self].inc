<?#6.1.0
//dx($this);

$rootDir = $this->rootDir;
$webDir = 'web';
$webConnector = 'web.php';
$webPath = join('/', array($rootDir, $webDir, $webConnector));

include_once $webPath; //подключаем (локальный) framework Web