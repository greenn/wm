<?/* 0.2
    ~ .b/ya-metrika-2
    oo test/yandex/metrika.php

    проверка счётчика
        ?_ym_status-check=$code&_ym_lang=ru / https://i.imgur.com/v4sGw6F.png
*/
$Self = _rb::self();
$_ctx = $Self::tempCtx(array(
	'code' => '',
));
$code = $_ctx['code'];
?>
<script type="text/javascript">
    (function(m, e, t, r, i, k, a) {
        m[i] = m[i] || function() {
            (m[i].a = m[i].a || []).push(arguments)
        };
        m[i].l = 1 * new Date();
        for (var j = 0; j < document.scripts.length; j++) {
            if (document.scripts[j].src === r) {
                return;
            }
        }
        k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
    })
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(<?=$code?>, "init", {
        clickmap: true,
        trackLinks: true,
        accurateTrackBounce: true,
        webvisor: true,
        //ecommerce: "dataLayer"
    });
</script>
