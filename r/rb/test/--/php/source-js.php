<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';


switch (real_gi_key(0)) {
	case '1': _rt::req_js(1, 'app', 'app');; break;
	case '2': _rt::req_js(1000, 'elegant', array('plugins/chart.min.js')); break;
	case '3': js::req(-1, false, '/js/lodash/4.17.21/lodash.min.js'); break;
	//case '4': js::req(-1, false, array('console.log(1)')); break;
	case '4': js::req(-1, false, false, 'console.log(1)'); break;
	case '5': rt('blank', 'req_js', 'blank'); break;
	case '6': rt('blank', 'req_js', 'blank', 'jsx', false); break;
	case '7': rp('blank', 'req_js', 'blank', true, false); break;
	case '8': js::req(-10, false, array('rb', 'vue', 'tpl', array('vue-init', 'js.inc'), array('app' => '_App'))); break;
}

$jsData = js::html_export();
echo '<plaintext>', var_export($jsData);

if (0 && 'eg') {


	js::req(-1, false, array('rp', 'user', 'js_var'));
	js::req(-1, false, false, rp('user', 'js_var'));

}