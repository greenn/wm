
<?//                fade                    ?>

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}

.fade-enter {
    opacity: 0;
}

.fade-leave-to {
    opacity: 1;
}

<?//                fade2                    ?>
.fade2-enter-active,
.fade2-leave-active {
    transition: height 0.5s ease; /* Подставьте свои настройки анимации */
}
.fade2-enter, .fade2-leave-to /* .fade-leave-active в <2.1.8 */ {
    height: 0;
    overflow: hidden;
}



<?//                slide-down              ?>

.slide-down-enter-active,
.slide-down-leave-active {
    transition: max-height 0.5s;
}

.slide-down-enter,
.slide-down-leave-to {
    max-height: 0;
    overflow: hidden;
}

<?//                expand              ?>

.expand-enter-active,
.expand-leave-active {
    transition: height 0.5s;
}

.expand-enter,
.expand-leave-to {
    height: 0;
    overflow: hidden;
}


<?//                slide              ?>
    .slide-enter-active,
    .slide-leave-active {
        transition: transform 0.5s;
    }

    .slide-enter,
    .slide-leave-to {
        transform: translateX(100%);
    }


<?//                slide-fade              ?>
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


<?//                fade-modal              ?>
.fade-modal-enter-active {
    animation: bounce-in 0.4s;
}
.fade-modal-leave-active {
    animation: bounce-in 0.2s reverse;
}

@keyframes fade-modal-in {
    0% {
        transform: scale(0);
    }
    50% {
        transform: scale(1.15);
    }
    100% {
        transform: scale(1);
    }
}

<?//                content-section              ?>

.scale-enter-active,
.scale-leave-active {
    transform-origin: top;
    transition: transform 0.3s ease-in-out;
}

.scale-enter-to,
.scale-leave-from {
    transform: scaleY(1);
}

.scale-enter-from,
.scale-leave-to {
    transform: scaleY(0);
}

.slidedown-enter-active,
.slidedown-leave-active {
    transition: max-height 0.5s ease-in-out;
}

.slidedown-enter-to,
.slidedown-leave-from {
    overflow: hidden;
    max-height: 1000px;
}

.slidedown-enter-from,
.slidedown-leave-to {
    overflow: hidden;
    max-height: 0;
}