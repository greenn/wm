<?#1.2.0
d_(3);
_addphp('mysql/mysql_i');
d_(4);
_addphp('mysql/mysql_error');
d_(5);
_addphp('mysql/mysql_has_db');
d_(6);
_addphp('mysql/mysql_create_db');

d_(7);

function mysql_verify(){ //install|setup|verify|

	mysql_i(true); //подключение к базе с настройками по умолчанию
	//if ($error = mysql_error()) dx($error, mysql_conf());

	if ($error = mysql_error()) {
		//case: подключение к базе данных не прошло
		//d_($error, mysql_conf());

		$host = mysql_conf('db_host');
		$user = mysql_conf('user_name');
		$pass = mysql_conf('user_pass');

		//step: проверям подключение к mysql с указанным пользователем
		$Mysql = mysql_i(array($host, $user, $pass));

		if (!mysql_error()) {
			//case: подключение к mysql произошло
			//step: создаём базу данных

			$db = mysql_conf('db_name');
			//d_('mysql_has_db', $db, mysql_has_db($db));

			mysql_create_db($db);

			d_(mysql_has_db($db));

		}

	}

}


//mysql_install( mysql_conf() );
//mysql_install_db( mysql_conf('db_name') );