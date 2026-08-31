<?
_needphp('dirUrl');

/*  gen3:

    https://favicon.io/favicon-converter/


    'favicon' => array(
		'generator' => 'gen3',
		'dir' => _ap('selfDir').'/i/favicon/01',
	),

*/

$Self = _rb::self();

$_ctx = $Self::tempCtx(array(
	'dir' => '',
));
$dir = $_ctx['dir'];
$dirUri = dirUrl($dir);
?>

<link rel="apple-touch-icon" sizes="180x180" href="<?=$dirUri?>/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?=$dirUri?>/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?=$dirUri?>/favicon-16x16.png">
<link rel="manifest" href="<?=$dirUri?>/site.webmanifest">