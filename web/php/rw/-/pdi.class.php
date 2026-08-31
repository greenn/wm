<?#0.1

class rw_pdi {


	/* pd_ */
	//[!!create] static $pd_%data = '%data dataPath'; //%data dataPath
	/*[!!create] static function pd_%data_def() { return array(); } //данные по умолчанию для pd-данных */
	static function pd_data($pdName, $rebuild = false){
		static $stack = array();
		$vpd = "pd_$pdName"; //DataPath variable

		$data = isset($stack[$pdName]) ? $stack[$pdName] : false;

		if (!$data || $rebuild) {
			$stack[$pdName] = static::data_get(static::$$vpd);
		}

		return $stack[$pdName];
	}
	static function pd_data_save($pdName, $data, $rebuild = false){
		$vpd = "pd_$pdName"; //DataPath variable
		static::data_save(static::$$vpd, $data);
		if ($rebuild) static::pd_data($pdName, true);
	}

	static function pd_data_def($vpd){ //can be extended
		return array();
	}
	static function pd_data_get($pdName, $rebuild = false){
		$data = static::pd_data($pdName, $rebuild);

		if (!$data) {
			$mpd = "static::pd_{$pdName}_def"; //defDataMethod - метода получения данных по умолчанию
			$defData = is_callable($mpd) ? call_user_func($mpd) : static::pd_data_def($pdName);
			static::pd_data_save($pdName, $defData);
			$data = static::pd_data($pdName, true);
		}

		return $data;
	}
	static function pd_data_prop($pdName, $propName, $otherwise = null) {
		$data = static::pd_data($pdName);

		if (is_array($propName)) {
			$slicePath = $propName;
			return dataPath($slicePath, $data, $otherwise);
		} else {
			return prop($data, $propName, $otherwise);
		}
	}


	/* pdi_ */
	//[!!create] static $pdi_%data = '%dataItem pathPattern'; //%dataItem pathPattern
	/*[!!create] static function $pdi_%dataItem_def() { return array(); } //данные по умолчанию для pd-данных */
	/*-\pdi_data_path [!!create] static function $pdi_%dataItem_path() { ... } //путь до файла-данных */

	//получение данных для pdi_Элемента
	static function pdi_data($pdiName, $pdiFileName){
		$pdiPath = static::pdi_data_path($pdiName, $pdiFileName); //dataPath
		$data = static::data_get($pdiPath);
		return $data;
	}

	//метод (по умолчанию) получения пути для PathDataItem
	static function pdi_data_path($pdiName, $pdiFileName){
		$pdn = static::${"pdi_$pdiName"}; //DataItemPatternPath

		/*if (is_callable($pdiPathMethod = "static::pdi_{$pdiName}_path")) {
			$pdiPath = call_user_func($pdiPathMethod, $pdiName, $pdiFileName, $pdn);
		} else {}*/

		$pdiPath = strtr($pdn, array(
			'%filename' => $pdiFileName
		));
		return $pdiPath;
	}

	static function pdi_data_save($pdiName, $pdiFileName, $data){
		$pdiPath = static::pdi_data_path($pdiName, $pdiFileName); //dataPath
		static::data_save($pdiPath, $data);
	}

	//0
	static function pdi_data_def($vpd){ //can be extended
		return array();
	}

	static function pdi_data_get($pdiName, $pdiFileName){
		$data = static::pdi_data($pdiName, $pdiFileName);
		return $data;
	}
	//01
	static function pdi_data_prop($pdiName, $pdiFileName, $propName, $otherwise = null) {
		$data = static::pdi_data($pdiName, $pdiFileName);

		if (is_array($propName)) {
			$slicePath = $propName;
			return dataPath($slicePath, $data, $otherwise);
		} else {
			return prop($data, $propName, $otherwise);
		}
	}

	//id
	static function pdi_dataList($pdiName){
		$dataList = array();
		$pdl = false; //DataListPath
		if (isset(static::${"pdl_$pdiName"})) {
			$pdl = static::${"pdl_$pdiName"};
		} else {
			$pdn = static::${"pdi_$pdiName"}; //DataItemPatternPath
			$pdl = strtr($pdn, array(
				'%filename' => ''
			));
		}

		$dirPath = static::data_path(array($pdl, ''));

		if (is_dir($dirPath)) {
			$fileList = dirToArray($dirPath, 1, false);
			foreach ($fileList as $fileName => $filePath) {
				$invoiceId = basename($fileName, '.'.pathinfo($fileName, PATHINFO_EXTENSION));
				$dataList[$invoiceId] =  static::pdi_data_get($pdiName, $invoiceId);
			}
		}

		return $dataList;

	}



}