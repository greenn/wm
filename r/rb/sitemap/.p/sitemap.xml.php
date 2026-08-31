<?#6.0
include_once $_SERVER['DOCUMENT_ROOT'].'/site/iq.inc';
needphp('isAssoc');



/*
	<loc> - %key
	<lastmod> - timestamp | < pagePath / structPath | time()
	<priority> - priority | 0.1
	<changefreq> - changefreq | daily
*/


$pages = array();

//step: собираем данные для sitemap
$pagesData = site_data('system/pages');
$sysTypes = array('error', 'http-error', 'uc');
foreach ($pagesData as $pageName => $pageConf) {
	//dx($pageName, $pageConf);
	$isCmsPage = strpos($pageName, 'cms/') === 0 || $pageName === 'cms';
	$isSysPage = in_array($pageConf['pageType'], $sysTypes);
	$smConf = isset($pageConf['sitemap']) ? $pageConf['sitemap'] : null;
	$isOff = $smConf === false;
	//if ($isOff) d($pageName, $pageConf);
	//if ($isOff) print $pageName.'<br />';
	//$isContent = !$isCmsPage && !$isSysPage && !$isOff;
	$isContent = $pageConf['pageType'] === 'content';

	if ($isContent && !$isOff && !$isCmsPage) {
		if (!is_array($smConf)) $smConf = array();

		//dx($pageConf);

		$uri = $pageConf['canonical'];
		$pages[$uri] = array(
			'priority' => 0.5, //по умолчанию
			'changefreq' => prop($smConf, 'changefreq', 'weekly'),
			'timestamp' => time(),
		);

		if (isset($smConf['modData'])) {
			if (isOrdinal($smConf['modData'])) {
				$modData = $smConf['modData'];
				//ak call_rp_($modData)
				$Mod = site_rp($modData[0]);
				$modPages = call_user_func_array(array($Mod, $modData[1]), prop($modData, 2, array()));
				if (isAssoc($modPages)) {
					$pages += $modPages;
					//dx($pages);
				}

			}
		}

		//print '<b>'.$uri.'</b><br />';
	}
}

//exit;
//dx($pages);









foreach ($pages as $pagePath => $set) {
    $conf = array();
    if (!is_array($set)) {
        if (!$set) continue;
    } else if (!isAssoc($set)) {
    	//case: $set is {ao}
        $rule = array('priority', 'changefreq', 'lastmod');
        $maxIndex = count($rule) - 1;
        foreach ($set as $index => $value) {
            if ($index <= $maxIndex)
                $conf[$rule[$index]] = $value;
        }
    } else $conf = $set;


    $props = array();


}

$xml []= '</urlset>';

