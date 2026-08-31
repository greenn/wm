<?#5.1338
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
    //'dirUrl',
    'strLess'
);

$Self = _rb::self();

$relDir = pathLess(dirname(__FILE__), $Self->path('/'));
//dx(dirname(__FILE__), $Self->path('/'), $relDir);

//$Self::req_js("$relDir/app");
$Self::req_css("$relDir/styles");

js::req(false, 'https://unpkg.com/marked@0.3.6');

ob_start();
?>

<div id="editor">
    <textarea :value="input" @input="update"></textarea>
    <div v-html="compiledMarkdown"></div>
</div>

<?=js::html_link($Self::uri("$relDir/app.js.php"))?>

<?
$body = ob_get_clean();

print rb_tpl('page', 'page', array(
	'body' => $body,
	'webkit' => array('jquery', 'lodash', 'vue'),
));
