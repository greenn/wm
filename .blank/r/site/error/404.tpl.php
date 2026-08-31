<?
$Self = _site::self();
$nH = $Self::nc('http');

$Self::req_css('http');
$_ctx = $Self::tempCtx(array(
    'msg' => true,
));


$_tx = $Self::lang();

$msg = $_ctx['msg'];
if ($msg === true) {
    $msg = $_tx['404-msg'];
}

?>

<div t class="<?=$nH?>">
    <div r tc nobr class="<?=$nH?>-coolpic">
        <?=_i::img('error/404/full/granit-4g-a.png')?>
        <?=_i::img('error/404/full/granit-0gd-4.png')?>
        <?=_i::img('error/404/full/granit-4r-a.png')?>
    </div>
    <div class="<?=$nH?>-w" tc>
        <? if ($msg) { ?>
            <h3 class="<?=$nH?>-msg"><?=$msg?></h3>
		<? } ?>
        <div txc class="<?=$nH?>-uri -vt" title="<?=URI?>"><?=_pageUri?></div>
    </div>
</div>