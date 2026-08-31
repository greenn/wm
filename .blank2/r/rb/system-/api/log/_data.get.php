<?#0.2.2
/*
	site/rp/system/api/log/data
	site/rp/system/api/log/data?pid=last
	site/rp/system/api/log/data/last
*/

$api = x('apiHandlerPar');
$Self = self_rp();

$res = array();
$res['request'] = $api->data;
$res['request+'] = $api->data();

$pid = $api->data_prop('pid', $api->tokenPage);
if ($pid === 'last') {
	$pid = $Self::api_prop(array('get', 'log/last-pid'), 'pid');
}
//$asHtml = $api->data_prop('unwrap') == 'html';

$logData = $Self::getSessionLog($pid, 'html');

if ($pid) {
	$res['pid'] = $pid;
	$res['log-data'] = $logData;
} else {
	$res['log'] = $logData;
}

x('apiHandlerResult', $res);