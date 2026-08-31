<?
_needphp('dirUrl');

/*  gen2:

    https://www.favicon-generator.org/

*/

$Self = _rb::self();

$_ctx = $Self::tempCtx(array(
	'dir' => '',
));
$dir = $_ctx['dir'];
$dirUri = dirUrl($dir);
?>

<?/*
    Эти теги определяют иконки для устройств Apple, таких как iPhone и iPad.
    Они используются для добавления вашего сайта на домашний экран устройства.
    Размер иконки указывается через атрибут sizes.
*/?>
<link rel="apple-touch-icon" sizes="57x57" href="<?=$dirUri?>/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?=$dirUri?>/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?=$dirUri?>/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?=$dirUri?>/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?=$dirUri?>/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?=$dirUri?>/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?=$dirUri?>/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?=$dirUri?>/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?=$dirUri?>/apple-icon-180x180.png">

<?/*
    Эти теги задают фавиконы для различных устройств и экранов.
    Атрибут sizes определяет размер иконки,
    а type указывает формат изображения (в данном случае PNG).
    Эти иконки могут использоваться браузерами для отображения вашего сайта в различных местах,
    включая вкладку браузера, меню закладок и т.д
*/?>
<link rel="icon" type="image/png" sizes="192x192"  href="<?=$dirUri?>/android-icon-192x192.png">
<?/* 32x32 - Именно этот фавикон будет отображаться на вкладке браузера, а также в списке закладок и в других местах, где браузеры отображают значок сайта. */?>
<link rel="icon" type="image/png" sizes="32x32" href="<?=$dirUri?>/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?=$dirUri?>/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?=$dirUri?>/favicon-16x16.png">

<?/*
    Этот тег указывает на файл manifest.json,
    который содержит метаданные о вашем приложении,
    такие как иконки, цветовые схемы и другие параметры,
    влияющие на внешний вид и поведение PWA (прогрессивного веб-приложения).
*/?>
    <?/*
        $fileContent = file_get_contents($filePath);
        $base64Content = base64_encode($fileContent);
        $dataUrl = 'data:application/json;base64,' . $base64Content;
        href="<?= $dataUrl ?>"
    */?>
<link rel="manifest" href="<?=$dirUri?>/manifest.json">

<?/*
    Эти мета-теги используются для настройки отображения сайта на устройствах под управлением Windows.
    Они определяют цвет плитки и иконку для закрепления сайта на начальном экране Windows (в стиле плиток).
*/?>
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="<?=$dirUri?>/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">