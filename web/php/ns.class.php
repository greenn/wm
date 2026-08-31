<?#3.3.2
/*
	man
		._/man/php/ns.class

	eg
		$isLast = nso::is_ol($index, count($list)); {b}
        $ons = nso('ol', $index, count($list)); //{s}

		каждый третий
			nso('o3', $index)

		dx(nso(array('od', 'o2'), 0, 2), nso('o2', 1, 2));
		
	nso($, $index, $total)

	o{$y}n{$xP} - o4n5
	o{$y}p{$xP} - o4p
	o{$y}l{$xP} - o3l3
		o3le - (even) чётные проходы
		o3lo - (odd) нечётные проходы		
		o4l2 - второй проход по 4 элемента (idx: 4,5,6,7 / n: 5,6,7,8)
		o2lf - первый проход по 2 элемента
		o2ll - последдний проход по 2 элемента (нужен $lastIndex)
*/


function nso($nc, $index, $total = 0){
	if (!is_array($nc)) $nc = array($nc);
	$res = ns::s($nc, $index, $total);
	return ns::join($res);
}

class ns {


	static function nc($nc){
		if ($nc) $nc = "-$nc";
		return $nc;
	}

	static function s($ncs/*, $index, $total = 0*/){
		$args_ = array_slice(func_get_args(), 1);
		$list = array();
		foreach ($ncs as $nc) {
			$res = call_user_func_array("ns::$nc", $args_);
			if ($res) $list []= $res;
		}
		return $list;
	}

	//соединяет пробелами значения, если они есть
	//в отличии от простого join, не будет оставлять дополнительные пробелы
	static function join($glue, $array = array()){
		if (func_num_args() === 1) {
			$array = func_get_arg(0);
			$glue = ' ';
		}
		$list = array();
		foreach ($array as $value) {
			if ($value) {
				//$list []= is_array($value) ? static::join($glue, $value) : $value;
				if (is_array($value)) {
					$list []= static::join($glue, $value);
				} else {
					$list []= $value;
				}
			}
		}
		//d($list);
		return join($glue, $list);
	}

	//проверка на последний элемент
	static function ol($index, $total){
		$lastIndex = $total - 1;
		$isLast = $index === $lastIndex;
		return$isLast ? static::nc('ol') : '';
	}

	//проверка на чётность
	static function od($index){
		$isOdd = $index % 2 === 0;
		return $isOdd ? static::nc('od') : '';
	}
	
	static function __callStatic($nc, $args_) {
		array_unshift($args_, $nc);
		return call_user_func_array("static::on", $args_);
	}
	
	//получение класса для именного порядка 
	static function on($nc, $index, $total = 0){
		$res = '';
		if (preg_match('~^o([\d]+)$~', $nc, $match)) {
			# case: n-ый элемент
			//d('N', $index, $nc, $match[1], ($index + 1) % $match[1] === 0);
			if (($index + 1) % $match[1] === 0) $res = $nc;
		} elseif (preg_match('~^o([\d]+)n([\d]*)$~', $nc, $match)) {
			# case: следующий %x после n-ого элемент
			//$xN = floatval($match[2] ? $match[2] : 1); //рабочий, но если $xN > $y работать не будет
			$y = $match[1];
			$xN = fmod($match[2] ? $match[2] : 1, $y);
			//d("o{$y}n{$xN}", $index + 1, $y, fmod($index + 1, $y), $xN);
			if (fmod($index + 1, $y) === $xN) $res = $nc; //"o{$y}n{$xP}"
		} elseif (preg_match('~^o([\d]+)p([\d]*)$~', $nc, $match)) {
			# case: предыдущий %x перед n-ым элемент
			$y = $match[1];
			$xP = fmod($match[2] ? $match[2] : 1, $y);
			//d(($index + 1)."($index) {$y}n{$xP}", $y, $xP, $y - $xP, '=', fmod($index + 1, $y));
			if (fmod($index + 1, $y) === fmod($y - $xP, $y)) $res = $nc; //"o{$y}p{$xP}"
			/*
				q-aaa
					но это = fmod для превращение в случаи o4p4 ~ 4 в 0
			*/
		} elseif (preg_match('~^o([\d]+)l(.+)$~', $nc, $match)) {
			$lastKey = $total - 1;
			# case: предыдущие элементы перед переходом ak line
			/*
				-o4l2 - второй проход по 4 элемента (idx: 4,5,6,7 / n: 5,6,7,8)
				-o2lf - первый проход по 2 элемента
				-o2ll - последдний проход по 2 элемента (нужен $lastIndex)
				-o3le - (even) чётные проходы
				-o3lo - (odd) нечётные проходы
			*/
			$n = $match[1]; //модуль - кол-во элементов в проходе
			$l = $match[2]; //номер строки (прохода)
			$isEven = ($l === 'e');
			$isOdd = ($l === 'o');
			if ($l === 'f') $l = 1;
			if ($l === 'l' && !is_null($lastKey)) $l = ceil($lastKey / $n);
			$l = (float) $l - 1;
			$L = floor($index / $n);
			//d('L', $index, $n, $l, $index/$n, floor($index/$n));
			$ok = $L === $l;
			if ($isEven || $isOdd) {
				$ok = $isEven ? ($L % 2 == 0) : ($L % 2 != 0);
			}
			if ($ok) $res = $nc;

		} else {
			d('unknown-name', $nc, func_get_args());
		}

		return static::nc($res);
	}
}