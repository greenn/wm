<?#5-2/3.3.116
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
    'strLess'
);

$Self = _rb::self();
$relDir = pathLess(dirname(__FILE__), $Self->path('/'));
//dx($relDir);
$selfName = $Self::cfg('rName');



ob_start();
####################################################
?>

<div id="app">
    <? vue::req('cmpt', $selfName, "$relDir/cmpt/cmpt"); ?>
    <cmpt></cmpt>
</div>

<?=js::html_link($Self::uri("$relDir/app.js.php"))?>

<?###################################################
$body = ob_get_clean();
$Self::req_css("$relDir/styles");

print rb_tpl('page', 'page', array(
	'body' => $body,
	'webkit' => array(
        'jquery', 'lodash',
        //'llog',
        'vue', array('vue-init', 'Editor')
    ),
));
