<?


class _prod {

	static function get_csv($path, $dir) {
		if ($path === true) {
			$path = self::find_csv($dir);
		}
		$csv = self::csv_convert($path);
		return $csv;
	}

	static function find_csv($dir) {
		$files = dirToArray($dir); //dx($files);
		foreach ($files as $name => $path) {
			if (!is_string($path)) continue;
			$ext = pathinfo($path, PATHINFO_EXTENSION);
			$is_csv = $ext === 'csv';
			if ($is_csv) return $path;
		}
		return false;
	}

	static function csv_convert($path){
		if (!is_file($path)) return false;

		$table = array();
		$reader = fopen($path, "r");
		while ($buffer = fgetcsv($reader, 0, ';')) {
			$lastNotEmptyCell = 0;
			$row = array();
			foreach ($buffer as $index => $cell) {
				$cell = iconv("Windows-1251", "UTF-8", $cell);
				if (!empty($cell)) $lastNotEmptyCell = $index;
				$row []= $cell;
			}
			array_splice($row, $lastNotEmptyCell + 1);
			$table []= $row;
		}
		return $table;
	}

	static function thumb($dir = false, $listName = false, $prodUrl = false){
		$emptyThumb = x('urlProdDir').'/img/thumbs/empty.png';

		if ($dir || $listName) {
			$pathList = array(
				$dir.'/thumb.png',
				$dir."/$listName.png",
				ROOT.x('urlProdDir')."/img/thumbs/$listName.png",
			);

			foreach ($pathList as $path) {
				if (is_file($path)) {
					return fileUrl($path);
				}
			}
		}


		if ($prodUrl) {
			$r = r(__FILE__, R_BASE);
			$utlThumb = $r->jd('pagelist', $prodUrl, 'thumb');
			if ($utlThumb) return $utlThumb;
		}

		return $emptyThumb;
		//return false;
	}

	static function data($prodPage){
		$prodData = false;
		$r = r(__FILE__, R_BASE);
		//d($r);
		$prodJson = $r->jd('pagelist', $prodPage, 'data');
		if ($prodJson) {
			$prodData = $r->jd($prodJson);
		}
		return $prodData;
	}

}