<?
include_once $_SERVER['DOCUMENT_ROOT'].'/site/iq.inc';

$Self = self_rp();
//$n = $Self::nc();
$js = array();
headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra(
	    //$n
    ),
    $js['msg'] = $Self::path('js/msg', 'js.inc'),
    __FILE__
), SITE_CACHE);

//wjs::req('llog');
?>

var System = (function(){
    var $node; //after init


	<? include $js['msg']; //msg() ?>

    var init = function(){}

    return {
        init: init,
        msg: msg,
        warning: msg.warning,
    }

})();


$(function(){
    System.init();
})