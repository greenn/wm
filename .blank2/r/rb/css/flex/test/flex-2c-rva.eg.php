<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('pcss');

$Self = _rb::self();
//dx($Self);
$Self::req_css('flex');
_rp::req_css('ui', 'css/ft');
//_rp::req_css('ui', 'css/ui');

ob_start(); ?>

<style type="text/css">

	[content] { border: 1px solid chocolate }

	[col] {
		background-color: rgba(30, 144, 255, .4);
	}

	SECTION {
		width: 361px;
		height: 117px;
		outline: 1px dotted dodgerblue;
	}
	[content="logo"] {
		height: 90px;
		width: 90px;
		display: inline-block;
	}
</style>


<main>
	<section fxr="sb" fxi="s">
		<div col left>
			<span content="logo">logo img</span>
		</div>
		<div col right fx="va" >
			<span content="title">title text</span>
		</div>
	</section>
</main>

<? $_body = ob_get_clean();

print rb_tpl('page', 'page', array(
	'body' => $_body,
	'webkit' => array(
		'base-css',
		'jquery',
		'lodash',
	)
));