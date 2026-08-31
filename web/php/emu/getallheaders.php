<?
//getallheaders() поддерживается в настоящее время только для PHP, запущенного как Apache-модуль

if (!function_exists('getallheaders')) {
    function getallheaders() {
        $headers = array();
        foreach($_SERVER as $key => $value) {
            if (substr($key, 0, 5) <> 'HTTP_') {
                continue;
            }
            $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $headers[$header] = $value;
        }
        return $headers;
    }

    /* не подбирает
        'Content-Length'
        'Content-Type'
    */
}