<?#1.0.0

/* 22
 	http://stackoverflow.com/questions/5560248/programmatically-lighten-or-darken-a-hex-color-or-rgb-and-blend-colors
*/

function hex2rgb($strHEX, $alpha = null){
    $strRGB = false;
    if ($isShortHEX = preg_match('~^#?[\w]{3}$~', $strHEX)) {
        $strHEX = preg_replace('~([\w]{1})~', '$1$1', $strHEX);
    };
    preg_match_all('~([\w]{2})~', $strHEX, $matches);
    $values = $matches[1];
    $valuesCount = count($values);
    if ($valuesCount == 3 || $valuesCount == 4) {

        $hasOpacity = $valuesCount == 4;
        $opacity = null;
        $unsetAlpha = $alpha === false;
        $setAlpha = !is_null($alpha) && !$unsetAlpha;

        if ($hasOpacity) {
            if ($unsetAlpha) {
                array_shift($values);
                $hasOpacity = false;
            } else {
                $opacity = round(hexdec(array_shift($values)) / 255, 2);
            }
        }

        if ($setAlpha) {
            $opacity = $alpha;
            $hasOpacity = true;
        }

        $a = $hasOpacity ? 'a' : '';
        $addOpacity = $hasOpacity ? ',' . $opacity : '';
        $strRGB = "rgb$a" . '(' . join(",", array_map('hexdec', $values)) . $addOpacity . ')';
    }
    return $strRGB ? $strRGB : $strHEX;
}

/* ^
    https://beijingyoung.com/articles/rgba-argb-converter/
*/

/*
rgbToHex('rgba(255,0,255)', .1); #19ff00ff
rgbToHex('rgba(255,0,255,1)', false); #ff00ff
*/
function rgb2hex($strRGB, $alpha = null){
    $strHEX = false;
    preg_match_all('~([\d\.]+)~', $strRGB, $matches);
    $values = $matches[1];
    $valuesCount = count($values);
    if ($valuesCount == 3 || $valuesCount == 4) {
        $unsetAlpha = $alpha === false;
        $setAlpha = !is_null($alpha) && !$unsetAlpha;
        $hasAlpha = $valuesCount == 4;

        if ($hasAlpha && $unsetAlpha) {
            unset($values[$valuesCount = 3]);
            $hasAlpha = false;
        }

        if ($setAlpha) {
            // if ($alpha > 1) $alpha /= 100;
            $values[3] = $alpha;
            $hasAlpha = true;
            $valuesCount = 4;
        }

        if ($hasAlpha) {
            //ковертив для web
            //li q
            // https://beijingyoung.com/articles/rgba-argb-converter/
            //  http://stackoverflow.com/questions/23136223/php-convert-argb-to-rgba#23136532
            $values[3] *= 255;
            # ставим значение альфы на первое место с четвёртого
            $values = array_merge(array_splice($values, 3), $values);
        }

        $pattern = '#' . str_repeat('%02x', $valuesCount);
        $strHEX = vsprintf($pattern, $values);
    }
    return $strHEX ? $strHEX : $strRGB;
}


//https://stackoverflow.com/questions/1740700/how-to-get-hex-color-value-rather-than-rgb-value

//https://stackoverflow.com/questions/32962624/convert-rgb-to-hex-color-values-in-php