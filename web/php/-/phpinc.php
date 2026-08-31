<?
//D isit works ??) $incName.'.php'


//0.3
/*

*/

if (!isset($GLOBALS['_webincIncluded'])) {
	$GLOBALS['__webincIncluded'] = array();
}


function phpinc($incName, $incArguments = 0){
	$operationResult = 0;


	if (is_string($incName)) {

		$phpIncludePath = WEB.'/inc/'.$incName.'.php';

		if (is_file($phpIncludePath)) {
			if (is_array($incArguments)){
				extract($incArguments);
			}

			include ($phpIncludePath);

			if (!isset($GLOBALS['__webincIncluded'][$incName])) {
				$GLOBALS['__webincIncluded'][$incName] = 0;
			}

			$operationResult = ++$GLOBALS['__webincIncluded'][$incName];
		}


	}

	return $operationResult;
}



/*

$GLOBALS['_phpIncludedPath'] = WEB.'/inc/'.$incName.'.php';
extract($incArguments);
include ($GLOBALS['_phpIncludedPath']);
$GLOBALS['_phpIncludedPath'] = '';


*/