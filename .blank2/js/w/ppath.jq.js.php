<?#0.7.2 - media queries tracking

include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');
$baseName = basename(__FILE__, '.php'); // Получаем имя файла без расширения .php
$relFile = dirname(__FILE__) . '/' . $baseName;
headers('js', 'utf8', 'nosniff', etag::ctx(__FILE__, $relFile), SITE_CACHE);
include $relFile;