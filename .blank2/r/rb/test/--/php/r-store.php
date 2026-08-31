<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

$html = r_tpl('page', 'content/club');
dx($html, rp('page', 'store_last', 'title'), rp_page::$store);