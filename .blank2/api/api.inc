<?#0.1.1

function _response($data) {
	return hash('adler32', serialize($data));
}