<?#3.17.0

//_needphp('prop')

function sendMail($mail, $message = array('OK'), $headers = array(), $subject = null, $set = null){
	$res = array();

	if (!is_array($set)) $set = array();


	$encode = prop($set, 'encode', false);
	//$encode = isset($set['encode']) ? $set['encode'] : false;


	if (is_array($mail)) {
		$mailStack = array();
		foreach ($mail as $item) {
			if (!empty($item)) {
				$mailStack []= $item;
			}
		}
		$mail = $mailStack;
	}

	$to = is_array($mail) ? join(',', $mail) : $mail;


	$subject = !$subject ? 'server-mail: test-mail-sending '. date("Y-m-d H:i:s", time()) : $subject;

	if ($encode) {
		$encodingPreferences = prop($set, 'encodingPreferences', array(
			'input-charset' => mb_detect_encoding($subject),
			'output-charset' => "$encode",
			//'scheme' => 'B', #B|Q
			//'line-length' => 76, #76|996
			//'line-break-chars' => '\r\n', #\r\n|\n
		));

		$encodedSubject = @iconv_mime_encode('Subject', $subject, $encodingPreferences);
		$encodedSubject = substr($encodedSubject, strlen('Subject: '));
		$subject = $encodedSubject;

		$res['subject_encoding'] = $encodingPreferences;
		$res['subject_encoding_error'] = error_get_last();
	}


	$message = (string) $message;

	if ($encode) {
		$messageEncoding = mb_detect_encoding($message);
		$encodedMessage = @iconv($messageEncoding, "$encode//IGNORE", $message);
		$message = $encodedMessage;

		$res['message_encoding'] = $messageEncoding;
		$res['message_encoding_error'] = error_get_last();
	}

	$charset = $encode ?  $encode : mb_internal_encoding();

	$fromHost = prop($set, 'fromHost', prop($set, /*L*/'from', hostName));
	$From = prop($set, 'email-from', $fromHost.'@'.'phpmail.http'.SSL);
	$ReplyTo = prop($set, 'email-reply', prop($set, 'replyTo', 'web'.'@'.hostName));

	$headers = array_replace(array(
		'MIME-Version' => '1.0', 

		//'Content-type' => 'text/html; charset=iso-8859-1',
		//'Content-type' => "text/html; charset='utf-8'",
		'Content-type' => "text/html; charset=$charset",
		//'Content-type' => "multipart/alternative; boundary=". $mime_boundary_header,

		'From' => $From,
		'Reply-To' => $ReplyTo,
		'X-Mailer' => 'PHP/'. phpversion(),

		//'To' => 'Mary <mary@example.com>, Kelly <kelly@example.com>',
		//'From' => 'Mail Server <birthday@example.com>',
		//'Cc' => 'birthdayarchive@example.com',
		//'Bcc' => 'birthdaycheck@example.com',

		//"Content-Transfer-Encoding" => "8bit".
		
	), !is_array($headers) ? ( !empty($headers) ? array($headers) : array() ) : $headers);

	$headersStack = array();
	foreach ($headers as $name => $value) {
		$headersStack []= sprintf('%s: %s', $name, $value);
	}
	$headers = join("\r\n", $headersStack);



	$res['OK'] = mail($to, $subject, $message, $headers);
	$res['encode'] = $encode;
	$res['subject'] = $subject;
	$res['message'] = $message;


	return $res;
}