<?#0.3.1
/*
	site/rp/system/api/log/last-pid
*/

$Self = self_rp();
$logData = $Self::getSessionLog(false, false);

end($logData);
$last_pid = key($logData);

x('apiHandlerResult', array(
	'pid' => $last_pid
));