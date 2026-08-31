<?#0.7.1

//rb_tgbot::

class tgbot_response {

	static $pass = '5555';

	static $msgData;
	static $fromData;
	static $chatData;
	static $date;
	static $text;
	static $entities;

	static $userId;
	static $chatId;

	static function apply($reqeust){


		if (_prop($reqeust, 'edited_message')) {
			//sol: не обращаем внимания
			//send iddle
			return;
		}

		static::fetchRequest($reqeust);

		if (!static::verify_user()) return;

		if (!static::verify_access()) return;


		//…


	}
	
	static function fetchRequest($reqeust){

		static::$msgData = _prop($reqeust, 'message');
		if (static::$msgData) {
			static::fetchMessage(static::$msgData);
		}


	}

	static function fetchMessage($msgData){
		static::$fromData = _prop(static::$msgData, 'from');
		static::$chatData = _prop($msgData, 'chat');
		static::$date = _prop($msgData, 'date');
		static::$text = _prop($msgData, 'text');
		static::$entities = _prop($msgData, 'entities');

		static::$userId = _prop(static::$fromData, 'id');
		static::$chatId = _prop(static::$chatData, 'id');
	}

	static function hasUser(){
		return !!rb_tgbot::userInfo(static::$userId);
	}

	static function get($prop){
		return rb_tgbot::userInfo(static::$userId, $prop);
	}

	static function update($prop, $value = null){
		if (func_num_args() === 1) {
			$update = func_get_arg(0);
		} else {
			$update = array($prop => $value);
		}
		rb_tgbot::userInfo_update(static::$userId, $update);
	}


	static function message($text){
		rb_tgbot::post('sendMessage', array(
			'chat_id' => static::$chatId,
			'text' => join(newline, (array)$text)
		));
	}
	
	
	static function verify_user(){
		if (!static::$userId) return false;

		if (!static::hasUser()) {
			$user = array(
				'authorized' => false,
				'pass-awaiting' => false,
				'pass-try' => 3,
			);
			$user['info'] = static::$fromData;
			$user['chats'] = array();
			$user['chats'][static::$chatId] = static::$chatData;

			static::update($user);
		}

		return true;
	}

	static function verify_access(){
		if (static::get('authorized')) return true;

		if (!static::get('pass-awaiting')) {
			static::pass_request();
		} else {
			if (static::get('pass-try') > 0) {
				static::pass_verify() ? static::pass_success() : static::pass_unsuccess();
			} else {
				static::pass_restricted();
			}
		}
	}

	static function pass_verify(){

		return static::$pass === static::$text;

	}

	static function pass_request(){

		static::message(array(
			"🤖 подключение на внутренний телеграм бот сайта spbgss.ru",
			//"Введите пароль (попыток: $N)"
			'',
			"Введите пароль"
		));

		static::update('pass-awaiting', true);

	}

	static function pass_unsuccess(){

		$N = static::get('pass-try');
		static::update('pass-try', --$N);

		static::message(array(
			"🤖 Пароль неверный",
			"Осталось попыток: $N",
		));
	}


	static function pass_restricted(){
		static::message(array(
			"🤖 доступ закрыт",
		));
	}


	static function pass_success(){
		static::message(array(
			"🤖 Добро пожаловать",
		));

		static::update(array(
			'authorized' => true,
			'pass-awaiting' => false,
		));

		tgbot_info::subscribe(static::$chatId);

	}


}
