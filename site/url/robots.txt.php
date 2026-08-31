<?
//edit htacccess to replace robots.txt with it
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

//dx(data_opt('sid'));
//dx(site_opt('sid'), pro_opt('xx'));



$Rbtx = _rb::name('robots-txt');

//print $Rbtx::tpl('close', array());
print $Rbtx::tpl('open', array(
	'sitemap' => false
));