<?
$Self = _kot::self();
$n = $Self::nc();
$nC = $Self::nc('content');

$Self::req_css('kot-app');
$Self::req_js('app');

$Self::req_vue('sys-msg');
_kot::req_vue('app-side');
_kot::req_vue('app-head');

_kot::req_vue('ui', 'lay/lay-section', array(), 'lay-section'); //mbd kot('ui', 'req_vue_name', 'lay-section');

?>

<div r hmp100 class="<?=$n?>" :class="ncApp">

    <sys-msg></sys-msg>

    <?//<popup></popup>?>

    <aside a="lt" hmp100 o1 class="<?=$n?>-side sep-h">
        <div class="sep-v"></div>

        <app-side @onToggle="minSide = $event"></app-side>
    </aside>

    <div fxc hmp100 class="<?=$n?>-main-w">

        <header o1 class="<?=$n?>-head sep-h">
            <div class="sep-v"></div>

            <app-head></app-head>

        </header>

        <div class="sep-v"></div>

        <main fxc  fg o1 class="<?=$n?>-content sep-h">

            <div fxr>
                <lay-section class="-half -od s-content" size="titul-1">
                    <template v-slot:headline>
                        <i class="material-icons">assistant</i>
                        Общие сведения
                    </template>
                    <template v-slot:cmd>
                        cmd
                    </template>
                    <template v-slot:modal>
                        modal
                    </template>
                    <template v-slot:default>
                        content
                    </template>
                </lay-section>

                <div class="sep-h"></div>

                <lay-section class="-half -o2 s-content" size="titul-1"
                    :headline="'~headline'"
                    :modal="[]"
                >
                    block 2
                </lay-section>

            </div>

            <div class="sep-v"></div>

            <div fg>
                <lay-section hp100>
                    hp100
                </lay-section>
            </div>
        </main>

    </div>







</div>