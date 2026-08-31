<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';


_site::req_vue('catalog', 'prod-section');

$content = join(newline, array(
	//'<div style="padding: 15px 10px;">',
	'<prod-section section="tombs" lim="6"></prod-section>',
	//'</div>',
));

return array(
	'img' => 'prod-filter.png',
	'embody' => $content,
);