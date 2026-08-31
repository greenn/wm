<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';


if (!isMe) { print 'Обновление…'; exit; }
//dx(proKot::$cfg);
//dx(_cssKot::$db);
///dx(mcKot::table_all(), mc('mcKot', 'last_sql')); //mc::last_sql
//dx(mcKot::all_data());

//dx(kot('hp', 'namedUrl', 'site-menu'));

//dx(13);
print admin_tpl('app', 'html', array(
	'baseUri' => '/admin'
));