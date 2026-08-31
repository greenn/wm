<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>

body {
	margin: 30px;
}

svg {
	display: block;
}

polygon {
	fill: #41b883;
}

circle {
	fill: transparent;
	stroke: #35495e;
}

input[type=range] {
	display: block;
	width: 100%;
	margin-bottom: 15px;
}