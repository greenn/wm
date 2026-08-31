<?#0.3.1

_needphp('dirToArray.class');


class tgbot_info {

	static function initial_data(){
		$info = array(
			'subscribers' => array()
		);

		return $info;
	}

	static function get($prop = false){
		if (!func_num_args()) {
			$info = rb_tgbot::info();
			if (!$info) $info = static::initial_data();
			return $info;
		} else {
			return rb_tgbot::info($prop);
		}
	}

	static function update($data){
		rb_tgbot::info_update($data);
	}


	static function subscribe($chatId) {
		$info = static::get();

		if (!in_array($chatId, $info['subscribers'])) {
			$info['subscribers'] []= $chatId;
		}

		static::update($info);
	}


	static $test = !true;


	static function sendMessage($chatId, $text){
		rb_tgbot::post('sendMessage', array(
			'chat_id' => $chatId,
			'text' => join(newline, (array)$text)
		));
	}

	static function notify($msg){
		$subscribersProperty = 'subscribers';
		if (static::$test) {
			$subscribersProperty = 'test-subscribers';
		}

		foreach (static::get($subscribersProperty) as $chatId) {
			static::sendMessage($chatId, $msg);
		}

	}
}

tgbot_info::$test = isMe;