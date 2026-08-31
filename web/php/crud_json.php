<?#0.5.2
//eg внизу

_needphp('response', 'scheme');
_needphp('api', 'file', 'json', 'w', 'dataPath', 'isAssoc');
_needphp('img/pathImage', 'strLess'/*pathLess*/);
_needphp('file/file_backup');

class crud_json extends responseData {  //crud_json_scheme
    private $data;
    //private
        var $scheme; //tt для локальных тестов

    /*  //[ff]
        хранить в сессии удалённые данные
        private $tmp = array(
            'deleted' => array()
        );
    */

    /*function __construct($conf = array()){
        parent::__construct($conf);
    }*/

    private $sessionName;
    private $dataFile;


    //__construct
    function set($conf){

        if (is_string($conf)) {
            $conf = array('dataScheme' => $conf);
        }

        parent::set($conf);


        if ($schemeConf = prop($conf, array('dataScheme', 'schemeName'))) {
            $this->setScheme($schemeConf);
        }

        if ($filePath = prop($conf, 'dataFile')) {
            $this->setDataFile($filePath);
        }

        if ($sn = prop($conf, 'sessionName')) {
            $this->setSessionData($sn);
        }

    }

    //получить данные привязанного sd-файла
    static function fileData($path){
        //dx($path, is_file($path));
        $res = array();
        if (is_file($path)) {
            $file = file_get_contents($path);
            if ($data = jsonTryDecode($file)) $res = $data;
            //dx($file, $data);
        }
        return $res;
    }

    private function setDataFile($path, $type = "listing"){
        $this->dataFile = $path;
        if (is_file($path)) {
            $this->data = static::fileData($path);
        } else {
            create_file($path);
            $this->data = array();
        }
        //dx(is_file($path), $path, $this->data);
        $this->verifyListingData();

        //так же генерировать путь backup-директории
    }

    private static function emptyListingData(){
        return array(0 => array(
            //'lastBackup' => '[Y-m-d H:i:s.u]',
            'list v' => '1.1',
            'lastId' => 0)
        );
    }
    //addListInfo = //private function setListInfoAsNullElement(){} //добавить в
    private function verifyListingData(){
        $data = $this->data;
        if (empty($data)) {
            $data = static::emptyListingData();
        } elseif (!is_array($data)) {
            file_backup($this->dataFile, dirname($this->dataFile).'/b');
            $data = static::emptyListingData();
        }


        //dx(($this->data == $data), $this->data, $data);
        if ($this->data !== $data) {
            $this->data = $data;
            $this->dataSync();
        }
    }

    private function setSessionData($sn){ //[nt]
        $this->sessionName = $sn;
        if (sHas($sn)) {
            $this->data = s($sn);
        } else{
            s($sn, $this->data);
        }
    }

    public function getScheme(){
    	return $this->scheme;
    }

	public function getSchemeField($fieldName){
		return prop($this->scheme->fields, $fieldName);
	}

    private function setScheme($schemeConf){

        $scheme = $this->scheme = scheme($schemeConf, false); //dx($scheme);

        //применяем настройки из схемы
        $conf = array();

        if (!empty($scheme->w)) $conf['w'] = $scheme->w;

        if ($scheme->sd && isset($scheme->sd['json'])) {
            if ($filePath = prop($scheme->sd['json'], 'path')) {
                $conf['dataFile'] = $filePath;
            }
        }


        if (!empty($conf)) $this->set($conf);

        //dx($scheme, $conf);
    }

    function dataSync(){
        if ($this->sessionName) {
            s($this->sessionName, $this->data);
        }

        $content = jsonPrettyEncode($this->data);
        if (!save_file($this->dataFile, $content)) {
            $this->error('ES0');
        }
    }



