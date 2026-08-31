<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';


switch (real_gi_key(0)) {
	case '1': _rp::req_vue('blank', 'blank'); break;
	case '2': _rp::vue_req('cmpt', 'blank', 'blank'); break;
	case '3': rb('blank', 'req_vue', 'blank'); break;
	case '4': rb('blank', 'vue_req', 'blank'); break;
	case '4p': rp('blank', 'vue_req', 'blank'); break;
	case '4pf': rp('blank', 'vue_req', 'cmpt', 'blank', array('tab' => 1), array(11)); break;
	case '5': _rp::req_vue('blank'); break;
	case '6': _rp::vue_req('blank'); break;
	case '7': _rp::vue_req('sidebar', 'sidebar'); break;
	case '8': _rp::vue_req('sidebar'); break;
	//case '3': rb('blank', 'req_vue', 'blank', true, false); break;
}

$vueData = vue::html_export();
d(vue::$_stack);
echo '<plaintext>', var_export($vueData);