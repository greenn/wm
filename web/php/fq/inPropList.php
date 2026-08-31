<?#0.3.2
/* id
	propList([id => 1, title => 2], 'p') //[p_id => 1, p_title => 2]
	eg iq/test/php/propList.php
	name
inPropList
inKeyProps
asPropsLine
asPropsName
propAsKeys
keysAsProp
keysInProp
propListArray
asPropList
*/
function inPropList($prefix, $data, $result = array()){
	if (is_array($data)) foreach ($data as $name => $value) {
		$prop = $prefix ? "{$prefix}_{$name}" : $name;
		$result = inPropList($prop, $value, $result);
	} else {
		//if (!$result) /*case: самые первые данные не дата*/ $result = $data; else
		$result[$prefix] = $data;
	}
	return $result;
}

function _addPropList(&$array, $prefix, $data) {
	$array = inPropList($prefix, $data, $array);
}