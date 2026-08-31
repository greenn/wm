<?
//https://v3.ru.vuejs.org/ru/guide/component-slots.html

include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
    'strLess'
);

$Self = _rb::self();
//$relDir = pathLess(dirname(__FILE__), $Self->path('/'));
$relDir = $Self::relDir();// d($relDir);

$Self::req_css("$relDir/styles");
$Self::req_js("$relDir/app");
rp('ui', 'req', 'link-p');

//$Self::vue_req('v-cmpt', "$relDir/cmpt");



ob_start();
####################################################
?>

<section>
    <button @click="addBlueRoute">addBlueRoute</button>
    <button @click="removeBlueRoute">removeBlueRoute</button>
    <button @click="addBlueRoute2">addBlueRoute2</button>
    <ul>
        <li><link-p href="red" ></link-p></li>
        <li><link-p href="green"></link-p></li>
        <li><link-p href="blue"></link-p></li>
    </ul>
</section>

    <router-view v-slot="{ Component }">
        <main>
            <keep-alive>
                <component :is="Component" />
            </keep-alive>
        </main>
    </router-view>




    <section red>
        <router-view name="RCmpt"></router-view>
    </section>
    <section green>
        <slot name="green"></slot>
    </section>
    <section blue>
        <slot name="blue"></slot>
    </section>





<?###################################################
$body = ob_get_clean();
$body = "<div id=\"app\">$body</div>";


print rb_tpl('page', 'page', array(
	//'body' => $Self::vue_test($body, true),
	'body' => $body,
	'webkit' => array(
		'vue-env'
    ),
));
