@keyframes moveUpDown {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(1px);
    }
}

.a-UpDown {
    animation: moveUpDown 1s ease-in-out infinite;
}