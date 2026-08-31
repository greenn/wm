<?
//https://v3.ru.vuejs.org/ru/guide/transitions-enterleave.html#css-%D0%B0%D0%BD%D0%B8%D0%BC%D0%B0%D1%86%D0%B8%D0%B8

include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp(
    'strLess'
);

$Self = _rb::self();
$relDir = $Self::relDir();// d($relDir);

$Self::req_css("$relDir/styles");
$Self::req_js("$relDir/app");

ob_start();
####################################################
?>

    <link
            href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.0/animate.min.css"
            rel="stylesheet"
            type="text/css"
    />

    <div id="demo">
        <button @click="slide = !slide">
            [slide-fade] Переключить отображение
        </button>

        <transition name="slide-fade">
            <p v-if="slide">привет</p>
        </transition>


        <button @click="bounce = !bounce">[bounce]Переключить отображение</button>
        <transition name="bounce">
            <p v-if="bounce">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris facilisis
                enim libero, at lacinia diam fermentum id. Pellentesque habitant morbi
                tristique senectus et netus.
            </p>
        </transition>



        <button @click="animate = !animate">
            [animate.css/tada/bounceOutRight]Переключить отображение
        </button>

        <transition
                name="custom-classes-transition"
                enter-active-class="animate__animated animate__tada"
                leave-active-class="animate__animated animate__bounceOutRight"
        >
            <p v-if="animate">привет</p>
        </transition>
        
    </div>


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
