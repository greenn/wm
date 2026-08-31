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
$Self::req_js('app'.$appOpt);

$Self::req_vue('sys-msg');
_kot::req_vue('app-side');
_kot::req_vue('app-head');


_kot::req_vue('ui', 'lay/lay-section', array(), 'lay-section'); //mbd kot('ui', 'req_vue_name', 'lay-section');

?>

<div hp100 r class="<?=$n?>" :class="ncApp">

    <sys-msg></sys-msg>

    <?//<popup></popup>?>

    <aside a="lt" class="<?=$n?>-side sep-h">
        <div class="sep-v"></div>

        <app-side @onToggle="minSide = $event"></app-side>
    </aside>

    <div fxc hp100 class="<?=$n?>-main">

        <header class="<?=$n?>-head sep-h">
            <div class="sep-v"></div>

            <app-head>
                <h1 class="<?=$nC?>-h1 ft-middle">{{ pageTitle }}</h1>
            </app-head>

        </header>

        <div class="sep-v"></div>

        <main fxc hp100 class="<?=$n?>-content sep-h">

	        <? if (0) { ?>

            <lay-section tight>
                <template v-slot:headline>

                </template>
            </lay-section>

            <? } ?>

	        <? if (0) { ?><div>typeof Component: {{ typeof Component }}</div><? } ?>

            <router-view v-slot="{ Component }">

                <? if (0) { ?><div>{{ isAlive }}</div><? } ?>
                <!--<keep-alive>-->
                <!--</keep-alive>-->

                <div hp100 style="background-color: lightcyan">
                    <component :is="Component" />
                </div>

            </router-view>

        </main>
    </div>

</div>