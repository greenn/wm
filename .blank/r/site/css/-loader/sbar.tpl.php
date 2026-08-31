<?
# https://codepen.io/Bilal1909/pen/zYqrdRe
$Self = _rp::self();
$Self::req_css('css/loader/sbar');
$_ctx = $Self::tempCtx(array(
    'wrap' => false
));
$wrap = $_ctx['wrap'];
?>
<? if ($wrap) { ?><div class="sbar-w"><? } ?>
    <div class="sbar bar1"></div>
    <div class="sbar bar2"></div>
    <div class="sbar bar3"></div>
    <div class="sbar bar4"></div>
    <div class="sbar bar5"></div>
    <div class="sbar bar6"></div>
    <div class="sbar bar7"></div>
    <div class="sbar bar8"></div>
<? if ($wrap) { ?></div><? } ?>