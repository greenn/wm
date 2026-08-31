<?#6.2.0
//dx($this);

$dirRoot = $this->dirRoot;
$webDir = 'web';
$webConnector = 'web.php';
$webPath = join('/', array($dirRoot, $webDir, $webConnector));

include_once $webPath; //подключаем (локальный) framework Web