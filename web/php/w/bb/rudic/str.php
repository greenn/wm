<?php
//v0.6.2
include (__.'str-c.php');

$abc = new o;
$abc->D  = '0123456789';
$abc->ru->{'='} = 'Эй,Жлоб!ГдеТуз?ПрячьЮныхСъёмщицВШкаф.';
$abc->ru->low = rustrtolower($abc->ru->{'='});
$abc->ru->up = rustrtoupper($abc->ru->{'='});
$abc->ru->full = $abc->ru->up.$abc->ru->low;
$abc->en->{'='} = 'SphinxOfBlackQuartzJudgeMyVow?!';
$abc->en->low = strtolower($abc->en->{'='});
$abc->en->up = strtoupper($abc->en->{'='});
$abc->en->full = $abc->en->up.$abc->en->low;
if (!globalvar('abc')) globalvar('abc', $abc);


/*
foreach (str2c($ename) as $pos=>$c)
|| foreach (str2c($ename) as $c)
*/
function str2c($str) {
    $res = array();
    for ($n = 0, $l = strlen($str); $n < $l; $n++) $res[$n] = $str[$n];
    return $res;
}


//value of varibale  transfer to string  'via conf;
//echo var2str($_REQUEST); exit;
//echo var2str(o('use','for', 'sep',hr), $_GET, $_COOKIE); exit;
function var2str($conf) { //0.1
    list($N, $A) = array(func_num_args(), func_get_args());
    if ($N==1) $conf = o('use','dump', 'sep',br);
    elseif (!is_o($conf)) $conf = o('set', $conf);
    $sep = ($conf->has('sep')&&($N>2))? $conf->sep : ''; //rn
    $content = '';
    foreach ($A as $n=>$arg) if (($N==1)||($n>0)) {
        ob_start();
        if ($conf->has('use')) switch ($conf->use) {
            case 'forr': forr($arg); break;
            case 'dump': var_dump($arg); break;
        } else echo $arg;
        $content .= ob_get_contents().$sep; //ob_get_clean
        ob_end_clean();
    }
    return $content;
}
//value of variable TO Digit String
function var2dstr($var) { //0.1e
    switch($type = gettype($var)) {
        case 'null': return '-';
        case 'boolean': return $var?'1':'0';
        case 'integer': return '2';
        case 'double': return $var==(integer)$var?'2':'3';
        case 'string': return is_numeric($var)?var2dstr(floatval($var)):'4';
        case 'array': return '5';
        case 'object': return '6';
        default: return '^'.$type.'^'; }
}

//Прроверка на то, что у строчки первая буква заглавная, а остальные прописные
//FirstLetter is upper?
function FL_upper($string) {
    $FL = $string[0];
    $string = substr($string, 1);
    return ctype_upper($FL) && ctype_lower($string);
}

#-
# Выводит строку в ожну строчку
# делалось для атрибута title
function in_line($string, $scr = false) {
    $str = str_replace(array("\r\n", "\r", "\n", "\t"), ' ', $string);
    if ((boolean)$scr) htmlspecialchars($str);
    return $str;


}

//Расскрывает двойные скобки если имена выглядят как parent[value] и возвращает в виде масива
function unbracket($data) { //0.3
    $res = new o;
    foreach ($data as $item=>$value) {
        if (preg_match_all('~([^[]+)[[]([^]]+)[]]~', $item, $name, PREG_SET_ORDER))
            $res->{$name[0][1]}->{$name[0][2]} = str2val($value);
        else $res->$item = $value;
    }
    return $res;
}

//переводит строку в другой тип, если получается
function str2val($str) { //0.2
    if (!is_string($str)) return $str;
    switch ($str) {
        case 'false': return false;
        case 'true': return true;
        case 'null': case 'undefined': return null;
        default: return $str;
    }
}

