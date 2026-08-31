<?#2.1.1

//_needphp('urlToken');

//Добавление в url, query-параметров, с учётом замены/добавления и удаления
//ts: web/test/web/php/url_set.php
function url_set($url, $prmSet, $prmUnset = array()) {
	$info = parse_url($url);

	parse_str(isset($info['query']) ? $info['query'] : '', $urlPrm);

	if (!is_array($prmSet)) parse_str($prmSet, $prmSet);

	if ($prmUnset && !is_array($prmUnset)) $prmUnset = (array) $prmUnset;

	$prm = array_replace($urlPrm, $prmSet);

	if ($prmUnset) foreach ($prmUnset as $key) {
		if (array_key_exists($key, $prm)) {
			unset($prm[$key]);
		}
	}

	$resUrl = $info['path'].'?'.http_build_query($prm);

	return $resUrl;
}