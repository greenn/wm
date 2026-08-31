<?#0.2.0
/* q lefgacy - сейчас L для filename, а было почему ?
		потому что сейчас используется web/inc/css/di.php
			автоматом гружённое для web/inc/css/pcss/un1px.css.inc
*/
_needphp('img/i_');

function image1px($hexColor){
	return gdi_1px($hexColor);
}

function image_px($size, $hexColor){
	return gdi_px($size, $hexColor);
}