    var $msgTpl = array(
        'E' => 'Ошибка',
        'E1' => 'Нет схемы данных',
        'ES0' => 'Ошибка при синхронизации данных',
        'EG0' => 'Неправильный id %w/item|r|c% (%x/1%)', //-
        'EGS0' =>
            //'Данных \'%x/1%\' у %w/item|r нет', //- \ был для read_slice [b1.0]
            'Данных \'%x/1%\' у %w/item|r% #%x/2% нет',
        'ED' => '%x/1|has?Ошибка:Нет% входящих данных',
        'ED0' => 'Нет данных',
        'ED1' => 'Ошибка полученных данных (%x/1|t%)',

        'EV0' => 'Не хватает данных \'%x/1%\'',
        'EV1' => 'Неверное значение [%x/2%|t] для \'%x/1%\'',
        'EV2' =>  // 1 - имя-поля; 2 - значение; 3 - массив id элеменов, содержащие дубликат;
            //'Значение (%x/2|qq%) для поля %x/1|q% уже присутсвует / %x/3% раз',
            //'Дубликат значения: поле %x/1|q%: %x/2|qq%',
            'Дубликат значения: %x/1% — «%x/2%»',
        'EL0' => '%w/item|r|f% с id %x/1% нет',

        'AVC' => //{act verify confirm} 1 - имя-поля; 2 - значение; 3 - массив id элеменов, содержащие дубликат;
            'Требуется подверждение на использование одинакового значения для поля %x/1% — «%x/2%»',
            //повторрное использование
        'ARC' =>
            'Удалить элемент #%x/1%?',
            //повторрное использование

        'IU0' => 'Нет данных для обновления',
        'IU1' => 'Нет новых данных для обновления',

        'OU0' =>
            'Данные успешно обновились', //%new_data

    );


    // обработчик ошибок для метода dataPath в get_slice
    function error_read_slice($msg, $ctx/*, $sub_ctx*/){
        $args = func_get_args(); //dx($args);
        $args[0] = 'EGS0'; $args[1] = $ctx['missingName'];
        $this->errorArgs($args);
    }



    private function get($id){
        $res = array('ok' => true);
        if ($id === true) {
            $res['list'] = $this->data;
            unset($res['list']['0']);
        } else {
            $res['item'] = $this->data[$id];
        }
        return $res;
    }

    private function add($item){
        $id = ++$this->data[0]['lastId'];

        if ($scheme = $this->scheme) {
            $scheme->setId($item, $id);
        }

        $this->data[$id] = $item;
        //dx($item, $this->data);
        $this->dataSync();
        return array('ok' => true, 'id' => $id, '_item' => $item);
    }

    private function upd($id, $data){
        $prev = array();
        $item = $this->data[$id];
        foreach ($data as $prop => $value) {
            $prev[$prop] = prop($item, $prop, null);
            $item[$prop] = $value;
        }
        $this->data[$id] = $item;
        $this->dataSync();
        return array('ok' => $this->msg('OU0'), '_id' => $id, '_item' => $item, '_new' => $data, '_prev' => $prev);
    }

    private function del($id){
        $item = $this->data[$id];
        unset($this->data[$id]);
        $this->dataSync();
        return array('ok' => true, '_id' => $id, '_item' => $item);
    }

    function checkId($id){
        $ok = false;
        if (!$id || !is_numeric($id)) $this->error('ED', $id);
        else if (!isset($this->data[$id])) $this->error('EL0', $id);
        else $ok = true;
        return $ok;
    }

    function checkData($data){
        $ok = false;
        if (empty($data)) $this->error('ED0');
        elseif (!is_array($data)) $this->error('ED1');
        else $ok = true;
        return $ok;
    }


    function create($data, $set = array()) {
        $this->res(null);
        $this->res('_income_data', $data);
        $scheme = $this->scheme;

        //step1: проверка данных
        if ($this->checkData($data)) {
            $this->res_('verify', $res = $scheme->verify($data, 'new') ); //dx($res)

            //step2: проверка условий схемы
            if ($this->res('ok')) {
                $set_data = $res['_data']; //_verify
                //step2.1: уникальньность полей
                if ($this->res('ok') && $scheme->set->unique) {
                    $this->res($res = $scheme->verifyUnique($set_data, $this->data)); //dx($res);
                }

                //step3: добавление данных
                if ($this->res('ok')) {
                    $rec = $this->res('_verify_data');
                    $this->res_('create', $res = $this->add($rec)); //dx($res);
                }
            }
        }

        //dx($this->res);
        return $this->res();
    }

    function read($id = false, $dataPath = false){
        $this->res(null);


        if (func_num_args() === 0) {
            $this->res($this->get(true));
        } elseif ($this->checkId($id)) {
            $this->res($this->get($id));

            if ($dataPath) {
                $dataPath = explode('/', $dataPath); //!is_array($dataPath)
                $data = dataPath($dataPath, $this->res('item'), array($this, 'error_read_slice'), $id);
                $this->res('data', $data);
            }
        }

        return $this->res();
    }

