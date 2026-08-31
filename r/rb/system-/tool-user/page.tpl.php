<?
$Self = self_rp();
$pr = $Self::relPath(__FILE__); //'tool-log';

site_js::req_name('jquery'); //td $Site::req_name('jquery')
site_js::req_name('lodash');
//site_js::req_name('ko');
site_js::req_index(-45, 'web', array('knockout'));
site_js::req_index(-35, 'web', array('knockout/handlers'));

//$Self::req_css("$pr/tool-user");



print rp_tpl('page', 'page', array(
	//'title' => $PageData->pageTitle(),
	//'favicon' => true, //td array()
	//'metaCtx' => array(),
	//'isMobile' => true,

	//'webKit' => false, //[df false]
	//'webSources' => true, //[df false]

	'body_replace' => true,

	'body' => $Self::tpl("$pr/body")
	//'body' => $Self::tpl("$pr/body")
));

//call_rp('visitors', 'logCurrent', $PageData);
