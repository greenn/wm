<?#1.2.0 - database installer
	//управлятор нет ж загружатор нет подключтор базы

_needphp(
	'qtpl.class',
	'_h.class',
	'sd', //_sd(), _sd{}, sd{}
	//qg - pro
	'mysql/mc.class',
	'_h.class'
);

qtpl_set(array(dirname(__FILE__), 'idb', 'v1'), 'tpl.php'); //определяем директорию для темплейтов qtpl

class idb {
    static $Pro = 'pro';
    static function pro($method/*, $arg1, $argN*/){
        //для вызова pro::$method($arg1, $argN*)
        return call_user_func_array(array(static::$Pro, $method), array_slice(func_get_args(), 1));
    }

	static $MC = 'mc';
	static function mc($method/*, $arg1, $argN*/){
		//для вызова mc::$method($arg1, $argN*)
		return call_user_func_array(array(static::$MC, $method), array_slice(func_get_args(), 1));
	}

	//init_form_receiver
	static function init_form_output($dbName = true, $dbStruct = true){
	    if ($dbStruct === true) {
		    //$dbStruct = call_user_func(array(static::$Pro, 'db_struct'));
		    $dbStruct = static::pro('db_struct');
        }
	    //dx($dbStruct);

?>

		<?
        $rebuildMod = isset($_GET['rebuild']);
		if ($rebuildMod) {
			$hTitulLink = '<a href="'.pageUrl.'">титульную</a>';
			print _h::p(join('<br />', array(
                "<div>",
                    "td: Запустить режим <b>rebuild</b>?",
                    "Все таблицы из базы <i>%имя-базы</i>>буду удалены",
                    "И перестроены с теущим \$dbStruct",
				'</div>',
				"Запущен режим <b>rebuild</b>.",
				"Не забудьте уйти с этой страницы на $hTitulLink",
			)), 'color: red');

			//dx(pro::db_struct());
			$_POST['rebuild'] = array();
			foreach ($dbStruct as $tb_name => $tb_struct) {
				$_POST['rebuild'][$tb_name] = $tb_name;
			}

		} ?>

        <div><a href="<?=URI?>">F5</a></div>

		<? if ($_POST) {
			//dx($_POST['rebuild']);
			$rebuild = prop($_POST, 'rebuild', array());
			$select_rebuild = prop($_POST, 'select_rebuild', array());

			if (isset($_POST['rebuild'])) {
				foreach ($_POST['rebuild'] as $tbName) {
					$isDeleted = static::mc('table_delete', $tbName);
					print _h::p("Таблица `$tbName` удалена ".($isDeleted ? '(да)' : '(нет)'), 'color: red');
				}
			}

			//dx($_POST);
		}
		?>

        <form action="<?=URI?>" method="post">
			<? idb::init($dbName, $dbStruct); ?>
        </form>

<?
	}

	static function init($dbName = true, $dbStruct = true){
		if ($dbName === true) $dbName = static::pro('db_name');
		static::init_db($dbName);

		//инициализация sd-info
		_sd::info_init();

		if ($dbStruct === true) $dbStruct = static::pro('db_struct');
		//dx($dbStruct);

		static::init_cfg($dbStruct);
	}


	//запустить базу данных (если что создать)
	static function init_db($dbName){
		$justCreated = false;
		//d('idb/init_db', $dbName);

		if (!static::mc('db_exist', $dbName)) {
			static::mc('db_create', $dbName);
			$errorOfDbCreate = static::mc('error');
			$justCreated = true;
		}

		static::mc('db_select', $dbName);

		print _qtpl('app');
		print _qtpl('db_state', array(
			'dbName' => $dbName,
			'justCreated' => $justCreated,
			'isConnected' => static::mc('db_current_is', $dbName, true),
			'error' => @$errorOfDbCreate,
			'proof' => static::mc('db_exist', $dbName),
			//'proof2' => static::mc('db_current', true) === $dbName,
		));

	}

	//запустить простройку конфига таблиц
	static function init_cfg($dbStruct){
	    //dx($dbStruct);
		if ($dbStruct) foreach ($dbStruct as $tbName => $cfg) {
			static::init_cfg_item($tbName, $cfg);
		}
	}

	//запустить простройку таблицы по конфигу
	static function init_cfg_item($tbName, $cfg){

	    if (prop($cfg, 'skip')) return;

		$justCreated = false;
		if (!static::mc('table_exist', $tbName)) {
			$isCreated = static::init_item_struct($tbName, $cfg['struct']);
			$justCreated = true;
		}

		$isExist = static::mc('table_exist', $tbName);

		//d($tbName, $isExist, $cfgData = prop($cfg, 'data'));
		if ($isExist) {
			if ($cfgData = prop($cfg, 'data')) {
				static::init_item_data($tbName, $cfgData, prop($cfg, 'data-opt'));
			}
		}

		print _qtpl('tb_state', array(
			'tbName' => $tbName,
			'justCreated' => $justCreated,
			'isCreated' => $isExist,
		));

	}

	//запустить простройку структуры таблицы
	static function init_item_struct($tbName, $struct){
		$res = false;
		//d($tbName, $struct);

		if (isOrdinal($struct)) {
			//case: есть указание на специальность структура (указание на тип в первом аргументе)
			if ($struct[0] === 'sd') {
				//case: sd
				list($tbBuilder, $sdType, $struct) = $struct;
				$res = _sd::create($sdType, $tbName, $struct);
			} else {
				d('unknown ordinal-struct', $struct);
			}
		} else if (isAssoc($struct)) {
			//case: mc - структура для mysql_table{}
			//d('mc', $struct);
			$res = static::mc('table_create', $tbName, $struct);
			//d('idb/init_item_struct', $res, static::mc('__get', 'table_created_fields'), static::mc('__get', 'table_created_cfg'));
		} else {
			d('unknown db-struct', $struct);
		}

		return $res;
	}


