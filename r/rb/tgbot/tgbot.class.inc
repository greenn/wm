<?#0.5.1

_rb::reg('tgbot', array(
	'nc' => array(
		'base' => 'tgb'
	),
));

class rb_tgbot extends rb {


	static function data_path($subPath){
		$path = cur_iq('dirIq').'/tgbot';
		if ($subPath) {
			$path .= '/'.(is_array($subPath) ? join('/', $subPath) : $subPath);
		}
		return $path;
	}

	static function data_get($subPath, $prop = false){
		$path = static::data_path($subPath);
		$data = jsonFile_get_data($path);
		if ($prop) {
			return _prop($data, $prop);
		}
		return $data;
	}
	static function data_set($subPath, $data){
		$path = static::data_path($subPath);
		jsonFile_put_data($path, $data);
	}
	static function data_update($subPath, $update){
		$data = static::data_get($subPath);
		$newData = $data ? array_replace($data, $update) : $update;
		static::data_set($subPath, $newData);
	}
	static function data_delete($subPath){
		$path = static::data_path($subPath);
		if (is_file($path)) {
			unlink($path);
		}
	}


	static function info($prop = false){
		return static::data_get("tgbot.json", $prop);
	}
	static function info_update($data){
		static::data_update("tgbot.json", $data);
	}


	static function userInfo($uid, $prop = false){
		return static::data_get("users/$uid.json", $prop);
	}
	static function userInfo_update($uid, $update){
		static::data_update("users/$uid.json", $update);
	}


	static function url($uri, $data = array()){
		$token = pro('tg-bot', 'token');
		$url = "https://api.telegram.org/bot{$token}/$uri";
		if ($data) {
			$url .= '?'. http_build_query($data);
		}
		return $url;
	}




	static function post($uri, $post = array()){

		$url = static::url($uri);

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		if ($post) {
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
		}
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$response = static::curl_response($curl);
		curl_close($curl);
		return $response;
	}

	static function get($uri, $data = array()){
		$url = static::url($uri, $data);
		d($url);
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$response = static::curl_response($curl);
		curl_close($curl);
		return $response;
	}

	static function curl_response($curl){
		$responseJson = curl_exec($curl);
		$response = json_decode($responseJson, true);
		return $response;
	}


	//static function sendMessage(){}


}

include_once rb_tgbot::path('tgbot_response.class.inc');
include_once rb_tgbot::path('tgbot_info.class.inc');