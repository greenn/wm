<?
$Self = _site::self();
_site::req('page-content');
$n = $Self::nc();

//$Self::req_js('app');
$Self::req_css('page');

$_ctx = $Self::tempCtx(array(
	'content-title' => '',

	'contents' => '',
        'content' => '',
        'content-tpl' => '',

	//'content-wrapper' => true,

));

$_ctx0 = $_ctx; //dbg
$_ctx = site_page_content::handleContentCtx($_ctx);
//dx($_ctx, $_ctx0);
$content = site_page_content::applyContentCtx($_ctx);

$_content = $content;
/*
$contentW = $_ctx['content-wrapper'];
if ($contentW !== false) {
    if (!is_array($contentW)) $contentW = array(); //для true
	$_content = $Self::tpl('content-wrapper', $contentW + array(
        'content' => $content,
        'content-title' => $_ctx['content-title'],
    ));
}
*/

?>
<div class="<?=$n?>">
    <div class="<?=$n?>-w site-w" mqr>
        <?=site_tpl('header')?>
        <?=site_tpl('titul')?>
        <?=site_tpl('footer')?>
    </div>
</div>


