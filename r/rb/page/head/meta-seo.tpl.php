<?

$Self = _rb::self();
$_ctx = $Self::tempCtx(array(
    //'glob-keywords' => false,
    'norobots' => false,
    'robots' => '',
    'keywords' => '',
    'description' => '',
    'content' => '',
));
//dx($_ctx);


//$globKeywords = $_ctx['glob-keywords'];
$content = $_ctx['content'];
$keywords = $_ctx['keywords'];
if (is_array($keywords)) {
	$keywords = join(', ', $keywords);
}
$description = $_ctx['description'];



$robots = $_ctx['robots'];
$norobots = $_ctx['norobots']; //https://developers.google.com/search/reference/robots_meta_tag?hl=ru
if ($norobots) {
	$robots = is_string($norobots) ?: 'noindex';
}
/*
    noindex: Страница не будет проиндексирована.
    nofollow: Поисковые роботы не будут следовать по ссылкам на странице.
    noindex, nofollow: Страница не будет проиндексирована, и роботы не будут следовать по ссылкам.
    index: Разрешает индексацию страницы (значение по умолчанию).
    follow: Разрешает следование по ссылкам (значение по умолчанию).
*/

?>
<? //if (1) print call_rp('yandex', 'webmaster_verification'); ?>

<? if ($robots) { ?>
    <meta name="robots" content="<?=$robots?>" />
<? } ?>
<? if ($keywords) { ?>
    <meta name="keywords" content="<?=$keywords?>" />
<? } ?>
<? if ($description) { ?>
    <meta name="description" content="<?=$description?>" />
<? } ?>
<? if ($content) { ?>
    <?=$content?>
<? } ?>