<?#5.0

_needphp('rootLess');
_needphp('php');
_needphp('getCaller');

//akin fileUrl
//null - оставить как есть, без изменений
function dirUrl($path = false, $leadingSlash = true, $trailingSlash = null){
	if (!$path) {
		$path = getCaller('dir');
	}

	if (is_file($path)) {
		$path = dirname($path);
	}

	$resPath = str_replace('\\', '/', rootLess($path));

	if (!is_null($leadingSlash)) $resPath = ltrim($resPath, '/');
	if ($leadingSlash === true) $resPath = '/'.$resPath;

	if (!is_null($trailingSlash)) $resPath = rtrim($resPath, '/');
	if ($trailingSlash === true) $resPath = $resPath.'/';

	return $resPath;
}

//[l 4-21]
function dirUrl_($path = false, $toTrim = true){
	//как бы заменить $toTrim на false \=~= 5.0

	if (!$path) {
        $path = php('getCaller', 'dir');
    }

	if (is_file($path)) {
        $path = dirname($path);
    }


	$resPath = str_replace('\\', '/', rootLess($path));

	return $toTrim ? ltrim($resPath, '/') : $resPath;
}


/*

todo:

	параметры
		по
			0 добавлению к
			0 замене
				предыдущей директории на указанную  --брр
			0 дополнительного вычитания
				1 с конца
					1 дополнительно убрать из директории последнюю часть
					dirUrl(-1);
					0 убрать последнюю часть с названием config
				0 с начала


*/
