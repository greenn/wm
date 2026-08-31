<?#0.2.1

_needphp('set');


function dirToArray_set($set, $depth = false) {
	$set = set(array(
		'path' => null,
		'depth' => -1,
		'keepDots' => true,
		'decodeName' => false,
		'decodePath' => false,

		//'encoding_method' => 'iconv',
		//'encoding' => 'Windows-1251',
		/*для этого понадобится наверное dirToArray{}
			также будет возможно внесение доп. настроек
			filter и прочее
				для пропуская каких-нибудь файлоы, типа 'desktop.ini'
		*/

	), $set);
	if (is_integer($depth)) $set->depth = $depth;

	$listPath = array();

	$pathDir = realpath($set->path);

	if (is_dir($pathDir)) {

		$listNames = scandir($pathDir);

		foreach ($listNames as $index => $name) {
			#- $name = iconv('UTF-8', 'UTF-8//IGNORE', utf8_encode($name));
			#- $name = mb_convert_encoding($name, "UTF-8", "auto");
			#~ $name = utf8_encode($name);
			#+ $name = iconv("Windows-1251", "UTF-8", $name);

			$saveName = $name;
			if ($set->decodeName) {
				$saveName = iconv("Windows-1251", "UTF-8", $name);
			}

			if ($selfDirectory = $name == '.') {
				if ($set->keepDots) $listPath[$saveName] = $pathDir . DIRECTORY_SEPARATOR;
			} elseif ($parentDirectory = $name == '..') {
				if ($set->keepDots) $listPath[$saveName] = dirname($pathDir) . DIRECTORY_SEPARATOR;
			} else {
				$path = $pathDir . DIRECTORY_SEPARATOR . $name;

				if (is_dir($path)) {
					if ($set->depth)
						$listPath[$saveName] = dirToArray_set($set, --$set->depth);
					else
						//$listPath[$name . DIRECTORY_SEPARATOR] = $path;
						$listPath[$saveName] = $path . DIRECTORY_SEPARATOR;
				} else {
					$listPath[$saveName] = $path;
				}

				//dx($set->decodePath);
				if ($set->decodePath && is_string($listPath[$saveName])) {
					$listPath[$saveName] = iconv("Windows-1251", "UTF-8", $listPath[$saveName]);
				}
			}

		}

	}

	return $listPath;
}