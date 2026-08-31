<?#3.6.1
_needphp('emu/getallheaders');


/* htmlByUrl
	$options
		maxWait {i} - ожидания ответа / CURLOPT_TIMEOUT
		encode {aa|t} - кодирование ответа
			[t=] array('from' => 'windows-1251', 'to' => 'utf-8');
		selfHeaders {b|ao} - добавление своих заголовков
			true - все свои заголовки
			array(false, 'Cache-Control') - все, кроме 'Cache-Control'
			array(true, 'Cache-Control', 'Expires') - из своих только 'Cache-Control' и 'Expires'
		headers {aa} - список дополнительных заголовков
		selfCookies {b|ao} - добавление своих текущих кукисов
			[oo selfHeaders]
			array(false, 'PHPSESSID') - все, кроме 'PHPSESSID'
		cookies {aa} - список дополнительных кукисов
		agent {s} - установка отличного от текущего агента-браузера
		responseHeaders - добавить в результат заголовки ответа (response headers)
		allowRedirects {i} - разрешить N редиректов
		* post {t|aa} - отправки данных методом POST
		** method
		** method_data
		** query {s|a}
		** addTime {t} - добавить в результат время выполнения запроса
            \mb только для extended
				или этот превратить результат в extended [q ak responseHeaders]
		curl - расширить curl-настройки своими

	eg
		url/tool/surf/index.php
		dev/php/files/2018-05/22 1009 [20].php
*/
function htmlByUrl($urlRequest, $options = array(), $extendedResponse = false){
	$response = null;
	//[rb $options with set() -qa/oo на сколько станет лучше]

	#step: Опция максимального ожидания ответа
    $wait = is_numeric(prop($options, 'maxWait')) ? $options['maxWait'] : 2;

    #step: установки кодировки
	//OPT: encode
	$encode = isset($options['encode']);
	if ($encode) {
		if ($options['encode'] === true)
			$encode = array('from' => 'windows-1251', 'to' => 'utf-8');
		else
			$encode = $options['encode'];

		if (!is_array($encode) || !isset($encode['from']) || !isset($encode['to']))
			$encode = false;
	}

	#step: установка дополнительных header'ов
    //OPT: headers, selfHeaders
    $headers = array();
    $addHeaders = array();
    if (isset($options['selfHeaders']) && $options['selfHeaders']) {
        /*[eg
             array('User-Agent') - добавить только User-Agent 
             array(false, 'Cookie') - не включать куки 
        ]*/
        $selfHeaders = true;
        $exceptHeaders = false;

        if (is_array($options['selfHeaders'])) {
            if (isset($options['selfHeaders'][0])) { //case: array(true|false, 'H1', 'H2')
                ($_flag = array_shift($options['selfHeaders']))
                    ? $selfHeaders = $options['selfHeaders'] //case: array(true, 'H1', 'H2')
                    : $exceptHeaders = $options['selfHeaders']; //case: array(false, 'H1', 'H2')
            } else {
                $selfHeaders = $options['selfHeaders'];
            }
        }
        
        foreach (getallheaders() as $name => $value) {
            $setHeader = is_array($selfHeaders) ? in_array($name, $selfHeaders) : true;
            $skipHeader = is_array($exceptHeaders) ? in_array($name, $exceptHeaders) : false;
            if ($setHeader && !$skipHeader) {
                $addHeaders[$name] = $value;
            }
        }
    }
    if (isset($options['headers']) && is_array($options['headers'])) {
        $addHeaders = array_replace($addHeaders, $options['headers']);
    }
    if (count($addHeaders)) {
        foreach ($addHeaders as $name => $value) {
            switch ($name) {
                case 'Cookie': {
                    if (!isset($options['selfCookies'])) {
                        $options['selfCookies'] = true;
                    }
                    /*if (isset($options['cookies'])) {
                        $options['selfCookies'] = $value; //[td parse As String] 
                    }*/
                } break;
                case 'User-Agent': {
                    if (!isset($options['agent'])) {
                        $options['agent'] = $value; //[td handle it]
                    }
                } break;
                default: {
                    $headers[] = "$name: $value";
                }
            }
        }
    }

	#step: установка кукисов
    //OPT: cookies, selfCookies
	$cookies = array();
	$addCookies = array();
    if (isset($options['selfCookies']) && $options['selfCookies']) {
        /*[eg
             array('isMe') - добавить только куку isMe 
             array(false, 'PHPSESSID') - добавить все, кроме PHPSESSID
        ]*/
        $selfCookies = true;
        $exceptCookies = false;

        if (is_array($options['selfCookies'])) {
            if (isset($options['selfCookies'][0])) {
                ($_flag = array_shift($options['selfCookies']))
                    ? $selfCookies = $options['selfCookies']
                    : $exceptCookies = $options['selfCookies'];
            } else {
                $selfCookies = $options['selfCookies'];
            }
        }

        foreach ($_COOKIE as $name => $value) {
            $setCookie = is_array($selfCookies) ? in_array($name, $selfCookies) : true;
            $skipCookie = is_array($exceptCookies) ? in_array($name, $exceptCookies) : false;
            //d($name, $setCookie, $skipCookie);
            if ($setCookie && !$skipCookie) {
                $addCookies[$name] = $value;
            }
        }
    }
    if (isset($options['cookies']) && is_array($options['cookies'])) {
        $addCookies = array_replace($addCookies, $options['cookies']);
    }
    if (count($addCookies)) {
        //dx($addCookies);
        foreach ($addCookies as $name => $value) {
            $cookies[] = "$name=$value";
        }
    }
    $cookies = count($cookies) ? join(';', $cookies) : false;

	#step: установка responseHeaders - добавить в результат заголовки ответа (response headers)
    if ($extendedResponse) {
        $options['responseHeaders'] = true;
    }
    if (!isset($options['responseHeaders'])) $options['responseHeaders'] = false;





	//dx($headers);

	$curlOptions = array(
		CURLOPT_URL => $urlRequest,
		CURLOPT_RETURNTRANSFER => true, // возврат результата передачи в качестве строки из curl_exec() вместо прямого вывода в браузер.

        CURLOPT_HEADER => $options['responseHeaders'], //

        CURLOPT_COOKIE => $cookies,
		    //'fruit=apple;colour=red'
            //[q '; path=/']
		CURLOPT_HTTPHEADER => $headers,
		    /*array(
                'Content-type: text/html; charset=windows-1251'
            )*/


		//CURLOPT_POSTFIELDS => http_build_query($optRequest),
		//CURLOPT_POST => true,

		//CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_USERAGENT => $_SERVER['HTTP_USER_AGENT'],

		//CURLOPT_COOKIE => 'fruit=apple; colour=red',

		//CURLOPT_SSL_VERIFYPEER => false,
		//CURLOPT_SSL_VERIFYHOST => 0,

		CURLOPT_FOLLOWLOCATION => false,
		//CURLOPT_MAXREDIRS => 2,

		CURLOPT_CONNECTTIMEOUT => 1,  //~ CURLOPT_CONNECTTIMEOUT_MS
		CURLOPT_TIMEOUT => $wait, //[def 2]
		//CURLOPT_REFERER => $urlRequest,
		CURLOPT_AUTOREFERER => true,
		CURLOPT_ENCODING => '',
	);


	#step: настройка возможных редиректов
	if (isset($options['allowRedirects']) && $options['allowRedirects']) {
        $curlOptions[CURLOPT_FOLLOWLOCATION] = 1;
	    if (is_integer($options['allowRedirects'])) {
            $curlOptions[CURLOPT_MAXREDIRS] = $options['allowRedirects'];
        }
    }

	#step: установка метода отправки
	/*[ dc
		method
			get?
				convert to query
			delete
		method_data
			CURLOPT_CUSTOMREQUEST
			https://stackoverflow.com/questions/13420952/php-curl-delete-request
	]*/
	if (isset($options['post']) && $options['post']) {
		$curlOptions[CURLOPT_POST] = true;
		if (is_array($options['post'])) {
			$curlOptions[CURLOPT_POSTFIELDS] = http_build_query($options['post']);
		}
	}

	#step: расширение get-параметров для url
	/*[ td
		query add to $urlRequest
			$uri = strtok($urlRequest, '?');
			$query = strtok('?');
	]*/
	if (isset($options['query'])) {}

	if (isset($options['curl'])) {
		$curlOptions = array_replace($curlOptions, $options['curl']);
	}

	//dx($curlOptions, CURLOPT_POSTFIELDS);
	$curl = curl_init();
    curl_setopt_array($curl, $curlOptions);
	$htmlResponse = curl_exec($curl);
	$curlStatus = curl_getinfo($curl);
	$curlError = curl_error($curl);
	curl_close($curl);

    $rawHtmlResponse = $htmlResponse;
    $headersResponse = false;
    $responseHeaders = array();
    if ($options['responseHeaders']) {
        $header_size = $curlStatus['header_size'];
        $headersResponse = substr($htmlResponse, 0, $header_size);
        $htmlResponse = substr($htmlResponse, $header_size);
        if ($headersResponse) {
            //preg_match_all('~^.*$~m', $headersResponse, $matches); // https://regex101.com/r/cUs53Y/1/
            //$headers_data = $matches[0];
            $headers_data = explode("\n", $headersResponse);
            foreach ($headers_data as $header_data) {
                if ($header_str = rtrim($header_data)) {
                    if (strpos($header_str, ':') !== false) {
                        list($name, $value) = explode(':', $header_str, 2);
                    } else {
                        $name = $header_str;
                        $value = true;
                    }
                    $responseHeaders[$name] = is_string($value) ? ltrim($value) : $value;
                }
            }
        }
    }

	$decodedData = false;
	if ($encode) {
		//$status['content_type'] = "text/html; charset=windows-1251";
		$decodedData = mb_convert_encoding($htmlResponse, $encode['to'], $encode['from']);
		///$data = utf8_encode($data);
	}

	$html = $decodedData ? $decodedData : $htmlResponse;




	if ($extendedResponse) {
	    $curlConstants = get_defined_constants(true);
        $curlNames = $curlConstants['curl'];
	    $curlNamedOptions = array();
	    foreach ($curlOptions as $opt_id => $opt_val) {
            $opt_name = array_search($opt_id, $curlNames);
	        $curlNamedOptions[$opt_name] = $opt_val;
        }
        $extendedResponse = array(
            'status' => $curlStatus, //curl_getinfo()
            'error' => $curlError, //curl_error()
            'request' => array(
                'set' => $options,
                'opts' => $curlNamedOptions,
                'headers' => array(
                    'stack' => @$headers,
                    'set' => @$selfHeaders,
                    'except' => @$exceptHeaders,
                ),
                'cookies' => array(
                    'stack' => @$addCookies,
                    'set' => @$selfCookies,
                    'except' => @$exceptCookies,
                ),
            ),
            'response' => array(
                'headers_str' => $headersResponse,
                'headers' => $responseHeaders,
                'html' => $html,
                'raw' => $rawHtmlResponse,
            )
        );
    }

	return !$extendedResponse ? $html : $extendedResponse;
}



/*


*/