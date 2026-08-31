<?//1-20

function htmlAttr($content){

	if (!is_array($content)) {
		$content = array($content);
	}

	foreach ($content as &$line) {
		$line = htmlspecialchars($line);
	}

	$attrStr = join('&#013;', $line);

	return $attrStr;
}