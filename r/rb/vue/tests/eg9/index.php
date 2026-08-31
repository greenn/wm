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
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@3.0.0-alpha.11/dist/vuetify.css" rel="stylesheet">


    <link rel="stylesheet" href="<?=$dirUri?>/styles.css.php" />
    <script src="/js/lodash/4.17.21/lodash.min.js"></script>
    <script src="/js/jquery/1.12.4/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/babel-polyfill/dist/polyfill.min.js"></script>
    <script src="https://unpkg.com/vue@next/dist/vue.global.js"></script>
    <script src="https://unpkg.com/vuetify@3.0.0-alpha.11/dist/vuetify.js"></script>
</head>

<body class="loading no_js">
    <?= useTemplate("$selfDir/html.tpl.php", array()) ?>

    <?
        $nm = 'app';
        $v = real_gi_key(0, '');
        if ($v == 'es6') {
            $nm .= ".$v";
        }
    ?>
    <script src="<?="$dirUri/$nm.js.php"?>"></script>

</body>


