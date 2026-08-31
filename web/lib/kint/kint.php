<?#3.2

$kintVersionDir = 'kint-master';
$kintConnectorFile = 'Kint.class.php';

$__DIR__ = dirname(__FILE__);
$kintConnectorPath = $__DIR__.'/'.$kintVersionDir.'/'.$kintConnectorFile;

include_once $kintConnectorPath;


//man https://kint-php.github.io/kint/settings/
//Kint::enabled(null); - отключить все выводы
//Kint::$aliases[] = 'dd';

/*[pr]
	https://github.com/kint-php/kint/issues/201
	g kint php switched out plain
*/
//Kint::enabled('p'); //c | r | p | w

//addedTo { public static $aliases } (line: 61)

//d($kintConnectorPath);
function kint_source() {
	$path = dirname(__FILE__).'/gen/web.min.html';
	return file_get_contents($path);
}

if (!is_callable('dn')) {
    function dn(){
	    if (!headers_sent()) {
		    header('Content-Type: text/html; charset=utf-8');
	    }
        $args = func_get_args();
        call_user_func_array('d', $args);
    }
}
if (!is_callable('dextract')) {
	function dextract(){
		if (!headers_sent()) {
			header('Content-Type: text/html; charset=utf-8');
		}
		$args = func_get_args();
		call_user_func_array('d', $args);
	}
}

if (!is_callable('dx')) {

    function dx(){
        if (!headers_sent()) {
            header('Content-Type: text/html; charset=utf-8');
        }
	    /*
        echo val_export(Kint::MODE_WHITESPACE), '<hr />';
	    echo Kint::enabled(), '<hr />';
	    */
        //exit;


	    /*$enabled = Kint::enabled();
	    if ( !$enabled ) return '';

	    if ( $enabled === Kint::MODE_WHITESPACE ) { # if already in whitespace, don't elevate to plain
		    $restoreMode = Kint::MODE_WHITESPACE;
	    } else {
		    if (PHP_SAPI === 'cli') {
			    $restoreColors = Kint::$cliColors;
			    Kint::$cliColors = false;
		    } else {
			    $restoreMode = Kint::enabled( Kint::MODE_PLAIN );
		    }
	    }

	    $params = func_get_args();
	    $dump   = call_user_func_array( array( 'Kint', 'dump' ), $params );

	    isset( $restoreMode ) and Kint::enabled( $restoreMode );
	    isset( $restoreColors ) and Kint::$cliColors = $restoreColors;
	    print $dump;
	    exit;*/

        $args = func_get_args();
        call_user_func_array('d', $args);
        exit;
    }
}

if (!is_callable('ds')) {
	function ds(){
		if (!headers_sent()) {
			header('Content-Type: text/html; charset=utf-8');
		}
		$args = func_get_args();
		call_user_func_array('d', $args);
	}
}

if (!is_callable('dp')) {
	function dp(/*args*/){
		Kint::enabled( Kint::MODE_CLI );
		Kint::$maxLevels = 10; // ||false

		$args = func_get_args();
		call_user_func_array('d', $args);
	}

}

if (!is_callable('dpx')) {

	function dpx(/*args*/){
		Kint::enabled( Kint::MODE_CLI ); //MODE_PLAIN
		Kint::$maxLevels = 10; // ||false

		$args = func_get_args();
		call_user_func_array('d', $args);
		exit;
	}

}

if (!is_callable('_dx')) {
	function _dx(/*args*/){}
}

if (!is_callable('dxextract')) {
	function dxextract(){
		if (!headers_sent()) {
			header('Content-Type: text/html; charset=utf-8');
		}
		$args = func_get_args();
		call_user_func_array('d', $args);
		exit;
	}
}

if (!is_callable('dc')) {
    function dc(){
        $args = func_get_args();
        ob_start();
        call_user_func_array('d', $args);
        $content = ob_get_clean();
        return $content;
    }
}

if (!is_callable('d1')) {
    function d1($argForD){
        //call_user_func_array('d', is_array($argForD) ? $argForD : array('d1' => $argForD ));
        $args = func_get_args();
        call_user_func_array('d', is_array($argForD) ? $argForD : array($args));
    }
}

if (!is_callable('d0')) {
    function d0_(){
        $args = func_get_args();
        print_r(
            "\r\n".'-  -   -   /'."\r\n".
            val_export($args, true)
            ."\r\n".'/  -   -   -'."\r\n"
        );
    }

	function d0(){
		$args = func_get_args();
        print_r("\r\n".'-  -   -   /'."\r\n");
        foreach ($args as $arg) {
	        print_r(val_export($arg, true)."\r\n");
        }
        print_r("\r\n".'/  -   -   -'."\r\n");
    }
}

if (!is_callable('dx0')) {
    function dx0(){
        call_user_func_array('d0', func_get_args());
        exit;
    }
}