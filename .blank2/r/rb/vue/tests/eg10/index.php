<?#3.1140
	include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

	//need::php('dirUrl');
	_needphp(
        'dirUrl',
        'useTemplate',
        'gt'
    );

	useTemplate();
	$dirUri = dirUrl(__FILE__);
	//dx($dirUri);

	$selfDir = dirname(__FILE__);

	//dx(SITE_CACHE);
    //dx(_gi(true), real_gi_key(0, '-'));


#https://next.vuetifyjs.com/en/styles/border-radius/#usage
?>

<head>

    <link rel="stylesheet" href="<?=$dirUri?>/styles.css.php" />
    <script src="/js/lodash/4.17.21/lodash.min.js"></script>
    <script src="/js/jquery/1.12.4/jquery.min.js"></script>
    <script src="/js/vue/3.2.20/vue.global.js"></script>

</head>

<body class="loading no_js">
    <?= useTemplate("$selfDir/html.tpl.php", array()) ?>

    <?
        $nm = 'app';
    ?>
    <script src="<?="$dirUri/$nm.js.php"?>"></script>

</body>


