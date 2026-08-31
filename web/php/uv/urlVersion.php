<?#3.0.1

//_needphp('s'); //dbg

_needphp('htmlByUrl');
_needphp('isMobile');
_needphp('file/file_backup');
_needphp('file/ensureDir');

define('UV_CONTENT', 0);
define('UV_ETAG', 1);
define('UV_RAW', 2);
define('UV_HEADERS', 3);

class urlVersion {

    static $db = array();

    static $db_path = false;


    static function encode($url){
        return preg_replace_callback('~[\s]~', 'urlVersion::encode_callback', $url);
    }
    private static function encode_callback($match){
        return rawurlencode($match[0]);
    }
    static function decode($url){
        return rawurldecode($url);
    }

    private static function has($url){
        return isset(static::$db[$url]);
    }

    private static function get($url, $vType = false){
        $v = '';
        if (static::has($url)) {

            $data = static::$db[$url];
            $ver = $data['ver'];
            if ($ver) {
                $def = $ver[UV_CONTENT];
                if ($vType == true) $vType = UV_ETAG;
                /*[im
                    почему при true - UV_ETAG ?
                    версия пл контенту как-то понадёжнее, в любо случае
                    $v = $ver[UV_CONTENT] ? $ver[UV_CONTENT] : $def;
                    я понял
                    наверное true, это именно использование eTag
                    so по умолчанию поставил false
                        rp _\pro my\WCMS\dm\php\urlVersion\get
                ]*/
	            $v = (is_integer($vType) && isset($ver[$vType])) ? $ver[$vType] : $def;

                if (!'учитываем-доп-версию-от-модификаторов')
                    //скорее всего, это должны делать сами файлы, добавляй в свой url-параметр,
                        //по котором будет высичтывается uv как для другого url
                if (isMe || isMobile) {
                    $v .= '-';
                    if (isMobile) $v .= 'm';
                    if (isMe) $v .= 'i';
                }

            } //else case: url was wrong, ~ 'ver' property is empty
        }
        return $v;
    }

    private static function data($url){
        $data = false;
        if (static::has($url)) {
            $data = static::$db[$url];
        }
        return $data;
    }

    private static function add($uri, $data){
        //$info = array('v' => $data['ver'][UV_CONTENT]);
        //$data = array_replace($ctx, $info);
        return static::$db[$uri] = $data;
    }


    private static $db_rec_delimiter = '  ';


    static function db_connect($db_path = false){ //db_load|db_sync|db_connect|db_dat
		//d($db_path, func_get_args());
        //[ check session ]
        if (!is_file($db_path)) {
			ensureFileDir($db_path);
			//dx($dir = dirname($db_path), is_dir($dir), $db_path);
			touch($db_path);
		}
		//dx($db_path, is_file($db_path));
        if (is_file($db_path)) {
            static::$db_path = $db_path;
            static::db_fetch();
        }
    }

	static function db_fetch(){
		$db_path = static::$db_path;
		static::$db = array();
		// https://stackoverflow.com/questions/3004041/how-to-replace-a-particular-line-in-a-text-file-using-php?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa
		// read_all / get_all / fetch_all
		if ($file = fopen($db_path, "r")) {
			while (($line = fgets($file)) !== false) {
				//d($line);
				if (substr_count($line, static::$db_rec_delimiter) > 0) { //case: пропуск пустых или простых строк
					list($path, $data) = explode('  ', $line, 3);
					$path = static::decode($path);
					$data = json_decode($data, true);
					static::add($path, $data);
				}

			}
			fclose($file);
		}

	}

    static function db_clear($reset_data = false){
        file_backup(static::$db_path, dirname(static::$db_path).DS.'b');
        file_put_contents(static::$db_path, "");
	    clearstatcache(); //https://stackoverflow.com/questions/3747982/php-filesize-reporting-old-size
        //$file = fopen(static::$db_path, 'w'); fclose($file);

	    if ($reset_data) {
		    static::$db = array();
	    }
    }


	static function db_rebuild() {
    	$realPath = static::$db_path;
		$tmpPath = $realPath.'.tmp';

		touch($tmpPath);
		static::$db_path = $tmpPath;


    	$list = static::$db;
    	$new_list = array();

		foreach ($list as $url => $conf) {

			$newConf = urlVersion::assign($url);
			/* em
				файл будет обновляться новый
				а данные будут писаться поверх старых,
				также если при вызове calc, будет вызываться uv,
					то он получит старые данные, либо уже про-обновлённые
			*/

			//d($url, $conf, $newConf);
			$new_list[$url] = $newConf;
		}

		# step: заменяем старый файл обновлённым
		rename($tmpPath, $realPath);
		static::$db_path = $realPath;
		# step: обновляем данные в static:$db новыми данными
		static::db_fetch();
		return $new_list;
	}


	//получение соответствия url и данных о его версии
    static function match($url, $vType = false){
	    //s_push('uv', array('match', $url));
    	if (!static::has($url)) {
		    //s_push('uv', array('!match = save', $url));
            //static::assign($url);

		    $data = static::preCalc($url); //временная версия (для первого раза)
            static::save($url, $data);
        }
        return static::get($url, $vType);
    }

    //ku 0
    static function info($url){
        if (!static::has($url)) {
            static::assign($url);
        }
        return static::data($url);
    }


