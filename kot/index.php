<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';

//dx(proKot::$cfg);
//dx(_cssKot::$db);
///dx(mcKot::table_all(), mc('mcKot', 'last_sql')); //mc::last_sql
//dx(mcKot::all_data());

//dx(kot('hp', 'namedUrl', 'site-menu'));


print kot_tpl('app', 'page', array(
	'baseUri' => '/kot'
));