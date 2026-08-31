<?/*
	ddd


	что-то типо

	$attr = new Attrs();
	$attr->add_array()

	print $attr::string();

*/
$content = array();
//if ($name == 'surname') dx($name, $attr);
foreach ($attr as $name => $val) {
	if (is_stringable($val)) {
		$content []= "$name=\"".htmlspecialchars($val)."\"";
	} elseif (is_null($val)) {
		$content []= $name;
	}
}
if ($attrs) $content = array_merge($content, $attrs);