#v0.4
# переводит строку в допустимый атрибут ID
//Значением атрибута id является любое слово состоящее из букв латинского алфавита (a-z, A-Z), цифр (0-9), символов дефиса (-) и подчеркивания (_), но при этом оно не может начинаться с цифры или дефиса, после которого идет цифра.
/*
-   str2id('W☻&home&hanna&www&☺htaccess');
+   str2id('http://spravka.seodon.ru/html/obschie-atributy/id.php');
+   str2id('MIAMI BEACH, FL, 331396209,');
+   str2id('baba.gaga');
+   str2id('.~+&/\\http:/ ,=*#~[.\~\&\+\/\\]~/p~yha ,=~++++*#.ru/fis ,=*#hki/regexp/_______http:_ ,=*#_p_yha ,=_____*#_ru_fis ,=*#hki_regexp_');
*/
function str2id($str) {
    if ($str=='') return '__0';
    //$remove = '\'`":%^!?|(){}[]№$';//.'©☺☻';
    $change1 = ' ,=*#'; # , =*# 2 -
    $change2 = '.\\~\\&\\+\\/\\\\'; # .~+&/\ 2 -
    $id = rus2translit($str); #[0.3]
    $id = preg_replace('~['.$change1.']~', '_', $id);
    $id = preg_replace('~['.$change2.']~', '-', $id);
    if (is_numeric($id[0])) $id = '_'.$id;
    $id = preg_replace('~[^\w-\d]~', '', $id);
    //echo $str.br.$id.hr;
    return $id;
}


# 0.4.2
#[i] можно использовать ;
# Working for Ru(-) and Eng strings
# path2name('titul'); # titul
# cpath2name('contact/boss');# contact_boss
# path2name('catalog/cat-5/name_for_you#part-two'); # catalog_cat5_nameForYou__partTwo
# path2name('http://minutka.sight4.me/p8'); # p8
# path2name('8'); # _8
# path2name('{}{}'); # epmty_04da01f1
function path2name($path, $lang = 'en') {
    //if ($lang != 'ru' && preg_match('~[а-я]~i', $path)) return path2name($path, 'ru');
    $str = $lang=='en'? strtolower($path) : rustrtolower($path);
    $remove = '\\\'`"+:%^*&=,.!?|(){}[]#$~';//.'©☺☻';
    $rebuild = '_ -';
    $change = ';/';
    $pars = @parse_url($path);
    //fo($path, $pars); exit;
    if (isset($pars['path'])) $str = $pars['path'];
    while (strpos($str, '//') > 0) $str = str_replace('//', '/', $str);
    foreach (str2c($remove) as $c) if (is_int(strpos($str, $c))) $str = str_replace($c, '', $str);
    foreach (str2c($rebuild) as $c) while (is_int($p = strpos($str, $c))) {
        $bef = substr($str, 0, $p); $aft = substr($str, $p + 1);
        $aft[0] = $lang=='en'? strtoupper($aft[0]) : rustrtoupper($aft[0]);
        $str = $bef.$aft;
    }
    foreach (str2c($change) as $c) if (is_int(strpos($str, $c))) $str = str_replace($c, '_', $str);
    if (isset($pars['fragment'])) $str .= '__'.path2name($pars['fragment'], $lang);
    //if (strlen()strval())
    if (strlen($str) == 0) return 'epmty_'.hash('adler32', $path);
    if ($str[0] == '_') $str = substr($str, 1);
    if (is_numeric($str[0])) $str = '_'.$str;
    return $str;
}

# v0.1
# преобразует к примеру путь из Denwer'ского виртуально диска в win-path
//$denwer_path = 'W:/home/hanna/upd_bak/hanna/qcms/cp/tools/q.updater/qu.index.php';
//echo path2win($denwer_path, 'C:\SERVER7'); exit;
function path2win($path, $sub_path = false) {
    if (!$sub_path) $sub_path = server;
    $win_path = '';
    foreach (explode('/', $path) as $n=>$dir) {
        if ($n == 0 && $sub_path) $win_path = $sub_path;
        else $win_path .= '\\'.$dir;
    }
    return $win_path;
}


#v0.1
function name2str($data) {
    $str = str_replace('_', ' ', $data);
    return $str;
}

#0.1b
# проверяет состоит ли строчка только из букв алфавита
function is_abc($str, $lang = false, $abc = false) {
    if (strlen($str) == 0) return false; //пустая строка
    if (!$lang) $lang = detect_lang($str);
    if (!$abc) $abc = globalvar('abc')->$lang->full;
    else $abc = isset($abc->$lang)? $abc->$lang : $abc;
    if (strlen($str) == 1) return is_int(strpos($abc, $str));
    //else return falsecho('Нужно описать проверку всех букв в строке на причастность к алфавиту');
    foreach (str2c($str) as $c) if (!is_abc($c, $lang, $abc)) return false;
    return true;
}

//$fuck = 'u043fu043eu0441u043bu0435u0434u043du0438u0435 u043au043eu043bu043bu0435u043au0446u0438u0438';
//$fuck = preg_replace_callback('/u([0-9a-f]{4})/i', 'replace_unicode_escape_sequence', $fuck);
function replace_unicode_escape_sequence($match) {
    return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
}

