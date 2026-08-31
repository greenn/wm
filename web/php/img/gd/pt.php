<?
//dd рисуем трегольник
function gi_pt($sizes, $hexColor, $format = 'gif'){

	if (!is_array($sizes)) $sizes = array($sizes, ceil($sizes / 2));
	$baseSize = $sizes[0];
	if (!is_array($baseSize)) $baseSize = array($baseSize, $baseSize);
	$baseW = $baseSize[0];
	$baseH = $baseSize[1];

	$img = imagecreatetruecolor($baseW, $baseH);
	imagesavealpha($img, true);
	$transparent = i_color($img, 'transparent');
	imageFill($img, 0, 0, $transparent);

	$color = i_color($img, $hexColor);

	// Рисуем бублик
	// Внешний круг
	imagefilledarc($img, 100, 100, 200, 150, 0, 350, $color, IMG_ARC_PIE);
	// Внутренний "круг" на самом деле не рисуется, чтобы создать эффект прозрачной дырки

	return i_res($img, $format);
}

function gdi_pt($size, $hexColor, $format = 'gif'){
	$img = gi_rd($size, $hexColor, $format);
	return di_encode($img, $format);
}