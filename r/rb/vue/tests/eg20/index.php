<?#5-2/2.40
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
    'strLess'
);

$Self = _rb::self();
$relDir = pathLess(dirname(__FILE__), $Self->path('/'));
//dx($relDir);

$Self::req_css("$relDir/styles");

ob_start();
####################################################
?>

<div id="app">
    <p>val1: {{ val1 }}</p>
    <p>val2: {{ val2 }}</p>
    <?//=vue_tpl('my-cmpt', 'vue', "$relDir/cmpt")?>
    <?=vue_tpl(array(
        'name' => 'date-picker',
        'id' => 'cmpt-tpl',
        'attrs' => array(
            '@change="showChange"'
        ),
    ), 'vue', "$relDir/cmpt")?>
</div>

<?=js::html_link($Self::uri("$relDir/app.js.php"))?>

<?###################################################
$body = ob_get_clean();
//dx(vue::html_export());

print rb_tpl('page', 'page', array(
	'body' => $body,
	'webkit' => array(
        'jquery', 'lodash',
        //'llog',
        'vue', array('vue-init', 'Editor')
    ),
));
