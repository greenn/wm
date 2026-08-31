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

?>

<head>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

    <link rel="stylesheet" href="<?=$dirUri?>/styles.css.php" />
    <script src="/js/lodash/4.17.21/lodash.min.js"></script>
    <script src="/js/jquery/1.12.4/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
</head>

<body>
    <?= useTemplate("$selfDir/html.tpl.php", array()) ?>
    <script src="<?="$dirUri/app.js.php"?>"></script>

</body>


