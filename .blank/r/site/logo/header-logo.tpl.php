<?
$Self = _site::self();
$nH = $Self::nc('header');
$Self::req_css('logo');

$_ctx = $Self::tempCtx(array());

$href = '//'.HOST;
//$href = URI.'#'.$href; //dev

$title = 'На главную';
$niLogo = 'logo/gss-logo-22.png';

$title = $Self::splitTitle(_pro('company-title'), 3);
//site('jsonld', 'add', 'logo', array('src' => $niLogo));
?>
<a fxr fxi="c" class="<?=$nH?>" href="<?=$href?>" tdn cp>
    <? if (0){ ?><span class="<?=$nH?>-abbr ft-logo-abbr" mr10>
        <?=_pro('company-name')?>
    </span><? } ?>
    <span ibfx class="<?=$nH?>-pic">
        <?=_i::img($niLogo)?>
    </span>
    <span class="<?=$nH?>-title ft-logo">
        <?=$title?>
    </span>
</a>