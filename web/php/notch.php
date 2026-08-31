<?#3.1.1
/*
	[md web/php/notch.struct]
	[eg
		web/test/web/php/notch/how.php +

		web/test/web/php/notch/1.php
		web/test/web/php/notch/2.php
		web/test/web/php/notch/start-end-out.php
	]
*/
_needphp('fq');
_needphp('formatSizeUnits', 'formatSec');

if (!isset($_SERVER["REQUEST_TIME_FLOAT"])) $_SERVER["REQUEST_TIME_FLOAT"] = microtime(true);

//получить временную засечку
function notch_time($getLast = false){
    static $last;
    return $getLast ? $last : $last = microtime(true);
    //один формат с $_SERVER["REQUEST_TIME_FLOAT"]
}

//результат временной разницы от предыдущей засечки
function notch($title = '', $prevTimer = false){
    static $prev = null;
    if ($prevTimer) $prev = $prevTimer;
    elseif (!$prev) $prev = $_SERVER["REQUEST_TIME_FLOAT"];
    
    $start = $prev;
    $prev = $now = notch_time();
    $res = $diff = ($now - $start) * 1000;
	$notch = round($diff, 2).'мс';
    if ($diff > 1000) {
        $diff /= 1000;
        $notch = round($diff, 3).'с';

	    if ($diff > 65) {
		    $notch = ($m = floor($diff/60)).'м';
		    $notch .= ' '.(round($diff - $m*60, 1)).'с';
	    }
    }

    
    if ($title && is_string($title)) {
    	$res = "$notch — $title";
    }
    
    return $res;
}

//разделитель вывода
function notch_sep($sep = false){
    static $types = array(0 => '', 1 => "\r\n", 2 => '<br />');
    static $value = '';
    
    if (is_numeric($sep) && isset($types[$sep])) $value = $types[$sep];
	else if ($sep) $value = $sep;
	
    return $value;
}
//ставим разделитель в значение (2): '<br />'
notch_sep(2);

/* 
	вывод засечки с разделителем
		_notch('прошло с начала');
		sleep(1);    
		_notch('прошла секунда');
*/
function _notch($title = '', $prevTimer = false, $sepType = false){
    echo $notch = notch($title, $prevTimer), notch_sep($sepType);
    return $notch;
}

/*  
	херндлер засечек по id

	[eg
		web/test/web/php/notch/1.php
		web/test/web/php/notch/2.php
	]
*/
function notch_($index = false, $title = '', $useOutput = null){
    $hasIndex = is_integer($index);

	static $stack = array();
    //#item = [time, title, notch] 
    
    //case: notch_(null)
    if (is_null($index)) return $stack;

    //step: ищем id по заголовку
	/*
		case: notch_('Заголовок')

	*/
    if (is_string($index)) {
        $found = false; //find {id} by title
        foreach ($stack as $index => $item) {
            if ($index === $item[1]) { //1 ~ title
                $found = $index;
                break;
            }
        }
	    //case: если не находим, значит это последняя засечка
        $index = ($found !== false) ? $found : true;
    }

	//case: если true, значит это последняя засечка
    if ($index === true) $index = count($stack) - 1; //case: last item


    //case: $useOutput не указан, тогда если без id, то не выводим
	//if (!$hasIndex) $useOutput = false;
    if (func_num_args() < 3) $useOutput = $hasIndex ? true : false;

    $prevTime = false;
    //d($index);
    if ($hasIndex && isset($stack[$index])) {
        $prevTime = $stack[$index][0];
        //case: notch_ (%id, true) / (%id)
	    //тайтл был указан при первой засечке
        if ($title === true || func_num_args() === 1) $title = $stack[$index][1];
    }

    //step: вычисляем засечку 
    $notch = call_user_func($useOutput ? '_notch' : 'notch', $title, $prevTime);
	//step: добавляем в стек
    $stack []= array(notch_time(true), $title, $notch);
	end($stack);
    //$newIndex = count($stack) - 1; //id of added timer
    $newIndex = key($stack);

    return $useOutput ? $newIndex : $notch;
}

/*
	функции для использования

	[eg
		web/test/web/php/notch/start-end-out.php
	]
*/
function notch_start($title = '', $useOutput = false){
    return notch_(false, $title, $useOutput);
}
function notch_end($id = true, $title = true, $useOutput = false){
    return notch_($id, $title, $useOutput);
}
function notch_out($id = true, $title = true){
    return notch_($id, $title, true);
}


function test_info($prop = null, $value = null){
    static $info = array();
    $q = func_num_args();
    if (!$q) return $info;
    if ($q === 1) return prop($info, $prop);
    if ($prop === null) $info = array(); //reset
    $info[$prop] = $value;
}

function test_start($title = false){
    test_info(null, null);
    if ($title) test_info('title', $title);
    test_info('id', notch_start());
    test_info('mem', memory_get_usage());
    test_info('mem-r', memory_get_usage(true));
}

function test_end(){
    $start = test_info();
    $tm = notch_end($start['id']);
    $m = memory_get_usage() - $start['mem'];
    $mr = memory_get_usage(true) - $start['mem-r'];

    $msg = '<br />'
        . (($title = prop($start, 'title')) ? "<b>$title</b><br />": '')
        ."время загрузки: ".formatSecDate($tm, true)."<br />"
        .'памяти выделено: '.formatSizeUnits($m, 0).' ('.formatSizeUnits($mr, '0').')'
    ;
    return $msg;
}


//если есть параметр notch, то выводит информация о загрузке система
function gt_notch_cssFile(){
	_needphp('gt');
	if (!gt_has('notch')) return '';
	return join(newline, array(
		'/*',
		x('notchWeb'),
		//x('notchSite'),
		notch('страница'),
		'*/'
	));
}