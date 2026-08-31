<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

rt('blank', 'req_js', 10, 'blank');
_rp::vue_req('cmpt', 1000, 'blank', 'blank');
js::req(-1, false, '/js/lodash/4.17.21/lodash.min.js');

//dx(_source::html_export(), js::$_stack);
dx(_source::html_ruled_export());