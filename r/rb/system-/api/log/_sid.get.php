<?#0.2.0
/*
	site/rp/system/api/log/sid
	site/rp/system/api/log/sid/anj5k7lgtmr6k9r9r1cc2bf2i1?pid=1592738508
*/
$res = array();
$api = x('apiHandlerPar');
$Self = self_rp();

$sid = $api->data_prop('sid', $api->tokenPage);

$pid = $api->data_prop('pid');
if ($pid === 'last') {
	$pid = $Self::api_prop(array('get', 'log/last-pid'), 'pid');
}

$res['sid'] = $sid;
$logData = $Self::getSessionLogBySid($sid, $pid, 'html');

if ($pid) {
	$res['pid'] = $pid;
	$res['log-data'] = $logData;
} else {
	$res['log'] = $logData;
}


x('apiHandlerResult', $res);