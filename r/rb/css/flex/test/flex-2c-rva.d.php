<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('pcss');

//$Self = _rb::self();
//dx($Self);

_rp::req_css('ui', 'css/ft');
//_rp::req_css('ui', 'css/ui');

ob_start(); ?>

<style type="text/css">

	[content] { border: 1px solid chocolate }
	[fx] {
		<?//=pcss('display', 'flex')?>
		<?=pcss(array(
			'display' => 'flex',
			'flex-direction' => 'row',
			//'flex-wrap' => 'nowrap',
			'justify-content' => 'space-between',
			'align-items' => 'stretch',
			//'align-content' => 'stretch',
			//'align-items' => 'flex-start',
		))?>
	}

	[fxc] {
		background-color: rgba(30, 144, 255, .4);
	}
	[fxc][right] {
		<?=pcss(array(
		   'display' => 'flex',
		   'flex-direction' => 'column',
		   'justify-content' => 'center',
		))?>
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
	<section fx="c">
		<div fxc left>
			<span content="logo">logo img</span>
		</div>
		<div fxc right="va">
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