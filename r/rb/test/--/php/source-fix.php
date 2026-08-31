<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';


_rb::req_js(-5, 'vue', 'env?v3');


$jsData = js::html_export();
echo '<plaintext>', var_export($jsData);
