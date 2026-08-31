<?

//include_once 'cache-panel.r.php';

$rcc = array( // resource class config
    'replaceWith' => false,
    'objFunction' => false,
    'objClass' => 'rCP',
);

return $rcc;

function rCP_html(){




}

class rCP extends RC {


	function html(){

        //$html = $this->r()->api('get', 'html');
		//$html = '<b>HTML</b>';

		$tplPath = $this->r()->dir('tpl/cache-panel.tpl.php');
		$html = inc($tplPath, INC_RES_AS_STRING);


        return $html;

    }

}