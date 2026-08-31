<?#0.1

class rw_nso {



	/*  names-of-order-classes
	    ts:
			web/test/web/php/rp/ns_o.php
			web/test/help/mod.php?1&2&3&4&5
		eg:
			$Self::ns_o($index, 3);
			$Self::ns_o($index, 3, '-o3n');
			$Self::ns_o(array($index, null, $lastKey), '-od', '-o2', '-o3');
			$Self::ns_o(array($key, $firstKey, $lastKey, $index), 4)
			$Self::ns_o(array($key, null, null, $index), '-o4n')

			$o_ns = $Self::ns_o(array($index, $firstIndex, $lastIndex), 2);
		    $o_ns2 = $Self::ns_o(array($index, $firstIndex, $lastIndex), array('-od', '-o2'));
		    $o_ns3 = $Self::ns_o($index, array('-od', '-o2'));
		    $o_ns4 = $Self::ns_o($index, 2);
	*/
	static function ns_o($indexData, $names = array('-od', '-o2')/*, $addName*/){
		$args = func_get_args(); //dx($args);

		$res = array();

		$names = array();

		$namesData = array_slice($args, 1);
		foreach ($namesData as $nameData) {
			if (is_string($nameData)) {
				$names []= $nameData;
			} else if (is_integer($nameData)) { //|oE|o2| / |oE3|o3| /
				for ($i = 2; $i <= $nameData; $i++) $names []= "-o$i";
			} else if (is_array($nameData)) {
				$names = array_merge($names, $nameData);
			}

		}

		$index = $indexData;
		$key = $index;
		$firstKey = null;
		$lastKey = null;
		if (is_array($indexData)) {
			if (isset($indexData[0])) {
				$index = $indexData[0];
				$key = $index;
			}
			if (isset($indexData[1])) { //case: null проигнорируется
				$firstKey = $indexData[1];
				$names []= '-of'; // first |oF|of|
			}
			if (isset($indexData[2])) {
				$lastKey = $indexData[2];
				$names []= '-ol';
			}
			if (isset($indexData[3])) { //case: при {aa}, 4-ым аргументом передаём $index инкременируемый снаружи вручную
				$index = $indexData[3];
			}
		}
		//case: is_set($indexData)

		$names = array_unique($names);

		//d($names, array($index, $firstKey, $lastKey));
		foreach ($names as $nc) {
			switch ($nc) {
				case '-of': //case: первый элемент |oF|of|
					if ($key === $firstKey) $res []= $nc; break;
				case '-ol': //case: последний элемент |oL|ol|
					if ($key === $lastKey) $res []= $nc; break;
				case '-od': //case: нечётный (odd) элемент |oO|od|
					if ($index % 2 === 0) $res []= $nc; break;
				default: { //
					if (preg_match('~^-o([\d]+)$~', $nc, $match)) {
						# case: n-ый элемент
						//d('N', $index, $nc, $match[1], ($index + 1) % $match[1] === 0);
						if (($index + 1) % $match[1] === 0) $res []= $nc;
					} elseif (preg_match('~^-o([\d]+)n([\d]*)$~', $nc, $match)) {
						# case: следующий %x после n-ого элемент
						//$xN = floatval($match[2] ? $match[2] : 1); //рабочий, но если $xN > $y работать не будет
						$y = $match[1];
						$xN = fmod($match[2] ? $match[2] : 1, $y);
						//d("o{$y}n{$xN}", $index + 1, $y, fmod($index + 1, $y), $xN);
						if (fmod($index + 1, $y) === $xN) $res []= $nc; //"-o{$y}n{$xP}"
					} elseif (preg_match('~^-o([\d]+)p([\d]*)$~', $nc, $match)) {
						# case: предыдущий %x перед n-ым элемент
						$y = $match[1];
						$xP = fmod($match[2] ? $match[2] : 1, $y);
						//d(($index + 1)."($index) {$y}n{$xP}", $y, $xP, $y - $xP, '=', fmod($index + 1, $y));
						if (fmod($index + 1, $y) === fmod($y - $xP, $y)) $res []= $nc; //"-o{$y}p{$xP}"
						/*
							q-aaa
								но это = fmod для превращение в случаи o4p4 ~ 4 в 0
						*/
					} elseif (preg_match('~^-o([\d]+)l(.+)$~', $nc, $match)) {
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
						if ($ok) $res []= $nc;

					} else {
						d('unknown-name', $nc, $indexData);
					}
				}
			}
		}

		return $res;

	}

	// [n] -od === -o2p1
	static function nc_o($indexData, $names = array('-od', '-o2')/*, $addName*/){
		$args = func_get_args();
		$ns = call_user_func_array('static::ns_o', $args);
		return join(space, $ns);
	}
	
}