	//запустить заполнение таблицы данными
	static function init_item_data($tbName, $data_list, $opt = array()){
		$set = set(array(
			'add_skip' => false, #{b} //указание, пропустить добавление
			//'add_list' => false, #{a} //список элементов, где prop: state / true - добавлять
			'add_verify_prop' => false, //свойство для проверки autoId данные
                //#case-u2 если оно id, а данные с авто id, то добавляться будут все, сделано чтобы можно было добавлять с автоid даже одинаковы й набор данных
			#{s, a, b|t - все данные|f - не создавать, т.е. если ausoId данные, надо указать в data-opt add_verify_prop}

			//td
			'rebuild' => false, #{b} //возможно пересоздать
			'rebuild_list' => false, #{a} //список элементов для пересоздания
		), $opt);

			//$tb_info = _sd::struct_info($tbName, $autoId ? 'fields' : 'struct');
		$tb_info = _sd::struct_info($tbName, 'struct');
		$tb_fields = array_keys($tb_info); //fieldsOrder
		$sd_struct = _sd::info_get_sd($tbName);

		$has_id = in_array('id', $tb_fields);
		$isDataAutoId = $has_id && isOrdinal($data_list); //в данных нету чёткого указания на id (primary key)
        //d($has_id, $isDataAutoId);

		//d($tbName, $tb_info, $tb_fields, $has_id, _sd::struct_info($tbName));
		//dx('init_item_data', $tbName, $data_list, $tb_fields, $sd_struct);
		//dx('init_item_data', $tbName, $isDataAutoId, $data_list, $tb_fields, $sd_struct, isOrdinal(reset($data_list)));

		foreach ($data_list as $key => $data) {
			//step: приводим данные к виду: поле - значение
			if (isOrdinal($data)) {
				//case: данные без указания полей
				$data = merge_keys_values($tb_fields, $data);
			}

			//step: проставляем id, если они были переданые - isAssoc($data_list)
            //dx($has_id, $isDataAutoId, isset($data['id']));
			if ($has_id && !$isDataAutoId && !isset($data['id'])) {
				$data['id'] = $key;
			}

			$rebuildItemId = static::whetherTo_rebuild_item_data($set, $tbName, $data, $sd_struct);
			//d($rebuildItemId, $tbName, $data, $dataId = @$data['id'], $set->info(), $sd_struct);

			if ($rebuildItemId) {
				static::rebuild_item_data($tbName, $rebuildItemId, $data, array(
					//'keepId' => true
				));
			} else {
			    $addItem = static::whetherTo_add_item_data($set, $tbName, $data, !$has_id);
			    //d($addItem, $tbName, $data, $sd_struct, $set);
				if ($addItem) {
					static::add_item_data($tbName, $data, $sd_struct, array());
				}
            }

		}
	}

	//проверяем нужно ли добавлять указанные данные
	static function whetherTo_add_item_data($opts, $tbName, $data, $no_id = false){
		$set = set($opts);
		if ($set->add_skip) return false; //не создавать

        $dataHasId = isset($data['id']);

		//step: определяем проверяющее свойство (чтобы не создавать двойников)
		$verify_prop = $set->optOr('add_verify_prop', true);
		if (!$no_id && $dataHasId) $verify_prop = 'id';
		if ($verify_prop === 'id' && !$dataHasId) return true; #case-u2



            /*  prev uu
                 $isAutoId = !isset($data['id']);
                 $verify_prop = $no_id ? $set->optOr('add_verify_prop', true)
                    : ($isAutoId ? $set->add_verify_prop : 'id');
                //dx(1, $verify_prop, $no_id, $set->add_verify_prop, $set->optOr('add_verify_prop', true), $set->info());
            */

		//d($no_id, $verify_prop);

		if ($verify_prop === true) $verify_prop = $data;
		if (isOrdinal($verify_prop)) $verify_prop = pickProps($verify_prop, $data);
		if (!$verify_prop) return false; //не создавать
        //d(4, $verify_prop, $isAutoId);

		$where = is_array($verify_prop) ? $verify_prop : argsArr($verify_prop, $data[$verify_prop]);
		$exist = _sd($tbName, 'has', $where);
		#dbg
			//if (!$exist)
			//d('whetherTo_add_item_data', $tbName, $verify_prop, $where, $exist);
		return !$exist; // true - создавать, false - не создавать
	}

	//добавляем указанные данные
	static function add_item_data($tbName, $data,  $sd_struct, $opt){
		$set = set(array(), $opt);
		//dx('idb/add_item_data', $tbName, $data, $sd_struct, $set->info());
		$res = _sd($tbName, 'add', $data);
		//$res = mc::item_add($tbName, $data);
		//d('idb/add_item_data', $tbName, $data, $set->info(), $res, mc::last_sql(), mc::error());
	}


	//id
		//проверяем нужно ли перестраивать указанные данные
		static function whetherTo_rebuild_item_data($opts, $tbName, $data, $sd_struct){
			$set = set($opts);
			$set->rebuild;
			return false;
		}
		//перестраиваем указанные данные
		static function rebuild_item_data($tbName, $curId, $data, $opt){
			$set = set(array('keepId' => true), $opt);
			$res1 = _sd($tbName, 'remove_where', 'id', $curId);
			///d($set->keepId, $res1, $set->info());
			if ($set->keepId) $data['id'] = $curId;
			$res2 = _sd($tbName, 'add', $data);
			d('idb/rebuild_item_data', $curId, $data, $res1, $res2, $set->info());
		}


}

idb::$Pro = new pro;