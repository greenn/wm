<?
$Self = _kot::self();
$nP = $Self::nc('Pp');
$Self::req_css('app');
?>
<transition name="fade">
    <div f="rtlb" class="<?=$nP?>" v-if="visible">

        <div avh class="<?=$nP?>-c">
            <h2 class="ft-high <?=$nP?>-headline">{{ headline }}</h2>
            <div class="ft-small <?=$nP?>-msg" v-html="msg"></div>

            <div fxr="fe" class="<?=$nP?>-cmd">
                <ui-button w-button class="<?=$nP?>-cancel" @click="cancel.click">
                    {{ cancel.title }}
                </ui-button>
                <ui-button r-button class="<?=$nP?>-submit" @click="submit.click">
                    {{ submit.title }}
                </ui-button>
            </div>

        </div>
    </div>
</transition>