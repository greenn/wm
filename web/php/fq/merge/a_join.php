<?#0.2.0

//[tg] [tg для html-attr]
function a_join($key_glue, $data, $items_glue = PHP_EOL, $lastItemGlue = ''){
	$items = array();
	if (is_array($data)) foreach ($data as $key => $value) {
		$items []= $key.$key_glue.$value;
	}
	if ($lastItemGlue === true) $lastItemGlue = $items_glue;
	return join($items_glue, $items).$lastItemGlue;
}