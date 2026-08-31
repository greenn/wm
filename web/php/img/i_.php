<?#1.11.0
/*
    про картинки

    gi = genImage

    gdi = genDataImage
        "data:image/png;base64,$base64"

    eg:
        web/test/web/php/img/dash.php
        web/test/web/css/pcss/un1px.php
*/

function i_color($img, $hex){
    if ($hex == 'transparent') {
        $c = imagecolorallocatealpha($img, 0, 0, 0, 127);
    } else {
	    $opacity = false;
    	if (is_array($hex)) {
		    list($hex, $opacity) = $hex;
	    }

        if ($isShortHEX = preg_match('~^#?[\w]{3}$~', $hex)) {
            $hex = preg_replace('~([\w]{1})~', '$1$1', $hex);
        };
        preg_match_all('~([\w]{2})~', $hex, $hexMatches);
        list($R, $G, $B) = array_map('hexdec', $hexMatches[1]);

		//dx($hex, $opacity, is_numeric($opacity));
        if (is_numeric($opacity)) {
        	$alpha = ceil(127 * (1 - $opacity));
	        $c = imagecolorallocatealpha($img, $R, $G, $B, $alpha);
        } else {
	        $c = imagecolorallocate($img, $R, $G, $B);
        }

        //d($R, $G, $B, @$alpha, @$opacity);
    }
    return $c;
}

function i_res($img, $format) {
    if (is_array($format)) $format = join('.', $format);

    switch ($format) {
        case 'png': {
            ob_start();
            imagepng($img);
            $res = ob_get_contents(); //ob_get_clean
            ob_end_clean();
            return $res;
        } break;

        case 'gif': {
            ob_start();
            imagegif($img);
            $res = ob_get_contents(); //ob_get_clean
            ob_end_clean();
            return $res;
        } break;

        default: {
            if (is_string($format) &&
                ($ext = pathinfo($format, PATHINFO_EXTENSION))
            ) {
                 switch ($ext) {
                     case 'png': return imagepng($img, $format);
                     case 'gif': return imagegif($img, $format);
                 }
            }
        }
    }
    return '';
}

//gi_px - generate pixel image
//oo web/test/php/img/gi_px.php
//не-очень-универсальная надстройка для v-писеля разных цветов
function gi_px($size, $hexColor, $format = 'gif'){
	$hexColor = (array) $hexColor;
	$n_color = count($hexColor);
	if (!is_array($size)) $size = array($size, $size);
	$w = $size[0];
	$h = $size[1];
	//dx($w, $h, $n_color, $hexColor);
	$img = imagecreatetruecolor($w, $h * $n_color);
	imagesavealpha($img, true);
	$color = i_color($img, 'transparent');
	imageFill($img, 0, 0, $color);

	$y_prev = 0;
	foreach ($hexColor as $hex) {
		$color = i_color($img, $hex);
		$y_new = $y_prev + $h;
		imagefilledrectangle($img,
			0, $y_prev,
			$w, $y_new,
			$color
		);
		//d("(0, $y_prev); ($w, $y_new)");
		$y_prev = $y_new;
	}

	return i_res($img, $format);
}

function gi_px_v2($size, $hexColor, $format = 'gif'){
	$hexColor = (array) $hexColor;
	$n_color = count($hexColor);
	$w = $size;
	$h = $size * $n_color;
	$img = imageCreateTrueColor($w, $h);
	$color = i_color($img, $hexColor[0]); //    d("$w x $h", $hexColor[0]);
	imageFill($img, 0, 0, $color);

	//не-универсальная надстройка для v-писеля разных цветов
	if ($n_color > 1) {
		$y_prev = $size;
		for ($i = 1; $i < $n_color; $i++) {
			$color = i_color($img, $hexColor[$i]);
			$y_new = $y_prev + $size;
			//dx($hexColor[$i], $y_new);
			imagefilledrectangle($img,
				0, $y_prev,
				$w, $y_new,
				$color
			);
			$y_prev = $y_new;
		}
	}

	return i_res($img, $format);
}

function gi_px_v1($size, $hexColor, $format = 'gif'){
	$img = imageCreateTrueColor($size, $size);
	$color = i_color($img, $hexColor);
	imageFill($img, 0, 0, $color);
	$color2 = i_color($img, '#3251a1');
	imageFill($img, 5, 5, $color2);
	return i_res($img, $format);
}
//data-encoded image
function gdi_px($size, $hexColor, $format = 'gif'){
	$img = gi_px($size, $hexColor, $format);
	return di_encode($img, $format);
}

function gi_1px($hexColor, $format = 'gif'){
    return gi_px(1, $hexColor, $format);
}

function gdi_1px($bgColor, $format = 'gif'){
    return gdi_px(1, $bgColor, $format);
}


function gi_dash($set, $format = 'png', $dbg = 0){
    $format = prop_filter(array('png', 'gif'), $format);

    if (is_string($set)) $set = array('hexDashColor' => $set);
    $set = array_replace(array(
        'hexDashColor' => '#000',
        'hexBgColor' => 'transparent',
        'dash_width' => 2,
        'dash_space' => 2,
        'dash_start' => 0, //un
        'height' => 1,
    ), $set);

    if ($dbg) dx($set);

    $img_w = x('gi_dash_w', $set['dash_width'] + $set['dash_space']);
    $img = imageCreateTrueColor($img_w, $set['height']);
    imagesavealpha($img, true);

    $bgColor = i_color($img, $set['hexBgColor'], $dbg);
    imagefill($img, 0, 0, $bgColor);

    $dashColor = i_color($img, $set['hexDashColor'], $dbg);
    imagefilledrectangle($img,
        $set['dash_start'], 0,
        $set['dash_start'] + $set['dash_width'] - 1, $set['height'] - 1,
        $dashColor
    );

    //d($set, $img_w);

    return i_res($img, $format);
}

function gdi_dash($set, $format = 'png', $dbg = 0){
    $img = gi_dash($set, $format, $dbg);
    return di_encode($img, $format);
}

function di_encode($img, $format = 'png'){ //dataImage encode
    $base64 = base64_encode($img);
    $base64url = "data:image/$format;base64,$base64";
    return $base64url;
}

_needphp('img/gd/r');
_needphp('img/gd/rd');
_needphp('img/gd/p');
_needphp('img/gd/pt');