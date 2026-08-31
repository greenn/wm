<?
//edit htaaccess to replace robots.txt with it
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

$Rbtx = _rb::name('robots-txt');

//print $Rbtx::tpl('close', array());
print $Rbtx::tpl('open', array());