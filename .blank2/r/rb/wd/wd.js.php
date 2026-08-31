<?#4.5.0
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _rb::self();
$n = $Self::nc();

$js = array();
$jsDir = $Self::relDir('js');
headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra(
		$n
	),
	$js['cmd'] = "$jsDir/cmd.js.inc",
        $js['cmd/handlers'] = "$jsDir/cmd/handlers.js.inc",
            $js['cmd/handlers/o'] = "$jsDir/cmd/handlers/o.js.inc",
            $js['cmd/handlers/op'] = "$jsDir/cmd/handlers/op.js.inc",
            $js['cmd/handlers/hoverable'] = "$jsDir/cmd/handlers/hoverable.js.inc",
            $js['cmd/handlers/shade'] = "$jsDir/cmd/handlers/shade.js.inc",
            $js['cmd/handlers/off'] = "$jsDir/cmd/handlers/off.js.inc",
        $js['add_cmd/add_button'] = "$jsDir/cmd/add_cmd/add_button.js.inc",
	__FILE__
), SITE_CACHE);

//wjs::req('storage');
//site_js::req_name('jquery');
?>

WD = (function(){

	<? include $js['cmd']; //add_cmd() ?>

    return {
        add_cmd: add_cmd
    }
})()