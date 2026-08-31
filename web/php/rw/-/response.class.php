<?#0.1

class rw_response {


	static function url_response($url, $set = false) { //api_response|json_response|
		static $cached = array();
		$set = set($set === true ? array('cache' => true) : $set);

		if ($set->cache && isset($cached[$url])) {
			return $cached[$url];
		}


		if ($set->curl){
			_needphp('htmlByUrl', 'json');
			if (!is_array($options = $set->curl_opt)) $options = array();
			if ($set->post) {
				$options['post'] = $set->post;
			}
			$re = htmlByUrl($url, $options, true);
			$response = $re['response']['html'];
			$data = jsonTryDecode($response);
			d($re, $response, $data);
		} else {
			$json = file_get_contents($url);
			$data = json_decode($json, true);
		}

		if ($set->cache) {
			$cached[$url] = $data;
		}

		return $data;
	}


}