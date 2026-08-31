<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

$Root = _rt::name('root');
//dx(is_file($Root::path($Root::relDir('seo-keywords.class.inc'))));
include_once $Root::path($Root::relDir('app-busy.class.inc'));

$Self = _rt::name('app-busy');


//site('app', 'handleAppCtx', $app);
print rb_tpl('page', 'page', array(
	'pageTitle' => join(' / ', array(
		basename(__FILE__, '.php'),
		basename(dirname(__FILE__)),
	)),
	///'webkit' => $Self::webkit(),
	/*'raw-source' => join(newline2, array(
		_css::fontsLinks(),
		//rb('aos', 'init_js', true, true)
	)),*/
	'body' => $Self::tpl('app')
));