    static function save($uri, $data){
	    //s_push('uv', array('save', $uri));

	    # step: подготавливаем данные для сохранения
	        //убираем не требуемые данные для сохранения
        $recdata = $data;
        if (isset($recdata['verdata'])) unset($recdata['verdata']);
        if (isset($recdata['calcTime'])) unset($recdata['calcTime']);
        $rec = static::encode($uri) . static::$db_rec_delimiter . json_encode($recdata);

        # step: проверяем первая ли будет запись
	    if (!!0) {
	        $stat = stat(static::$db_path);
            d(
                $uri,
                static::$db_path,
                $content = file_get_contents(static::$db_path),
                $stat['size'],
                filesize(static::$db_path),
                strlen($content)
            );
        }

	    //exit;
	    $isFirstRec = !filesize(static::$db_path);
	    //$isFirstRec = !stat(static::$db_path)['size'];
	    //$isFirstRec = file_get_contents(static::$db_path) === '';

	    $mode = 'w'; //case: для первой записи
	    if (!$isFirstRec) {
		    //case: для всех последующих записей
	        $rec = PHP_EOL . $rec;
			$mode = 'a';
        }

        $file = fopen(static::$db_path, $mode);

	    //rewind($db); // fseek($fd, 0, SEEK_SET)
	    //d($mode, $rec, file_get_contents(static::$db_path), s('uv'));
	    /*[
			pr страннoe поведением, некорректной записи первой строки,
			откуда-то появляется данные от уже стёртой предыдущей информации
	        если же сделать exit до fwrite, то нету лишних данных,
	        если после, то в это месте они (лишние данные) уже показываюься

	        не удалось воспроизвести здесь
	            web/test/php/pr/fwrite/index.php

	        наверное что-то связанное с потоками

	        про лишние данные и суть проблемы
	            в файле было 6 строк
	            файл очищался ::db_clear()
	            и начиналась запись с флагом w/a
	            и в момент записи в уже пустом файле
	            появлялись предыдущие две строки от старых данных
	            и в зависимости от флага (w/a) данные либо дописывались в конец этих двух строк,
	            либо писались поверх, оставляя излшики данных
		]*/
		//exit;
	    fwrite($file, $rec);
	    //exit;
	    fclose($file);
	    //if ($mode === 'a') exit;

	    clearstatcache();


	    //dx($rec, file_get_contents(static::$db_path)); //return;

        return static::add($uri, $data);
    }

    //учёт (использование / привязка) нового url
    static function assign($uri){
        //d(static::$db_path);
        if (!static::$db_path) return null; //0 mb-er
        //if (isset(static::$db[$uri])) return null;

        $url = $uri;
        if ($uri[0] === '/') {
            $url = hostUrl.$uri;
        }
        $data = static::calc($url);
        //d($uri, $data);

        //if ($uri === '/web/test/web/js/cmpt/app-lay/r/api/decl?tp') dx($data);
        /*
            потому что в результатае есть обращение к uv
                а так как данные стираются, то он выдаёт T-версию,
                а если не стирать, то он будет выдвать старую версию
        */

        //if (0)
        if (!isset($data['error'])) {
            static::save($uri, $data);
        } else {
            //d($data);
        }

        return $data;
    }

    /* [td]
        генерить версию с разными параметрами
        обычную
        m isMobile
        i isMe
        mi isMobile + isMe
        ==
            передавать параметром
                для каких версий может использоваться
                calc($url, 'm'|'mi')
    */
    static function calc($url, $dbg = 0){
        $data = array();
        $set = array(
            'selfHeaders' => true, //array(false, 'Cache-Control'),
            'selfCookies' => array(false, 'PHPSESSID'),
            'allowRedirects' => 2,
            'responseHeaders' => true
        );

        if ($dbg) {
            notch_start('htmlByUrl');
            $page = htmlByUrl($url, $set, true);
            dx('htmlByUrl:', $url, $page, notch_end());
        }

        notch_start('htmlByUrl');
        $page = htmlByUrl($url, $set, true);
        $data['calcTime'] = notch_end();


        $ver = array();
        $verdata = array();
        if (!$page['error']) {
            $response = $page['response'];
            $headers = $page['response']['headers'];
            $verdata[UV_CONTENT] = preg_replace('~[\r]~m', '', $response['html']);
                //убираем возврат каретки (\r chr(13)), чтобы не разнить версии на Unix и Windows
            $verdata[UV_ETAG] = isset($headers['Etag']) ? $headers['Etag'] : '';
            $verdata[UV_RAW] = $response['raw'];
            $verdata[UV_HEADERS] = $response['headers_str'];
            $ver[UV_CONTENT]    = 'C'.hash('adler32', $verdata[UV_CONTENT]);
            $ver[UV_ETAG]       = $verdata[UV_ETAG] ? 'E'.hash('adler32', $verdata[UV_ETAG]) : '';
            $ver[UV_RAW]        = 'R'.hash('adler32', $verdata[UV_RAW]);
            $ver[UV_HEADERS]    = 'H'.hash('adler32', $verdata[UV_HEADERS]);
        }
        $data['ver'] = $ver;
        $data['verdata'] = $verdata;
        //$data['utime'] = microtime(true);;

        if ($page['error']) $data['error'] = $page['error'];
        return $data;
    }

	//временные версии url - для первого раза
	//без просчёта
	static function preCalc($url){
		$data = array();
		$data['ver'] = merge_keys_value(
			array(UV_CONTENT, UV_ETAG, UV_RAW, UV_HEADERS),
			//'T'.hash('adler32', microtime(true))
			'T'.hash('adler32', $url)
		);
		//dx($url, UV_CONTENT, UV_ETAG, UV_RAW, UV_HEADERS);

    	return $data;
	}

}

//urlVersion::db_connect(INC.'/uv/sd/web.uv');
//urlVersion::db_connect(PHP.'/uv/web.uv');