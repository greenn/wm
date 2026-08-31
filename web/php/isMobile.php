<?#1.0.1

_lib('mobile-detect');

define('isMobile', mobileMode()); //isMobile|IS_MOBILE|

function mobileMode($set = null) {
    static $mobile;
    static $cn = 'isMobile'; //cookieName
    if (is_null($mobile)) {
        $mobile = new Mobile_Detect;
    }

    if (!func_num_args()) {
        return isset($_COOKIE[$cn]) ? !!json_decode($_COOKIE[$cn]) : $mobile->isMobile();
    }

    switch ($case = is_string($set) ? $set : var_export($set, true)) {
        case 'true': {
            $isMobile = json_encode(true);
            setcookie($cn, $isMobile, 0, '/', HOST);
            $_COOKIE[$cn] = $isMobile;
        } break;
        case 'false': {
            $isMobile = json_encode(false);
            setcookie($cn, $isMobile, 0, '/', HOST);
            $_COOKIE[$cn] = $isMobile;
        } break;
        case 'auto': case 'null': {
            if (isset($_COOKIE[$cn])) {
                setcookie($cn, '', 1, '/', HOST);
                unset($_COOKIE[$cn]);
            }
        } break;
    }

    return mobileMode();
}