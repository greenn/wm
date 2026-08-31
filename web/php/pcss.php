<?#5.0.1
/*
    http://shouldiprefix.com/
	https://caniuse.com/
*/

_needphp(
	'useTemplate',
	'isAssoc',
	'fq/_is',// is_null / is_null_or_false
	'css/cbn'
);

define('PCSS_DEV_MODE', isLocalhost);

function pcss($name /*args*/){ //pcss|gcss| ~ produce/properties
    if (is_array($name)) { //case: stack of css-properties
    	return pcss_($name);
    }

    $args = func_get_args();

    if ($path = pcss_has($name)) { //base case

	    $rule = useTemplate($path, array('arg' => $args));

    } else { //case: без pcss имплементации
	    $rule = npcss($name, array_slice($args, 1));
    }

    return $rule;
}

//вывод стека свойств
function pcss_($conf, $glue = "\r\n") {
	$res = '';
	if (isAssoc($conf)) {
		foreach ($conf as $pcss => $args) {
			$rule = pcssArg($pcss, $args);
			if ($rule) {
				$res .= $rule.$glue;
			}
		}
	} else {
		$res = join($glue, $conf);
	}
	return $res;
}

function pcssArg($name, $args = null) {
	$res = '';
	if (!is_null($args)) { //!is_null_or_false($args)
		$args = ($args === '' || $args === true) ? array() : array($args);

		array_unshift($args, $name);
		$res = call_user_func_array('pcss', $args);
	}
	return $res;
}

function npcss($name, $args = false){
	$rule = ''; //case: $args = false|null
	if (!is_null_or_false($args)) {
		if (is_array($args)) $args = join(' ', $args); //ak case: array('2px', '3px', '4px'); ~ %: 2px 3px 4px;
		if ($args === true) { //case: $name уже готовое свойство, показать его как есть
			$rule = sprintf('%s;', $name);
		} else {
			$rule = sprintf('%s: %s;', $name, $args);
		}
	}
	return $rule;
}




function pcss_path($name) {
    return PHP."/pcss/$name.css.inc"; // [l >:"/\|?*]
}

function pcss_has($name) {
	$path = pcss_path($name);
	return is_file($path) ? $path : false;
}

function pcssi(){
    $args = func_get_args();
    $res = call_user_func_array('pcss', $args);
    return strtr($res, array(';' => ' !important;'));
}
function _pcss(){
    return '';
}
function pcss_if($state){
    $args = func_get_args();
    array_shift($args);
    return call_user_func_array($state ? 'pcss' : '_pcss', $args);
}


function pcss_etag_ctx(){
    _needphp('headers');
    $args = func_get_args();
    $ctx = array();
    foreach ($args as $name) {
        if (is_array($name)) {
            $ctx []= call_user_func_array(array('etag', 'extra'), array_splice($name, 1));
            //$ctx []= etag::extra(array_splice($name, 1));
            $name = $name[0];
        }
        if (pcss_has($name)) {
            $ctx []= pcss_path($name);
        }
    }
    return etag::ctxArg($ctx);
}


/* [rp to struct]

генераторы:
    t-(d)  ?

	tdb  transition drawed-borders
	tdsbg  transition dynamic-striped-bg
	un1px  underline with 1px-color-line

классы
    a_  animation off

    ac1  v+h center align
    al  absolute layout
    r  relative

	tc  transition color
    to  transition opacity

	user-select  user-select

	vc1  vertical-align

префиксы

    animation
    animation-delay
    animation-duration
    animation-name
    animation-play-state
    background-size
	border-radius
	box-shadow
    keyframes
    linear-gradient
	linear-gradient--bg
	placeholder
    repeating-linear-gradient
    transform
	transform-origin
    transition
	transition-delay
	transition-duration
	transition-property
	transition-timing-function

*/