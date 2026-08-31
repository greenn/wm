<?

/*
gi_r_size(50, 2) - array(50, 25)
gi_r_size(50, 3) - array(50, 50 / 3 * 2, 50 / 3 * 1
*/
function gi_r_size($size, $prm){
	$result = [$size];
	for ($i = 1; $i < $prm; $i++) {
		$result[] = $size / $prm * ($prm - $i);
	}
	return $result;
}

function gi_r($sizes, $hexColor, $format = 'gif'){
	$hexColor = (array) $hexColor;
	$n_color = count($hexColor);
	if (!is_array($sizes)) $sizes = gi_r_size($sizes, $n_color);
	$baseSize = $sizes[0];
	if (!is_array($baseSize)) $baseSize = array($baseSize, $baseSize);
	$baseW = $baseSize[0];
	$baseH = $baseSize[1];

	$img = imagecreatetruecolor($baseW, $baseH);
	imagesavealpha($img, true);
	$transparent = i_color($img, 'transparent');
	imageFill($img, 0, 0, $transparent);

	foreach ($hexColor as $index => $hex) {
		$size = $sizes[$index];
		if (!is_array($size)) $size = array($size, $size);
		$color = i_color($img, $hex);
		imagefilledellipse($img,
			floor($baseW / 2), floor($baseH / 2),
			$size[0], $size[1], //($ovalWidth, $ovalHeight)
			$color
		);
	}

	return i_res($img, $format);
}

function gdi_r($size, $hexColor, $format = 'gif'){
	$img = gi_r($size, $hexColor, $format);
	return di_encode($img, $format);
}