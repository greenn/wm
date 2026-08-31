<?
$Self = _lay::self();


//_rb::req_css('lay', 'flex');
//_rb::req_css('page', 'css/aq');


$_ctx = $Self::tempCtx(array(
    'nc' => '',
    'pic-main' => array(),
    'pic-main-def' => array(
        'tpl' => 'split-3d-1'
    ),
    'pic-middle' => array(),

    'text1' => '',
    'text2' => '',
));
$nc = $_ctx['nc'];
if (!$nc) {
	$nc = $Self::nc('VC2'); //vmk-content-2
	$Self::req_css('vmk-text-gal');
}



$text1 = $_ctx['text1'];
$text2 = $_ctx['text2'];

$picMainHtml = lay('pic', 'applyCtx', $_ctx['pic-main'], $_ctx['pic-main-def']);
$picMiddleHtml = lay('pic', 'applyCtx', $_ctx['pic-middle']);


$html1 = LayTextParser::applyHtml($text1);
$html2 = LayTextParser::applyHtml($text2);

?>

<div class="<?=$nc?>">
    <div class="<?=$nc?>-pic -top"><?=$picMainHtml?></div>
    <div class="<?=$nc?>-text _1"><?=$html1?></div>
    <div class="<?=$nc?>-pic -middle"><?=$picMiddleHtml?></div>
    <div class="<?=$nc?>-text _2"><?=$html2?></div>
</div>