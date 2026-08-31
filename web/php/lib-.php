<?
//3.2
// 0 - не может быть добавлена
// 1 - уже добавлена
// 2 - добавлена первый раз
$GLOBALS['_libConnectors'] = array();

function lib($libName){

	$operationResult = 0;

	$libIncluded = isset($GLOBALS['_libConnectors'][$libName]);

	if (!$libIncluded) {

		$libDir = LIB.'/'.$libName;

		if (is_dir($libDir)) {

			$connectorPath = $libDir.'/'.$libName.'.php';

			if (is_file($connectorPath)) {

				include_once($connectorPath);

				$GLOBALS['_libConnectors'][$libName] = $connectorPath;

				$operationResult = 2;

			}
			
		}
	} else {
		$operationResult = 1;
	}

	return $operationResult;
}

//echo '<plaintext>', var_dump($GLOBALS['_libConnectors']), exit;


//libs