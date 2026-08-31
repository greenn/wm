<?
$Self = _rt::name('app-busy');

_rb::req_css('lay', 'flex');
_rb::req_css('page', 'css/aq');

rb('page', 'webkit', 'vue-env-2');
//source::req_name('vuetify'); //для tooltip

$Self::req_js(1, "app");
$Self::req_css(1, "app");

$n = $Self::nc();

$_ctx = $Self::tempCtx(array(
	'name' => '',
));

$Self::req_vue('vue-form');


?>

<div class="<?=$n?>-app">
    <h2>headline: {{ headline }}</h2>
    <vue-form></vue-form>
</div>