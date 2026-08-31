<?#0.1.1
/*
	site/rp/system/api/log/uid
*/
$res = array();
$api = x('apiHandlerPar');
$Self = self_rp();

$logData = null;
$res['request'] = $api->data;



$uid = $api->data_prop('uid', $api->tokenPage);
if (!$uid) {
	$Acc = cur_user();
	$uid = $Acc->uid;
}

$accInfo = acc_users::info($uid);

end($accInfo['sessions']);
$lastSid = key($accInfo['sessions']);

$LogData = $Self::api_prop(array('get', 'log/sid', array(
	'sid' => $lastSid
)), 'log');


$res['uid'] = $uid;
$res['sid'] = $lastSid;
$res['log'] = $LogData;


//$Acc

x('apiHandlerResult', $res);