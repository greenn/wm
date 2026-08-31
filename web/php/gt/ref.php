<? //[o]

define('refUrl', isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : false);

_needphp('parseUrl');
$refUrl = parseUrl(refUrl);

define('refPath', refUrl ? $refUrl[PHP_URL_PATH] : false);
define('_refPath_', refPath ? trim(refPath, '/') : false); //refPath_trimmed
define('refQuery', refUrl ? $refUrl[PHP_URL_QUERY] : false);

//dx(refUrl, refQuery, $refUrl);