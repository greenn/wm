<?
	include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

	//need::php('dirUrl');
	_needphp('dirUrl', 'useTemplate');

	useTemplate();
	$dirUri = dirUrl(__FILE__);
	//dx($dirUri);

	$selfDir = dirname(__FILE__);

	//dx(SITE_CACHE);

?>


<link rel="stylesheet" href="<?=$dirUri?>/eg1.css.php" />

<script src="/js/lodash/4.17.21/lodash.min.js"></script>
<script src="/js/jquery/1.12.4/jquery.min.js"></script>
<script src="/js/vue/3.2.20/vue.global.js"></script>


<?= useTemplate("$selfDir/eg1.tpl.php", array()) ?>

<script src="<?=$dirUri?>/eg1.js.php"></script>

