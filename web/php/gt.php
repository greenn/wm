<?#6.2.0

//oo web/test/web/php/gt

# $_GET переменные
function gt($name, $otherwise = null){
    return gt_has($name) ? $_GET[$name] : $otherwise;
}

//получение версии
function gtv($name, $defValue = 1, $maxValue = false) {
	$v = gt($name, $defValue);
	$overMax = $maxValue && ($v > $maxValue);
	$notV = !is_numeric($v);
	if ($notV || $overMax) {
		$v = $defValue;
	}
	return $v;

}

function gt_has($name) {
    return isset($_GET[$name]);
}
function gt_is($name, $val = null) {
    $hasName = gt_has($name);
    return $hasName && ($val === null || $_GET[$name] === $val);
}
function gt_on($name, $def = false) {
    $hasName = gt_has($name);
    return $hasName ? (!_g_is_off(gt($name))) : $def;
}
function gt_off($name) {
	$hasName = gt_has($name);
	return $hasName && _g_is_off(gt($name));
}

function _g_is_off($value){
	return in_array($value, array('off', '0', 'no'));
}

//возможность выбора числового значения через get-параметр
/*
    $v = gn('rL', 2, 1);
*/
function gn($gName = 'n', $maxN = 2, $defaultN = 1){
    $N = (integer) gt($gName);
    return ($N >= 1 && $N <= $maxN) ? $N : $defaultN;
}
//возможность выбора значения через get-параметр
/*
    $v = gv('m', array(5, 6), 1);
    $v = gv('M', array('a' => 200, 'b' => 400), 'b');
*/
function gv($n = 'n', $s = array(), $d = 0){
    $N = gt($n);
    return (gt_has($n) && isset($s[$N]))
        ? $s[$N]
        : (isset($s[$d])
            ? $s[$d]
            : $d);
}
/*function gv($gName = 'n', $valStack = array(), $defaultN = 0){
    $N = gt($gName);
    return (gt_has($gName) && isset($valStack[$N])) ? $valStack[$N] : (isset($valStack[$defaultN]) ? $valStack[$defaultN] : $defaultN);
}*/

//собственным парсинг get-параметров, учитывающий дополнительную информацию
//[ff gcpx, eXtended gcp]
//[eg gcp(pageQuery, 1, 1), gcp($_SERVER['QUERY_STRING'])]
function gcp($string, $associated = true, $normalized = false) { //2.1.10
    $r = array(); //d($string, $associated, $normalized);
    if (!is_string($string)) return $r;

    $queryParts = explode('&', urldecode($string)); //d($queryParts);
    foreach ($queryParts as $index => $match) {
        $queryVal = explode('=', $match, 2); //d($match, $queryVal);
        $a = array(
            'index' => $index,
            'key' => $queryVal[0],
            'hasValue' => $hasValue = isset($queryVal[1]),
            'value' => $hasValue ? $queryVal[1] : false,
        );
        $a['val'] = $a['value'] ? $a['value'] : $a['key'];
        $r []= $a;
    }

    if ($normalized) {
        $rn = array();
        foreach ($r as $a) {
            if ($a['key'] || $a['value']) {
                $rn []= $a;
            }
        }
        $r = $rn;
    }

    if ($associated) {
        $ra = array();
        foreach ($r as $a) {
            //[ad $associated == '2' //byVal]
            $ra[$a['key']] = $a['value'];
        }
        $r = $ra;
    }
    return $r;
}
//[eg gcp('?&в?&amp;AA&22=%27b"&==&^^===&=s')]
//[v1] $r = '~(amp;)?([^&]*)\&?~'; //$r = '~([^&]*)\&?~'; //preg_match_all($r, $string, $queryParts, PREG_SET_ORDER); $r = '~^([^=]*)?(=)?(.+)?$~';

//проиндексированные get-параметры, полученные собственным парсингом (gcp),
//учитывающий дополнительную информацию
//oo web/test/web/php/gt/gi.php
//oo web/test/web/php/gt/gi2.php?a=2&3
function _gi($normalized = false){
    static $g = false;
    static $gn = false;
    $query = pageQueryMark ? pageQuery : false;
    $r = $normalized
        ? ($gn ? $gn : $gn = gcp($query, false, true))
        : ($g ? $g : $g = gcp($query, false, false));
    //d($r, $query, pageQueryMark, pageQuery);
    return $r;
}
//возвращает get-параметр (или его параметр) по индексу
/*  prop
		index
		key
		hasValue
		value
		val
*/
function gi($index = 0, $prop = true, $otherwise = null) {
	//dx(_gi($normalized));
    $item = prop(_gi(true), $index);
    return is_stringable($prop) ? prop($item, $prop, $otherwise) : $item;
}
function gri($index = 0, $prop = true, $otherwise = null) {
    $item = prop(_gi(false), $index);
    return is_stringable($prop) ? prop($item, $prop, $otherwise) : $item;
}

function gi_key($index = 0, $otherwise = null){
    return gi($index, 'key', $otherwise);
}
function real_gi_key($index = 0, $otherwise = null){
	if ($gi = gi($index)) {
		if (!$gi['hasValue']) { //case: real_gi
			return $gi['key'];
		}
	}
	return $otherwise;
}
//function gi_key

//[td]
function gi_index(){}
function gi_val(){}
//gri - rawIndex ~ not-normalized
function gri_(){}

/* version with REFERER*/
function grt($name, $otherwise = null){
    $grt = grt_get();
    return ($grt && isset($grt[$name])) ? $grt[$name] : $otherwise;
}
function grt_get(){
    //static $cache = array();
    if (!isset($_SERVER['HTTP_REFERER'])) {
        return false;
    } else {
        $referer_query = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY);
        parse_str($referer_query, $referer_params);
        return $referer_params;
    } 
}
function grt_has($name) {
    $grt = grt_get();
    return $grt ? isset($grt[$name]) : false;
}
function grt_is($name, $val) {
    $grt = grt_get();
    return $grt && isset($grt[$name]) && ($grt[$name] === $val);
}
function grt_on($name) {
    $grt = grt_get();
    //return $grt && isset($grt[$name]) && (!in_array($grt[$name], array('off', '0', 'no')));
    return $grt && isset($grt[$name]) && (!_g_is_off($grt[$name]));
}
function grn($gName = 'n', $maxN = 2, $defaultN = 1){
    $N = (integer) grt($gName);
    return ($N > 1 && $N <= $maxN) ? $N : $defaultN;
}
function grv($n = 'n', $s = array(), $d = 0){
    $N = grt($n);
    return (grt_has($n) && isset($s[$N])) ? $s[$N] : (isset($s[$d]) ? $s[$d] : $d);
}

/* $_GET DEEP VERSION */
function gf($name, $otherwise = null){
    return gt_has($name) ? gt($name) : grt($name, $otherwise);
}
function gf_has($name) {
    return gt_has($name) || grt_has($name);
}
function gf_is($name, $val) {
    return gt_has($name) ? gt_is($name, $val) : grt_is($name, $val);
}
function gf_on($name) {
    //dx(gt_on($name), grt_on($name));
    return gt_has($name) ? gt_on($name) : grt_on($name);
}
function gfn($name){
    $args = func_get_args();
    return call_user_func_array(gt_has($name) ? 'gn' : 'grn', $args);
}
function gfv($name){
    $args = func_get_args();
    return call_user_func_array(gt_has($name) ? 'gv' : 'grv', $args);
}