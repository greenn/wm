<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp('pro/idb.class');

//dx(_pro('page-title-suffix'), mcKot::db_current(), _cssKot('blue-azure'), _cssKot('blue-azure'));

idb::$Pro = 'proKot';
idb::$MC = 'mcKot';

//dx(mcKot::db_current(false), mc::table_all());


//dx(is_file(proKot('db-struct-path')), proKot('db-struct-path'), proKot::db_struct());

idb::init_form_output();