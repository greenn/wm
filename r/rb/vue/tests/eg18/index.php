<?#5-2.1451
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
    'strLess'
);

$Self = _rb::self();
$relDir = pathLess(dirname(__FILE__), $Self->path('/'));
//dx($relDir);

$Self::req_css("$relDir/styles");

ob_start();
?>
<?//=js::html_link($Self::uri("$relDir/app.js.php"))?>
<div id="app" class="demo">
    <p>First name: {{ firstName }}</p>
    <p>Last name: {{ lastName }}</p>
    <?=vue_tpl(array(
        'id' => 'user-name',
        'attrs' => array(
            'v-model:first-name="firstName"',
            'v-model:last-name="lastName"',
        )
    ), 'vue', "$relDir/cmpt")?>
    <?/*
    <user-name
        v-model:first-name="firstName"
        v-model:last-name="lastName"
    ></user-name>
    */?>
</div>

<?//=js::html_ctx(array('vue', 'vue-mount', array('var' => 'app', 'id' => 'editor'), 'js.inc'))?>
<?//<script>app.mount('#editor')</script>?>
<?=js::html_link($Self::uri("$relDir/app.js.php"))?>

<?
$body = ob_get_clean();

print rb_tpl('page', 'page', array(
	'body' => $body,
	'webkit' => array(
        'jquery', 'lodash',
        'vue', array('vue-init', 'Editor')
    ),
));
