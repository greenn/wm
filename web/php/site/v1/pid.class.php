<?#3.0.9 - page uri

_needphp(
	'fq/merge/join_values'//,
	//'strLess'
);

/*
	доступ к составляюшим Uri
	так же определяет принадлежность к текущим страницам ($pid->name)
*/
class pid {
	var $src;        	# clothes/1/2?titul
	var $curUri;        # /clothes/1/2
	var $parts;         # [clothes, 1, 2]
	var $depth;         # 3

	var $name; //ak pid # clothes - имя страницы или pid (идентификатор страницы)
	var $isPid = false; //bet hasPid
	var $isMod = false; # true //bet hasMod

	var $subUri;        # 1/2
	var $subParts;      # [1, 2]
	var $subLevel;      # 2
	var $pageUri;       # /clothes | $curUri

	var $query;       	# titul


	function __construct($uri) {
		if (is_array($uri)) {
			$uri = join('/', $uri);
		}

		$this->src = $uri;

		if (strpos($uri, '?')) { // mb 0 \ !== false
			$pos = strpos($uri, '?');
			$this->query = substr($uri, $pos + 1);
			$uri = substr($uri, 0, $pos);
		}

		$_uri = ltrim($uri, '/'); //рабочая строка
		$this->name = $_uri;

		$this->curUri = '/'.$_uri;
		$this->pageUri = $this->curUri;

		$this->parts = explode('/', $_uri);
		$this->depth = count($this->parts);

		$sub_chunks = [];

		//dx($_uri, _page($_uri));
		if (_page($_uri)) {
			//dx(_page($_uri));
			//case: найдена страница по запрашиваемому полному uri
			$this->name = $_uri;
			$this->isPid = true;
		} else {
			//case: ищем страницу отсекая части с конца
			$sub_chunks = $this->sub_explore();
		}

		$this->subParts = $sub_chunks;
		$this->subLevel = count($sub_chunks);
		$this->subUri = join('/', $sub_chunks);
		//dx($this);
	}

	//получение суб-частей, после найденогол pid-url
	private function sub_explore(){
		$sub_chunks = [];
		$parts = $this->parts;
		//step: проходимся по пути в сконца, осматривая совпадения
		do {
			$chunks_pid = join('/', $parts);
			$catched_pid = $this->mod_verify($chunks_pid);

			if (!$catched_pid) {
				$sub_chunks []= array_pop($parts);
			}
		} while ($parts && !$catched_pid);

		$sub_chunks = array_reverse($sub_chunks);
		return $sub_chunks;
	}


	private function mod_verify($pid){
		$isMod = _page($pid, 'is-mod');

		//d($isPage = _page($pid), $isMod);
		if ($isMod) {
			$pid = _page::getUriPid($pid);
			$this->isMod = $isMod;
			$this->isPid = true;
			$this->name = $pid;
			$this->baseUri = _page($pid, 'link');
		}
		return $isMod;
	}

	function uri($parts = array(), $curUri = false){
		if (is_string($parts)) $parts = array($parts);
		array_unshift($parts, $curUri ? $this->curUri : $this->pageUri);
		return join('/', $parts);
	}

	//[uu] получить часть
	function get_uri($num = true, $subUri = false, $join = false){
		//if (func_num_args() === 1 && is_bool($num)) $subUri = $num;
		$uriData = $subUri ? $this->subParts : $this->parts;

		if (is_number($num) && $num < 0) { //spec case: отсечения последних частей
			$parts = array_slice($uriData, 0, $num);
			return join('/', $parts);
		}

		if ($num === true) { //spec case: короткий true параметр
			return join('/', $uriData);
		}

		if ($join) { //получить связку частей
			return $this->get_part_($uriData, 0, $num, true);
		}

		return prop($uriData, $num - 1); //case: возвращение позиции из данных
	}



	//получить n-частей с начала
	function uri_get($num = true, $join = true){
		return $this->get_uri($num, false, $join);
	}

	function uri_get_sub($num = true, $join = false){
		return $this->get_uri($num, true, $join);
	}


	//менеджер получение набора частей от uri
	function get_part_($_stack, $startNum, $qy = 1, $join = true){
		$parts = array();
		$startIndex = $startNum - 1;
		$limIndex = $qy === true ? count($_stack) : $startIndex + $qy;

		for ($i = $startIndex; $i < $limIndex; $i++) {
			$part = prop($_stack, $i);
			if ($part) $parts []= $part;
		}

		return $join ? join('/', $parts) : $parts;
	}

	//получить набор частей заданного uri
	function get_part($startNum, $qy = 1, $join = true){
		return $this->get_part_($this->parts, $startNum, $qy, $join);
	}

	//получить набор субчастей (следующих после заданного uri)
	function get_sub_part($startNum, $qy = 1, $join = true){
		return $this->get_part_($this->subParts, $startNum, $qy, $join);
	}

}