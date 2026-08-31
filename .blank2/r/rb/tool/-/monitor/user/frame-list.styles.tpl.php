<?
//$_ctx = qtpl::ctx(array(), $_ctx);
?>

<?if(0){?><link type="text/css" rel="stylesheet" href="<?=qv(dirUrl().'/frame-list.css.php')?>" /><?}?>
<link type="text/css" rel="stylesheet" href="<?=qv('/rb/lay/flex.css.php')?>" />
<link type="text/css" rel="stylesheet" href="<?=qv('/rb/css/aq.css.php')?>" />
<style type="text/css">
	DIV[col] {
		width: 400px;
		height: 400px;
		outline: 1px solid mediumseagreen;
	}
	HEADER {
		background-color: lightgoldenrodyellow;
	}
	SECTION[iframe] {
		position: relative;
	}
	IFRAME {
		width: 100%;
		height: 100%;
	}
	DIV[cover]:after {
		content: '🕰';
		position: absolute;
		display: inline-block;
		top: 50%;
		left: 50%;
		margin-left: -2px;
		margin-top: -2px;
	}
	DIV[cover] {
		background-color: lightgoldenrodyellow;
		opacity: .9;
	}
</style>
