<?#0.1.1

function qhash($data) {
	return hash('adler32', serialize($data));
}