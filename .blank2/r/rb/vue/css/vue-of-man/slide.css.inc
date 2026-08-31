


/* Анимации появления и исчезновения могут иметь    */
/* различные продолжительности и функции плавности. */
.slide-fade-enter-active {
    transition: all 0.9s ease-out;
}

.slide-fade-leave-active {
    /*transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);*/
    transition: all 0.5s <?=cbn('easeOutCubic')?>;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateX(20px);
    opacity: 0;
}
