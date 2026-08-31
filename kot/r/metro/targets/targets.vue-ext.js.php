<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';
_needphp(
	'headers'
);
$Self = _kot::self();
//$n = $Self::nc();

$js = array();
headers('js', 'utf8', 'nosniff', etag::ctx(
	etag::extra(),
	$js['provide/target-tpl/fetchData'] = kot('target-tpl', 'path', 'provide-v1/fetchData.js.inc'),
	$js['provide/target-tpl/fetchInitData'] = kot('target-tpl', 'path', 'provide-v1/fetchInitData.js.inc'),
	$js['provide/target-tpl/onReady'] = kot('target-tpl', 'path', 'provide-v1/onReady.js.inc'),
	$js['provide/target-tpl/w:wait'] = kot('target-tpl', 'path', 'provide-v1/w_wait.js.inc'),
	$js['provide/target-tpl/_w:cfg'] = kot('target-tpl', 'path', 'provide-v1/w_cfg.js.inc'),
	$js['provide/target-tpl/validate'] = kot('target-tpl', 'path', 'provide-v1/validate.js.inc'),

	$js['provide/target-tpl'] = kot('target-tpl', 'path', 'provide/target-tpl.js.inc'),
	$js['provide/intervalRelValues'] = kot('target-tpl', 'path', 'provide/intervalRelValues.js.inc'),
	$js['provide/target-tpl2'] = kot('target-tpl', 'path', 'provide/target-tpl2.js.inc'),

	$js['provide/target2-tpl'] = kot('target-tpl', 'path', 'provide/v2-target-tpl.js.inc'),
	$js['provide/target2-tpl2'] = kot('target-tpl', 'path', 'provide/v2-target-tpl2.js.inc'),
	__FILE__
), SITE_CACHE);
?>
<? if (_pro('v_tt') === 1) { ?>

	<? include $js['provide/target-tpl/fetchData']; ?>
	<? include $js['provide/target-tpl/fetchInitData']; ?>
	<? include $js['provide/target-tpl/onReady']; ?>
	<? include $js['provide/target-tpl/w:wait']; ?>
	<? include $js['provide/target-tpl/_w:cfg']; ?>

	<? include $js['provide/target-tpl/validate']; ?>
<? } else { ?>

	<? include $js['provide/target-tpl']; ?>

<? } ?>

<? include $js['provide/intervalRelValues']; ?>

<? include $js['provide/target-tpl2']; ?>

<? include $js['provide/target2-tpl']; ?>

<? include $js['provide/target2-tpl2']; ?>
