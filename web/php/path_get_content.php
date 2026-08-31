<?#1.0.23

define('PATH_GET_AS_EXTENSION', 0);
define('PATH_GET_AS_INCLUDE', 1);  //GET_PATH_AS_INCLUDE|PATH_CONTENT_AS_INCLUDE|PATH_GET_BY_INCLUDE|
define('PATH_GET_AS_CONTENT', 2);
///define('PATH_GET_AS_RESPONSE', 3); [rz - это уже не path_get_content, a inc]

function path_get_content($path, $path_get_type = PATH_GET_AS_EXTENSION){
    $content = false;
    //dx($path, is_file($path), $path_get_type);
    if (is_file($path)) {

        $useInclude = $path_get_type === PATH_GET_AS_INCLUDE;
        if ($path_get_type === PATH_GET_AS_EXTENSION) {
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $useInclude = $ext == 'php' || $ext == 'inc';
        }
        gIncr('preventHeaders');
        if ($useInclude) {
            ob_start();
            include ($path);
            $content = ob_get_clean();
        } else {
            $content = file_get_contents($path);
        }
	    gDecr('preventHeaders');
    } else {
        _needphp('htmlByUrl');
        $set = array(
            'selfHeaders' => true, //array(false, 'Cache-Control'),
            'selfCookies' => array(false, 'PHPSESSID'),
            'allowRedirects' => 2,
            'responseHeaders' => true
        );
        $url = hostUrl.'/'.ltrim($path, '/');
        $content = htmlByUrl($url, $set);

    }
    return $content;
}
