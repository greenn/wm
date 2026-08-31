<?
//2
// плохая функция, которая пытается подгрузить всё подряд
// очень плохая ) и может не рабочая

function need(/* $webName1, ..., $webNameN */){

	if (func_num_args() > 0) {
		$webNames = func_get_args();
		foreach ($webNames as $webName) {
			if (phpinc($webName)) {}
			elseif (lib($webName)) {}
			elseif (addphp($webName)) {}
		}
	}

}



/*


*/