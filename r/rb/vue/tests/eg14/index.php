<?#4.2235
	include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
    _needphp(
        'dirUrl',
        'useTemplate'
    );

	$dirUri = dirUrl(__FILE__);
	$selfDir = dirname(__FILE__);
?>

<head>

    <link rel="stylesheet" href="<?=$dirUri?>/styles.css.php" />
    <?=r_tpl('vue', 'script/head', array(
        'app' => false,
        'test-styles' => false,
        'router' => !true,
    ))?>

</head>

<body class="loading no_js">
    <?= useTemplate("$selfDir/html.tpl.php", array()) ?>
    <script src="<?="$dirUri/app.js.php"?>"></script>

</body>