    function update($id, $data){
        $this->res(null);
        $this->res('_income_data', $data);
        $scheme = $this->scheme;

        //step1: проверка данных
        if ($this->checkId($id) && $this->checkData($data)) {
            $this->res_('verify', $res = $scheme->verify($data, 'upd') ); //dx($res);

            //step2: проверка изменений
            if ($this->res('ok')) {
                $upd_data = $res['_data']; //_verify
                $item = $this->data[$id];
                $this->res_('changes', $res = $scheme->verifyChanges($item, $upd_data)); //dx($res);

                //step3: проверка условий схемы
                if ($this->res('ok')) {
                    $set_data = $res['_new']; //_changes
                    //step3.1: уникальньность полей
                    if ($this->res('ok') && $scheme->set->unique) {
                        $this->res($res = $scheme->verifyUnique($set_data, $this->data)); //dx($res);
                    }

                    //step4: обновление данных
                    if ($this->res('ok')) {
                        $this->res_('update', $res = $this->upd($id, $set_data)); //dx($res);
                    }
                }
            }
        }
        return $this->res();
    }

    function delete($id){
        $this->res(null); //dx($this->res());
        if ($this->checkId($id)) {
            $this->res_('remove', $res = $this->del($id)); //dx($res);
        }
        return $this->res();
    }


    //temp-h-fn
    //$propName - имя в схеме, для которого искать файлы
    //$itemId - для возможномти удалить файл для предыдущего значения
    //$resData - для обновления связующих данных
    //$set - опции
    //  removePrefFile - улаление файла для предыдущего значения
    function prepareRelDir($val, $id = false){
        if (!$id) {
            //getNextId
            $data = isAssoc($this->data) ? $this->data['0'] : $this->data[0];
            //$id = $data->lastId + 1; //pr $data is array
	        $id = prop($data, 'lastId') + 1;
        }
        return  strtr($val, array('%id%' => $id));
    }

    function handleFileData($propName, $itemId = false, &$resData = false, $set = true){
    	_needphp('set');
    	$set = set(is_mixed($set) ? $set : array('removePrefFile' => $set));

    	if (!$resData) $resData = array();


    	if ($FILE = @$_FILES[$propName]) {
            $fieldConf = $this->getSchemeField($propName);
            $fieldType = $this->getSchemeField('type'); //'images'|'gallery'
            $relDir = $this->prepareRelDir(prop($fieldConf, 'relDir', '/web/tmp'), $itemId);
            $relDirPath = rtrim(ROOT.$relDir, '/\\');
            if (!is_dir($relDirPath)) {
                mkdir($relDirPath, 0755, true);
            }
            $reqSizes = prop($fieldConf, 'sizes');


		    //step: save file
		    $fileName = $FILE['name'];
		    $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
		    $fileType = $FILE['type'];
		    $fileSize = $FILE['size'];
		    $tempPath = $FILE['tmp_name'];
		    $newFilePath = unique_path("$relDirPath/$fileName");
		    //$newFilePath = unique_filename($relDir, $fileName);
		    $move_uploaded_file = move_uploaded_file($tempPath, $newFilePath);

            if ($move_uploaded_file) {
                //step: remove prev file
                if ($set->removePrefFile && $itemId) {
                    $item = $this->read($itemId);
                    if ($item['ok']) {
                        $item = $item['item'];
                        $prevData = $item[$propName];
                        if ($prevSizes = prop($prevData, 'sizes')) {
                            foreach($prevSizes as $size) {
                                $prevFile = "$relDirPath/{$size['relSrc']}";
                                if (is_file($prevFile)) unlink($prevFile);
                            }
                        } else {
                            $prevName = (string) $prevData; //tb {s}
                            $prevFile = "$relDirPath/$prevName";
                            if (is_file($prevFile)) unlink($prevFile);
                        }
                    }
                }
            }

            if(0) rems('handleFileData', 'загрузка-файла',
                $move_uploaded_file,
                $newFilePath,
                $reqSizes
            );

            //step: делаем требуемые размеры картинок
            if ($reqSizes) {

                $Image = new pathImage($newFilePath);

                $size0 = array(
                    'sizeName' => '0', //null-size / original
                    'width' => (string)$Image->width,
                    'height' => (string)$Image->height,
                    'relSrc' => $Image->filename,
                );

                $data = array(
                    'name' => $size0['relSrc'],
                    'width' => $size0['width'],
                    'height' => $size0['height'],
                    'sizes' => array($size0),
                );

                if (is_array($reqSizes)) foreach ($reqSizes as $sizeData) {
                    $sizeName = is_array($sizeData) ? join('x', $sizeData) : (string) $sizeData; //fb

                    $resInfo = $Image->resize($sizeData, array(
                        'stretch' => false,
                        'getInfo' => true,
                    ));

                    if ($resInfo) {
                        $data['sizes'][$sizeName] = array(
                            'sizeName' => $sizeName,
                            'width' => (string)$resInfo['width'],
                            'height' => (string)$resInfo['height'],
                            'relSrc' => pathLess($resInfo['path'], $relDirPath),
                        );
                    }
                }
            } else {

                $data = basename($newFilePath);

                if ($reqSizes === 0) { //nb
                    $inf = getimagesize($newFilePath);
                    $data = array(
                        'name' => basename($newFilePath),
                        'width' => (string)$inf['width'],
                        'height' => (string)$inf['height']
                    );
                }
            }

            if(0) rems('handleFileData', 'результат',
                $data
            );

		    //step: set new value
		    $resData[$propName] = $data;
	    }

    	return $resData; //0 rz=&

    }

