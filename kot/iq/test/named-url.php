<?
include_once $_SERVER['DOCUMENT_ROOT'].'/metro-targets/iq.inc';

/*

*/
$menuData = metro_api::get_prop('list', 'side-menu/list', array('by' => 'name'));
d($menuData);

d(_metro::namedUrl('msgs'));