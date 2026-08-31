.blink {
	animation: blink-animation 1s steps(4, start) infinite;
}
@keyframes blink-animation {
	to {
		visibility: hidden;
	}
}
@-webkit-keyframes blink-animation {
	to {
		visibility: hidden;
	}
}