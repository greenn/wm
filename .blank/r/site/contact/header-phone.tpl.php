<?
$Self = _site::self();
$nPH = $Self::nc('PH');

$Self::req_css('phone');

//$_ctx = $Self::tempCtx(array('var' => ''));
//$var = $_ctx['var'];
?>

<div tc class="<?=$nPH?>">



    <div fxr2="c" fxi2="c" class="<?=$nPH?>-c">

        <div class="<?=$nPH?>-col <?=$nPH?>-title ft-phone-header-title">
            Звоните:
        </div>

        <div class="<?=$nPH?>-col <?=$nPH?>-phone ft-phone-header">
            <a cp ibfx tdn
               @click="clickFake($event)"
            ><?=_pro('mobile', 'format-1-html')?></a>
        </div>

        <div class="<?=$nPH?>-col <?=$nPH?>-phone-icon whatsapp -first">
            <a cp ibfx
               @click="clickFake($event)"
            ><?=_i::img('icon/whatsapp/whatsapp_logo_icon_147205.png')?></a>
        </div>

        <div class="<?=$nPH?>-col <?=$nPH?>-phone-icon telegram">
            <a cp ibfx
               @click="clickFake($event)"
            ><?=_i::img('icon/telegram/telegram_logo_circle_icon_134012.png')?></a>
        </div>
    </div>


    <div txc class="<?=$nPH?>-title-sub ft-phone-header-title-sub"  <?=_aos('fade-up', 'dly:500')?>>
        <?=_pro('slogan')?>
    </div>


</div>