##  USE IT:   http://www.php.net/manual/ru/ref.mbstring.php ##
# v0.2
# detecting ru, en
function detect_lang($str) {
    if (preg_match('~[а-я]~i', $str)) return 'ru';
    else return 'en';
}

function toupper($str){
    if (detect_lang($str) == 'ru') return rustrtoupper($str);
    else return strtoupper($str);
}
//strtolower for UTF string
function rustrtoupper($str, $ENC='UTF-8') {
    if (!$ENC) $ENC = detect_encoding($str);
    if (mb_strlen($str, $ENC)==0) return $str;
    return mb_convert_case($str,MB_CASE_UPPER,$ENC);
}

/*0.2*///strtolower for UTF string
function rustrtolower($str, $ENC='UTF-8') {
    if (!$ENC) $ENC = detect_encoding($str);
    if (mb_strlen($str, $ENC)==0) return $str;
    return mb_convert_case($str,MB_CASE_LOWER,$ENC);
}
function tolower($str){
    if (detect_lang($str) == 'ru') return rustrtolower($str);
    else return strtolower($str);
}

//ucwords for UTF string
function rustrtocap($str, $ENC='UTF-8') {
    if (!$ENC) $ENC = detect_encoding($str);
    if (mb_strlen($str, $ENC)==0) return $str;
    return mb_convert_case($str,MB_CASE_TITLE,$ENC);
}
function tocap($str){
    if (detect_lang($str) == 'ru') return rustrtocap($str);
    else return ucwords($str);
}

//ucwords for first word in UTF string
function rustrtofcap($str, $ENC='UTF-8') {
    if (!$ENC) $ENC = detect_encoding($str);
    $strlen = mb_strlen($str, $ENC);
    if ($strlen == 0) return $str;
    $FC = mb_substr($str,0,1,$ENC);
    return mb_convert_case($FC,MB_CASE_UPPER,$ENC).mb_substr($str,1,$strlen,$ENC);
}
function tofcap($str){
    if (detect_lang($str) == 'ru') return rustrtofcap($str);
    else return ucfirst($str);
}


//v0.3
//сконвертировать путь - для передачи его через URL
function url_path($path) {
    $path = str_replace('.', '☺', $path);
    $path = str_replace(':', '☻', $path);
    $path = str_replace('\\', '&&', $path);
    $path = str_replace('/', '&', $path);

    return $path;
}
//v0.3
//расконвертировать путь - при приёме его через URL
function url_repath($path) {
    $path = str_replace('☻', ':', $path);
    $path = str_replace('☺', '.', $path);
    $path = str_replace('&&', '\\', $path);
    $path = str_replace('&', '/', $path);
    return $path;
}

//Первая часть от строки при strstr, aka в PHP 5.3.0 strstr($str, $search, true);
//dump(reset(explode(l, $str))); //0.05мс
//dump(substr($str, 0, strpos($str, l))); //0.04мс
function rstrstr($str, $search){ return substr($str, 0, strpos($str, $search)); }

//Получить FileSize для строки
#http://stackoverflow.com/questions/3511106/filesize-from-a-string#answer-3511239
function stringsize($content) { //0.1
    if (function_exists('mb_strlen')) $size = mb_strlen($content, '8bit');
    else $size = strlen($content);
    return $size;
}


#0.1.1
//обработка только текста (обходя тэги) в HTML-данных $data функцией $func с аргументами $args,
// где первым аргументом подаётся сам текст
function just4text($data, $func, $args=array()) {
    if (!is_callable($func)) return $data;
    $res = '';
    preg_match_all('~<([\w]+)([^>]+)>([^<]+)</\1>~um', $data, $html, PREG_PATTERN_ORDER);
    if($html) foreach ($html[3] as $n=>$text) {
        $tag = $html[1][$n];
        $attrs = $html[2][$n];
        $res .= '<'.$tag.$attrs.'>'.
            call_user_func_array($func, array_merge((array)$text, (array)$args))
            .'</'.$tag.'>';
    }
    return $res;
}


#0.1 Переименовывает Английские названия месяцев в Русские
//ru_month(date_format($date, "j F Y"))
function ru_month($str) {
    return str_replace(
        array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
        array('Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря'),
        $str
    );
}
#001 Переименовывает Английские названия дней в Русские
//
function ru_day($str) {
    return str_replace(
        array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'),
        array('Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресение'),
        $str
    );
}



function s_s() {
    $str = '';
    foreach (func_get_args() as $arg) $str .= val($arg);
    return $str;
}