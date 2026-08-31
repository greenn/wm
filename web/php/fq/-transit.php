<?#0.2


_addphp('fq/_props'); //has_prop

//[ak transitCtx]
/*  Добавление в $base транзитных данных (свойство из $data)
	(c вариациями)
		отсутствия свойства, где $data уже транзитные данные
	[eg] web/test/web/php/fq/transit.php
*/
function transit($data = array(), $prop = false, $base = null/*[ff $base(2|N)]*/){
	$res = array();

	if (is_stringable($prop)) {
		$data = prop($data, $prop); //получение транзитных данных
	} elseif (func_num_args() == 2) {
		$base = $prop; //переназначение аргументов - arg3 встаёт вместо arg2
	}

	if (is_array($base)) {
		$res = $base;
	}


	//return merge($res, $data);

	if (is_array($data)) {
		$res = empty($res) ? $data : array_merge($res, $data);
	}
	return $res;
}


//транзит с пилюлькой
function transit_($transitProp, $data, $prop = false, $base = null){
	$defTransitProp = 'transit';
	if (is_array($transitProp)) {
		//case: transit_($data, $prop, $base) - сдвиг аргументов влево на один
		$base = $prop;
		$prop = $data;
		$data = $transitProp;
		$data = prop($data, $defTransitProp);
	} else {
		if ($transitProp === true) $transitProp = $defTransitProp;
		$data = prop($data, $transitProp);
	}
	return transit($data, $prop, $base);
}
function _transit($data, $prop = false, $base = null){
	$transitData = prop($data, 'transit');
	return transit($transitData, $prop, $base);
}



//[id]
function data_ctx_transit($ctx, $prop, $base){
	$res = is_array($base) ? $base : array();
	if ($data = prop($ctx, 'transit')) {
		if (is_stringable($prop)) {
			$data = prop($data, $prop); //получение транзитных данных
			if (is_array($data)) {
				$res = array_replace($res, $data);
			}
		}
	}
	return $res;
}


