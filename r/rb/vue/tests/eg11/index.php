<?#3.1140
	include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

	//need::php('dirUrl');
	_needphp(
        'dirUrl',
        'useTemplate',
        'gt'
    );

	//useTemplate();
	$dirUri = dirUrl(__FILE__);
	//dx($dirUri);

	$selfDir = dirname(__FILE__);

	//dx(SITE_CACHE);
    //dx(_gi(true), real_gi_key(0, '-'));


/*
    https://codesandbox.io/s/o29j95wx9?file=/index.js:157-167
        https://ru.vuejs.org/v2/guide/single-file-components.html
        https://sfc.vuejs.org/#eyJBcHAudnVlIjoiPHNjcmlwdCBzZXR1cD5cbmltcG9ydCB7IHJlZiB9IGZyb20gJ3Z1ZSdcblxuY29uc3QgbXNnID0gcmVmKCdIZWxsbyBXb3JsZCEnKVxuPC9zY3JpcHQ+XG5cbjx0ZW1wbGF0ZT5cbiAgPGgxPnt7IG1zZyB9fTwvaDE+XG4gIDxpbnB1dCB2LW1vZGVsPVwibXNnXCI+XG48L3RlbXBsYXRlPiIsImltcG9ydC1tYXAuanNvbiI6IntcbiAgXCJpbXBvcnRzXCI6IHtcbiAgICBcInZ1ZVwiOiBcImh0dHBzOi8vc2ZjLnZ1ZWpzLm9yZy92dWUucnVudGltZS5lc20tYnJvd3Nlci5qc1wiXG4gIH1cbn0ifQ==
*/
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


