<?#0.4.0
/*
	накопитель использования web/js/w файлов
	[oo] web/test/php/needjs/wjs.php
	[oo] web/test/php/needjs/wjs-d.php
*/

_needphp(
	'stacker',
	'fileUrl',
	'useTemplate',
	'json',
	'file',
	'fq/is/is_includable',
	'useTemplate',
	'url.class'
);

define('WJS_URI_PATTERN', '/web/js/w/%s.js.php');
define('WJS_GEN_URI', '/web/js/g/wjs/%s.js'); //'/js/wg/wjs.%s.js'
define('WJS_INFO_PATH', WEB.'/js/g/wjs/info.json');
define('WJS_BACKUP_DIR', WEB.'/js/g/wjs/bin');
define('WJS_BACKUP_DEL', true);

class wjs extends stacker {
	static $ROOT;

	static $hash = array();
	static $order = array();
	static $_stack = null;

	static function build_conf(/*args*/){
		$ctx = func_get_args();
		return $ctx;
	}

	//формирование аргументов при вызове функции через метод {::each_with($callback, $res, $extra)}
	// т.е. те аргумент, которые буду приходить в $callback
	static function each_callback_args(&$res, $data, $hash, $extra, $callback){
		$name = null; //название w.js метода
		$ctx = null; //возможный контекст для формирования w.js метода
		if (is_array($data)) {
			if (isset($data[0])) $name = $data[0];
			if (isset($data[1])) $ctx = $data[1];
		} else {
			$name = $data;
		}

		return array(&$res, $hash, $name, $ctx, $extra);
	}


	static function path($name, $uriPattern = WJS_URI_PATTERN){
		return sprintf(static::$ROOT.$uriPattern, is_string($name) ? $name : '');
	}

	static function uri($name, $uriPattern = WJS_URI_PATTERN){
		return sprintf($uriPattern, is_string($name) ? $name : '');
	}

	static function genName(){ //reqReqHash|getReqName|genName - ak reqDataHash
		$list = static::getFilesVer();
		$reqDataHash = static::hash($nm = join('', $list));
		//d('::genName', $list, $nm, $reqDataHash);
		return $reqDataHash;
	}


	//получение идентифакторы wjs-файлов, без его какой-либо обработки (по времени последнего изменения)
	static function getFilesVer(){
		//d('wjs::getFilesVer');
		return static::each_with('static::getFilesVer_cb', array());
	}
	static function getFilesVer_cb(&$res, $hash, $name, $ctx){
		$path = static::path($name);

		if (!is_file($path)) d('wrong wjs name', $name, $path);
		//d($path, $hash, fileatime($path));

		if ('fileatime() меняется при каждом запросе') { //иногда (на некоторых серверах) почему-то так бывает
			$res[$hash] = hash('adler32', file_get_contents($path));
		} else {
			$res[$hash] = fileatime($path); //иногда
		}
	}
	/*static function genName(){
		$list = array();
		foreach (static::get_stack() as $hash => $conf) {
			$name = is_array($conf) ? $conf[0] : $conf;
			$path = static::path($name);
			$list []= fileatime($path);
		}
		$name = static::hash( join('', $list) );
		return $name;
	}*/

	//static $internalDependenciesVerify = false; //просмотр внутренних зависимостей
	static function getFilesUri(){ //getReqFiles|getFilesPath|
		//dx('wjs-data', static::$order, static::$hash);

		$verifiedFiles = array(); //просмотренные файлы на наличие зависимостей
		$deepLim = 5; //dbg-ограничение
		$deepLevel = 1;
		do {
			$prevFilesCount = count($verifiedFiles); //предыдущее кол-во задействованных файлов
			//step: получение списка требуемых файлов
			$list = static::each_with('static::getFilesUri_cb', array());

			//step: просмотр внутренних зависимостей
			foreach ($list as $fileUri) {
				$filePath = static::$ROOT.$fileUri;
				//step: если файл не проверялся, и он исполняемый
				//  т.е. в нём могут быть зависимости
				if (!isset($verifiedFiles[$filePath]) && is_includable(static::$ROOT.$fileUri)) {
					//step: используем файл как темплейт
					//  он выполнится в своём пространстве, но триггер зависимостей сможет запустится
					useTemplate($filePath);
				}
				$verifiedFiles[$filePath] = true;
			}
			//d($deepLevel, $prevFilesCount, count($list), $verifiedFiles, $list);
			//$deepLevel++; //dbg
		} while (
			$prevFilesCount !== count($list)
			//&& ($deepLim > $deepLevel)
		);

		//dx($verifiedFiles, $list, $deepLevel);

		//[2j] step: повтороное составление списка запрашиваемых файлов, уже с учётом внутренних зависимостей
		//static::$_stack = null;
		//$list = static::each_with('static::getFilesUri_cb', array());
		//== не требуется, т.к. в $list уже имеется этот список

		return $list;
	}
	static function getFilesUri_cb(&$res, $hash, $name, $ctx){
		$uri = static::uri($name);

		if ($ctx) {
			$uri = url::q_ext($uri, "ctx=$hash");
		}

		$res[$hash] = $uri;
	}


