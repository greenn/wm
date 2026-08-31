<?
$Self = _kot::self();
$nHS = $Self::nc('HS'); //head-snippet
$Self::req_css('app-user');
?>

<div fxr fxi="fe" class="<?=$nHS?>" :class="{ '-load': load }">

    <div class="<?=$nHS?>-ava">
        <div class="<?=$nHS?>-ava-pic">
            <template v-if="load">
                <img :src="spinnerPic" />
            </template>
            <template v-else>
                <img :src="info['ava-pic-src']" />
            </template>
        </div>
    </div>

    <div fg class="<?=$nHS?>-info">
        <div class="<?=$nHS?>-name ft-user-name">{{ info['nickname'] }}</div>
        <div class="<?=$nHS?>-type ft-user-type">{{ info['user-type'] }}</div>
    </div>

</div>