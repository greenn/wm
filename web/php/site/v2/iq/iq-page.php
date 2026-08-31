<?#3.5.0

//ak свободный резрев
//function _page(){}

function _pageData($pid, ...$prop){
	//[ii и для site]
	return pro_page($pid, 'prop', ...$prop);
	//php/site/v2/site_page.class.php:24
}

//вызова метода у текущей страницы
function cur_page(...$args){
	//[ii и для site]
	return pro_page(true, ...$args);
}

function pro_page($pid, ...$args) {
	//$pagesClass = pro_opt('env', 'pages');
	$callArgs = func_get_args();
	//dx($pid, $callArgs);
	return _pagePro_($callArgs, true);
}

function _pagePro($proSid, ...$callArgs) {
	return _pagePro_($callArgs, $proSid, false);
}


function _pageFor($pagesClass, ...$callArgs) {
	return _pagePro_($callArgs, $pagesClass, true);
}

function _pageDataFor($pagesClass, ...$callArgs) {
	array_splice($callArgs, 1, 0, 'prop');
	return _pagePro_($callArgs, $pagesClass, true);
}

//опертор вызовов инстанса-страницы, полученной от менеджера страниц указанного проекта
function _pagePro_($callArgs, $proSid = true, $proSidIsPagesClasses = false) {
	if ($proSidIsPagesClasses) {
		$pagesClass = $proSid;
	} else {
		$pagesClass = _proOptEnv($proSid, 'pages');
	}

	$pid = $callArgs[0];

	//dx($pagesClass, $pid, $callArgs, array_slice($callArgs, 1));
	$Page = $pagesClass::get($pid);
	if(0) _pages::get($pid);


	if ($Page) {
		if (count($callArgs) === 1) {
			return $Page;
		} else {
			$methodName = $callArgs[1];
			$method = array($Page, $methodName);
			if (is_callable($method)) {
				$methodArgs = array_slice($callArgs, 2);
				//dx($method, $methodArgs);
				return call_user_func_array($method, $methodArgs);
			}
		}
	}
	return null;
}