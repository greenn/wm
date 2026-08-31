<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
//_needphp('mysql/mc.class'); //mc{}

//dx(mc::table_align_type_cfg(5));
//dx(mc::table_align_type_cfg('text'));
//d(mc::table_align_type_cfg('TEXT'));

//d(mc::table_align_item_cfg(array('str-1'))); #+
//d(mc::table_align_item_cfg('str-1')); #+
//d(mc::table_align_item_cfg('')); #+
///d(mc::table_align_item_cfg()); #+

//d(mc::table_align_item_cfg('CHAR(32)')); #+
//d(mc::table_align_item_cfg(array('CHAR(32)'))); #+
//d(mc::table_align_item_cfg(array('TEXT'))); #+
//d(mc::table_align_item_cfg(array(5))); #+


d(mc::table_align_item_cfg('integer(5)')); #~