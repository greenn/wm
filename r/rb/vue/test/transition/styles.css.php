<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('headers');

$Self = _rb::self();
$nCS = $Self::nc('cmpt-slot');

headers('css', 'utf8', 'nosniff', etag::ctx(
    //pcss_etag_ctx('transition'),
    etag::extra(),
    __FILE__
));
?>

#app {
   background-color: lightcyan;
}

/*  slide  */

/* Анимации появления и исчезновения могут иметь    */
/* различные продолжительности и функции плавности. */
.slide-fade-enter-active {
    transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
    transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateX(20px);
    opacity: 0;
}

/*  bounce  */

.bounce-enter-active {
    animation: bounce-in 0.5s;
}
.bounce-leave-active {
    animation: bounce-in 0.5s reverse;
}
@keyframes bounce-in {
    0% {
        transform: scale(0);
    }
    50% {
        transform: scale(1.25);
    }
    100% {
        transform: scale(1);
    }
}