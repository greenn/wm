<?#7.1.1

_needphp('json');

define('INC_RES_AS_IS', 0);
define('INC_RES_AS_HAS_RES', 1);
define('INC_RES_AS_DATA', 2);
define('INC_RES_AS_STRING', 3);
define('INC_RES_AS_ARRAY', 4);
define('INC_RES_AS_JSON_DATA', 5);

function inc($path, $res_type = INC_RES_AS_IS, $_ctx = array()) {

	//dx($path, $res_type, $_ctx);
	if (is_file($path)) {
		//dx($path, $res_type);
		switch ($res_type) {
			case INC_RES_AS_STRING:
			case INC_RES_AS_JSON_DATA: {
				ob_start();
				include ($path);
				$res = ob_get_clean();
				if ($res_type === INC_RES_AS_JSON_DATA) {

					$res = jsonTryDecode($res);
				}
				return $res;
			}
			case INC_RES_AS_HAS_RES: {
				include ($path);
				return true;
			}
			case INC_RES_AS_DATA: {
				return include ($path);
			} break;
			case INC_RES_AS_ARRAY: {
				return (array) include ($path);
			} break;
			case INC_RES_AS_IS:
			default: {
				//d('include', realpath($path));
				include ($path);
			}
		}
	}

	//case: ELSE / если не файл

    //dx($res_type);
    switch ($res_type) {
        case INC_RES_AS_STRING: return '';
        case INC_RES_AS_HAS_RES: return false;
        case INC_RES_AS_IS: return 0;
        case INC_RES_AS_ARRAY: return array();
	    case INC_RES_AS_DATA: default: return null;
    }
}


function inc_data($path, $ctx = array(), $res_type = INC_RES_AS_DATA) {
	return inc($path, $res_type, $ctx);
}

function inc_self($path, $res_type = INC_RES_AS_IS, $ctx = array()) {
    _addphp('getCaller');
    $dir = getCaller('dir');
    $path = ltrim($path, '\/');
    return inc_try("$dir/$path", $res_type, $ctx);
}

function inc_root($path, $res_type = INC_RES_AS_IS, $ctx = array()) {
    $path = ltrim($path, '\/');
    return inc(ROOT."/$path", $res_type, $ctx);
}