    //$propName - имя в схеме, для которого искать файлы
    //$resData - для обновления связующих данных

	function handleFilesData($propName, $itemId = false, &$resData = false){//, $set = true){
		//_needphp('set');
		//$set = set(is_mixed($set) ? $set : array('removePrefFile' => $set));

		if (!$resData) $resData = array();

		if ($FILE = @$_FILES[$propName]) {
			//$relDir = $this->scheme->fields[$propName]['relDir'];
            $fieldConf = $this->getSchemeField($propName);
            $fieldType = $this->getSchemeField('type'); //'images'|'gallery'
            $relDir = $this->prepareRelDir(prop($fieldConf, 'relDir', '/web/tmp'), $itemId);
            $relDirPath = rtrim(ROOT.$relDir, '/\\');
            if (!is_dir($relDirPath)) {
                mkdir($relDirPath, 0755, true);
            }
            $reqSizes = prop($fieldConf, 'sizes');

			if (!isset($resData[$propName]) || !is_array($resData[$propName])) {
				$resData[$propName] = array();
			}

			foreach ($FILE['name'] as $index => $name) {
				//step: save file
				$fileName = $name;
				$fileExt = pathinfo($fileName, PATHINFO_EXTENSION); //0
				$fileType = $FILE['type'][$index]; //0
				$fileSize = $FILE['size'][$index]; //0
				$tempPath = $FILE['tmp_name'][$index];
				$newFilePath = unique_path("$relDirPath/$fileName");
				//$newFilePath = unique_filename($relDir, $fileName);
				//move_uploaded_file($tempPath, $newFilePath);
				//rename($tempPath, $newFilePath);
                $move_uploaded_file = move_uploaded_file($tempPath, $newFilePath);

                if ($reqSizes) {

                    $Image = new pathImage($newFilePath);

                    $size0 = array(
                        'sizeName' => '0', //null-size / original
                        'width' => (string)$Image->width,
                        'height' => (string)$Image->height,
                        'relSrc' => $Image->filename,
                    );

                    $data = array(
                        'name' => $size0['relSrc'],
                        'width' => $size0['width'],
                        'height' => $size0['height'],
                        'sizes' => array($size0),
                    );

                    if (is_array($reqSizes)) {
	                    foreach ($reqSizes as $sizeData) {
		                    $sizeName = is_array($sizeData) ? join('x', $sizeData) : (string) $sizeData; //fb

		                    $resInfo = $Image->resize($sizeData, array(
			                    'stretch' => false,
			                    'getInfo' => true,
		                    ));

		                    if ($resInfo) {
			                    $data['sizes'][$sizeName] = array(
				                    'sizeName' => $sizeName,
				                    'width' => (string)$resInfo['width'],
				                    'height' => (string)$resInfo['height'],
				                    'relSrc' => pathLess($resInfo['path'], $relDirPath),
			                    );
		                    }
	                    }
                    }
                } else {

                    $data = basename($newFilePath);

                    if ($reqSizes === 0) { //nb
                        $inf = getimagesize($newFilePath);
                        $data = array(
                            'name' => basename($newFilePath),
                            'width' => (string)$inf['width'],
                            'height' => (string)$inf['height']
                        );
                    }
                }

				//step: set new value
                if ($fieldType == 'gallery') {
                    if (isset($resData[$propName][$index])) {
                        $data['comment'] = prop($resData[$propName][$index], 'comment', '');
                    }
                }

                $resData[$propName][$index] = $data;
			}
		}

		return $resData; //0 rz=&
	}


}


/*eg

$crud = new crud_json(array(
    'sessionName' => 'db_suppliers',
    'dataFile' => APP.'/data/storage/suppliers/suppliers.json'
));

*/