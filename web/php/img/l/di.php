<?#0.2.0
//q di / encoded image ? /> [rb]
_needphp('img/i_');

function i64_1px($bgColor){
	return gdi_1px($bgColor);
}

function i64_dash($dashColor = true, $bgColor = true, $wDash = true, $wSpace = true, $height = true, $posDash = true){
	$set = array();
	if (is_string($dashColor)) $set['hexDashColor'] = $dashColor;
	if (is_string($bgColor)) $set['hexBgColor'] = $bgColor;
	if (is_stringable($wDash)) $set['dash_width'] = $wDash;
	if (is_stringable($wSpace)) $set['dash_space'] = $wSpace;
	if (is_stringable($posDash)) $set['dash_start'] = $posDash;
	if (is_stringable($height)) $set['height'] = $height;
	return gdi_dash($set);
}