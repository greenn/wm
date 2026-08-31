
@keyframes spin {
	from { transform: rotate(0deg); }
	to { transform: rotate(360deg); }
}

@keyframes spin1 {
	0% { transform: rotate(0deg); }
	25% { transform: rotate(90deg); }
	50% { transform: rotate(180deg); }
	75% { transform: rotate(270deg); }
	100% { transform: rotate(360deg); }
}

.spin {
    animation: spin 1s ease-in-out infinite;
}
.spin-rev {
    animation: spin 1s ease-in-out infinite reverse;
}

.spin1 {
    animation: spin 1s ease-in-out infinite;
}
.spin1-rev {
    animation: spin 1s ease-in-out infinite reverse;
}

<?/*
more
	https://blog.hubspot.com/website/css-animation-examples
	https://www.webtopic.com/css-spin-animations-examples/

.rotating-image {
	animation: spinning 5s infinite ease-in-out;
	animation: spinning 5s infinite ease-in-out;
}
*/?>