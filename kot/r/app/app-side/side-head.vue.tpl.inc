<?
$Self = _kot::self();
$nH = $Self::nc('head');

$Self::req_css('app-side');

?>

<div fxr fxi="c" class="<?=$nH?>">

    <div class="<?=$nH?>-logo" @click="linkTitul" cp>
        <?=kot_i::img('logo/3/90.png')?>
    </div>

    <div fg>
        <div class="ft-logo">
            <b class="<?=$nH?>-logo-title-aim w-bld">Kot</b>
            <span>admin</span>
        </div>
        <div class="ft-logo-v">v1.5.2152</div>
        <a @click="link('logout')">logout</a>
    </div>

</div>