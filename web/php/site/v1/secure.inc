<?

$noAccess = !isMe;
$warnAccess = !isLocalhost;
//$warnAccess = isLocalhost;

$ctx = array_replace(array(
	'button-note' => '',
	'note' => ''
), (array)@$ctx);

$bNote = $ctx['button-note'] ? " ({$ctx['button-note']})" : '';
$note = $ctx['note'];

if ($noAccess) die('access denied');
if ($warnAccess) {
	print '<form method="post"><button type="submit" name="submit">Run'.$bNote.'</button>'.$note.'</form>';
	if (!$_POST) exit; //else dx($_POST);
}