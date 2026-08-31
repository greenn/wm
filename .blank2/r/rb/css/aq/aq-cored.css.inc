<?//? ?>

DL[dbg] DT:before,
DL[dbg] DT:after {
	content: '--';
}

DL[dbg] {
	position: relative;
	margin-top: 5px;
	margin-bottom: 5px;
}
DL[dbg]:after {
	content: '';
	display: block; height: 1px;
	bottom: 0; left: 0; right: 0;
	background-color: darkslategrey;
}
DL[dbg] DD {
	margin-left: 5px;
	margin-right: 5px;
}