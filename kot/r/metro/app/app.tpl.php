<?
$Self = _kot::self();
$n = $Self::nc();
$nC = $Self::nc('content');

//_rb::req_css('lay', 'flex');
//_rb::req_css('page', 'css/aq');
$Self::req_css('app');
$Self::req_js('app');

//$_tx = $Self::lang();
//$_ctx = $Self::tempCtx(array('icon' => '☺'));
//$icon = $_ctx['icon'];

$Self::req_vue('sys-msg');
$Self::req_vue('popup');

//_kot::req_vue('side-pane', 'side-pane', 'side-pane');
_kot::req_vue('side-pane');
_kot::req_vue('side-head');

_kot::req_vue('ui', 'busy-area');


_kot::req_vue('ui');
//_kot::req_vue('targets');
_kot::req_vue(-1, 'targets', 'targets.v2', array(), 'targets');
_kot::req_vue(-1, 'messagings');
_kot::req_vue(-1, 'tpl_messagings');

_kot::req_vue(-1, 'test', 'tests');
_kot::req_vue(-1, 'tool', 'tools');

?>

<div r class="<?=$n?>" :class="ncApp">


    <div a="lth" class="<?=$n?>-side" :init-pane="true">
        <div a="ltr" class="<?=$n?>-side-head">
            2
            <side-head @toggle-click="toggleSide"></side-head>
        </div>

        <div osy class="<?=$n?>-side-pane">
            <side-pane></side-pane>
        </div>

    </div>

    <div class="<?=$n?>-main" :class="{ '-busy': busy }">
        <? if (0) { ?><targets v-if="iqs.targets"></targets><? } ?>

        <ui></ui>

        <targets></targets>
	    <messagings></messagings>
	    <tpl_messagings></tpl_messagings>

        <tests></tests>
        <tools></tools>

        <!--<keep-alive>
            <component v-for="(iqComponent, index) in iq_list" :key="index" :is="iqComponent" />
        </keep-alive>-->

        <router-view v-slot="{ Component }">

                <div r class="<?=$n?>-main-c ft-text">
                    <!--<dbg>
                        <button @click="busy = !busy">setBusy</button>
                    </dbg>-->

                    <h1 class="<?=$nC?>-h1 ft-middle">{{ pageTitle }}</h1>

                    <busy-area a="ltrb" :busy="busy" @extra-close="busy = false"></busy-area>
                    <!--<keep-alive>-->
                        <component :is="Component" />
                    <!--</keep-alive>-->

                </div>

        </router-view>
    </div>

    <div f="tlrb" class="<?=$n?>-overlay" :class="{ '-on': overlay }"></div>

    <sys-msg></sys-msg>

    <popup></popup>

</div>