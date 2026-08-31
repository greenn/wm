<?
$Self = _kot::self();
$n = $Self::nc();
$nC = $Self::nc('content');

$_ctx = $Self::tempCtx(array(
	'baseUri' => '',
));


$baseUri = $_ctx['baseUri'];

$appOpt = '';
if ($baseUri) $appOpt = "?base=".urlencode($baseUri);

$Self::req_css('kot-app');

$Self::req_js(1, 'kot-app-env');

$Self::req_js(3, 'kot-app'.$appOpt);

$Self::req_vue('sys-msg');
_kot::req_vue('app-side');
_kot::req_vue('msg-pane');



_kot::req_vue('app-head');
_kot::req_vue('app-head', 'head-cmd');

_kot::req_vue('login', 'login-page');


_kot::req_vue('ui', 'lay/lay-section', array(), 'lay-section'); //mbd kot('ui', 'req_vue_name', 'lay-section');

?>
<div>
    <div ff zi1000 style="opacity: 1; background-color: <?='white'?>"
         :no="appBusy ? null<?//показываем, класса no нету?> : ''<?//скрываем, класс no есть?>"
    >
        <div avh>app: {{ appBusy }}</div>
    </div>
    <template v-if="!isLogined">
        <login-page></login-page>
    </template>
    <template v-else>
        <div hp100 r class="<?=$n?>" :class="ncApp">

            <sys-msg></sys-msg>

            <?//<popup></popup>?>

            <aside fxc a="lt" class="<?=$n?>-side sep-h">
                <div class="sep-v"></div>

                <app-side @onToggle="minSide = $event"></app-side>

                <div class="sep-v"></div>

                <msg-pane></msg-pane>

            </aside>

            <div fxc hp100 class="<?=$n?>-main">

                <header class="<?=$n?>-head sep-h">
                    <div class="sep-v"></div>

                    <app-head :has-sub-title="pageSubTitle">
                        <template v-slot:default >
                            <h1 class="<?=$nC?>-h1 ft-middle">{{ pageTitle }}</h1>
                            <h4 class="<?=$nC?>-h4 ft-small" v-if="pageSubTitle" v-html="pageSubTitle"></h4>
                        </template>

                        <template v-slot:cmd>
                            <router-view name="cmd" v-slot="{ Component, route }">
                                <?=$Self::tpl('app-tpl/keep-alive-component')?>
                            </router-view>
                        </template>
                    </app-head>

                </header>

                <div class="sep-v"></div>

                <main fxc hp100 class="<?=$n?>-content sep-h">

                    <router-view v-slot="{ Component, route }">

                        <template v-if="route.meta.clearOutput">
                            <?=$Self::tpl('app-tpl/keep-alive-component')?>
                        </template>
                        <template v-else>
                            <lay-section hp100>
                                <?=$Self::tpl('app-tpl/keep-alive-component')?>
                            </lay-section>
                        </template>

                        <div class="sep-v"></div>

                    </router-view>

                </main>
            </div>

        </div>
    </template>

</div>