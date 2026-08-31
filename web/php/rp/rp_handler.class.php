<?#0.2.1f

_needphp('rp/rp_shandler.class');
/*
    он не экстендится от rp_shandler
    но по __call и _get возможно может обращаться к rp_shandler-методам \n
*/

class rp_handler {
	var $ctx = null;
	function __construct() {}
}