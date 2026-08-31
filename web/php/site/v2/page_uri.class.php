<?#4.0.1 - site uri
//lb pid

_needphp(
	'fq/merge/join_values'//,
	//'strLess'
);

/*
	доступ к составляюшим Uri
	так же определяет принадлежность к текущим страницам ($this->$isPid + $this->name)
*/
class page_uri {
	var $src;        	# clothes/1/2?titul  //переданная строка
	//var $curUri;        # /clothes/1/2
	var $parts;         # [clothes, 1, 2]
	var $depth;         # 3

	var $name; 			# имя страницы (идентификатор страницы)
	var $isPid = false; //bet hasPid
	var $isMod = false; # true //bet hasMod
	var $Page; 			# инстанас станицы site_page

	var $subUri;        # 1/2
	var $subParts;      # [1, 2]
	var $subCount;      # 2
	var $pageUri;       # /clothes | //$curUri

	var $query;       	# titul

	var $pagesClass;  //extends of _pages

	function __construct($uri, $pagesClass) {
		$this->pagesClass = $pagesClass;

		if (is_array($uri)) {
			$uri = join('/', $uri);
		}

		$this->src = $uri;

		if (strpos($uri, '?') !== false) {
			$pos = strpos($uri, '?');
			$this->query = substr($uri, $pos + 1);
			$uri = substr($uri, 0, $pos);
		}

		$_uri = ltrim($uri, '/'); //рабочая строка
		$this->name = $_uri;
		if ($this->name === '') {
			$this->name = data_opt('base_pid');
		}
		$this->pageUri = '/'.$_uri;

		$this->parts = explode('/', $_uri);
		$this->depth = count($this->parts);

		$sub_chunks = [];

		//dx($_uri, $this->pagesClass::hasPid($_uri));
		if(0) _pages::hasPid();
		$this->isPid = $this->pagesClass::hasPid($this->name);

		if (!$this->isPid) {
			//case: ищем страницу отсекая части с конца
			$sub_chunks = $this->sub_explore();
		}

		$this->subParts = $sub_chunks;
		$this->subCount = count($sub_chunks);
		$this->subUri = join('/', $sub_chunks);
		//dx($this);

		if ($this->isPid) {
			$this->Page = $this->pagesClass::get($this->name);
		}
	}

	//получение суб-частей, после найденогол pid-url
	private function sub_explore(){
		$sub_chunks = [];
		$parts = $this->parts;
		//step: проходимся по пути в сконца, осматривая совпадения
		//dx('sub_explore', $parts, $this->name);

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

		$isMod = false;

		if ($this->pagesClass::hasPid($pid)) {
			//dx($pid, $isMod = _pageDataFor($this->pagesClass, $pid, 'is-mod'));
			$isMod = _pageDataFor($this->pagesClass, $pid, 'is-mod');
		}

		if ($isMod) {
			$pid = $this->pagesClass::getUriPid($pid);
			$this->name = $pid;
			$this->isPid = true;
			$this->isMod = $isMod;
			$this->pageUri = _page($pid, 'link');
		}
		return $isMod;
	}

	//ak makeUri
	function uri($parts = array(), $curUri = false){
		if (is_string($parts)) $parts = array($parts);
		array_unshift($parts, $curUri ? $this->curUri : $this->pageUri);
		return join('/', $parts);
	}

	//[uu] получить часть
	//l4/bet uri_get
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


	//150
	function data(...$prop){
		if(0) _pages::data();
		return $this->pagesClass::data($this->name, $prop);
	}

}