<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');
_needphp('dirToArray.class');
$Self = _rb::self();

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
), SITE_CACHE);
?>
<? include $Self::path('css/vue-of-man.css.inc') /*
	bounce
	fade
	slide-fade - отезжает право в новая выезжает слева
 */?>

<? include $Self::path('css/vue-transitions-css.css.inc') /*
	fade-x уезжает вправо
	fade-y - уезжает вниз
	fade - исчезает //oo tech
	flip-x - сворачивается вправо
	roll-in-left - улетает крутясь влево
	rotate - закручивается против часовой и исчезает
	scale-in - немного проваливается внутрь и исчезает
	shrink - невмного увеличивается вперёд и исчезает
	swirl - закручивается и улетает внутрб
	tilt-in - улетает наверх вправо и исчезает
*/?>

<? include $Self::path('css/travis-almand.css.inc') /*
	fade
	next - улетает влево + чуть вниз
	rotate
	slide - тоже что next
 */?>