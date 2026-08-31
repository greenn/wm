<?

$Self = _rb::self();

$_ctx = $Self::tempCtx(array(
	'href' => true,
));

$href = $_ctx['href'];
if ($href === true) $href = '/favicon.ico';

?>
    <link rel="shortcut icon" href="<?=$href?>" />
<?/*
    <link rel="icon" type="image/x-icon" href="">
*/?>