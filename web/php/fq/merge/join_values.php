<?#0.1.4

//join только для значений
function join_values($glue, $data){
	$items = array();
	foreach ($data as $value) {
		if ($value) {
			if ($value === true) {
				$value = '';
			}
			if (is_array($value)) {
				$value = join_values($glue, $value);
			}
			$items []= $value;
		}
	}
	return join($glue, $items);
}