	static function genContent(){
		$res = array(
			'content' => '',
			'filesId' => array()
		);
		$files = static::each_with('static::genContent_cb');
		$contents = array();
		foreach ($files as $file) {
			$contents []= $file['content'];
			$res['filesId'] []= $file['id'];
		}
		//$contents []= '//\\';
		$res['content'] = '//wjs: '.join(', ', $res['filesId']).str_repeat(RN, 2);
		$res['content'] .= implode(str_repeat(RN, 4), $contents);
		$res['content'] .= str_repeat(RN, 2).'//\\';

		return $res;
	}
	static function genContent_cb(&$res, $hash, $name, $ctx){
		$path = static::path($name);
		//$fileId = "$name-$hash";
		$contentId = $name.($ctx ? "-$hash" : '');
		$fileContent = "//$contentId".RN;
		$fileContent .= $tplRes = useTemplate($path, $ctx);
		//d($path, $ctx, $tplRes);
		$res[$hash] = array(
			'content' => $fileContent, //1
			'path' => $path,
			'id' => $contentId, //1
			'name' => $name,
			'ctx' => $ctx,
			'hash' => $hash,
		);
	}

	private static function genSave($id, $content){
		$path = static::path($id, WJS_GEN_URI);
		save_file($path, $content);
		return $path;
	}

	private static function genDel($id, $backup = WJS_BACKUP_DEL){
		$path = static::path($id, WJS_GEN_URI);

		if ($backup) {
			$b_dir = WJS_BACKUP_DIR; //dirname($path).'/bin/';
			if (!is_dir($b_dir)) mkdir($b_dir, 0755, true);
			rename($path, $b_dir.'/'.basename($path));
		} else {
			unlink($path);
		}
	}

	static function genProcess(){
		$name = static::genName();
		$data = static::genContent();
		//dx($name, $data);

		static::infoAdd($name, $data['filesId']);

		static::genSave($name, $data['content']);

		return $name;
	}


	static $info = null;
	static function infoGet(){
		if (!is_array($data = static::$info)) {
			$path = WJS_INFO_PATH;
			if (is_file($path)) {
				$content = file_get_contents($path);
				$data = json_decode($content, true);
			}

			if (!is_array($data)) { //cases: учёт ошибки-json файла и отсутствия файла
				$data = array();
			}

			static::$info = $data;
		}

		return static::$info;
	}
	private static function infoSave(){
		$path = WJS_INFO_PATH;
		$data = static::$info;
		$content = jsonEncode($data);
		save_file($path, $content);
	}

	//удаляем
	private static function infoDelSame($filesId){
		//if (static::$info)
		foreach (static::$info as $name => $data) {
			if (static::infoIsSame($data, $filesId)) {
				//d('infoDelSame', $data, $filesId);
				unset(static::$info[$name]);
				static::genDel($name);
			}
		}
	}
	//сравневние двух списков на содержание одинаковых элементов
	private static function infoIsSame($data1, $data2){
        $same = false;
        if (count($data1) === count($data2)) {
            $diff = array_diff($data1, $data2);
            $same = empty($diff);
        }
        return $same;
	}

	//добавляем запись о новом gen-файле с именем $nameId содержащий в сeбе wjs-елементы $filesId
	private static function infoAdd($nameId, $filesId){
		static::infoGet();
		static::infoDelSame($filesId);
		static::$info[$nameId] = $filesId;
		static::infoSave();
	}


	static function export($genProcess = true){
		$res = array();

		$res['files'] = static::getFilesUri();


		if ($genProcess) {
			if ($res['files']) {
				$resName = static::genName();
				$resPath = static::path($resName, WJS_GEN_URI);

				if (!is_file($resPath)) {
					//d('gen-file', $resPath);
					static::genProcess();
				}

				$res['gen'] = static::uri($resName, WJS_GEN_URI);
			} else {
				$res['gen'] = false;
			}

		}
		//else
			//[#r2] - mode 2 / debug mode - без генерации компилицонного файла



		return $res;
	}

}
wjs::$ROOT = dirname(WEB);

/*
	plan
		получаем id req-данных
		если нетак такого gen файла, то создаём новый
		желательно удалив, предыдущий с таким же списком входящих элементов
				[#s1]
			это сложнее,
				возмодно проще удалять всё что есть, и просто генерить заново
			при разработке, чтобы не удалять постоянно и не копить,
				желателен вариант хранения резульата не в файле, а в сессии
					и каждый раз её обновлять?
			тогда вариант при разработке
				[#r2] иметь вывод списка файлов, а не один, ak export

		[#s1] хранить инфо в отдельном файле
			info.json
			'req-data-hash' => [fn|fn-ctxHash, …]
				проверить схожесть по == value-q && each-value==verify-value
*/