<?#2.14.0 - для вставки ko-конфигов (komponent'ы) в html-страницы
_needphp('json/jsonString');

//define('', '');

/*

$kProds = k(array(
	'name' => 'r/products/list',
	'q' => array('uri' => 'markets/rewind-repair'),
))->j(); //only-json without html-encoding


$k = k($ctx['cmpt']);
if ($k->name === $r->jd('conf', 'rProdItem')) {
	$k->qSet('prod', $prodPage);
}
if ($k->name === $r->jd('conf', 'rProdGroup')) {
	$k->qSet('group', $prodPage);
}


$kHexGrid = array('name' => $kHexGrid, 'q' => array('for' => 'markets'));
k($kHexGrid)->set(array(
	'w' => array('parent' => 2),
	'h' => array('parent' => 1),
));

*/

function k(){
	$args = func_get_args();
	$K = new ReflectionClass('K');
	$K = $K->newInstanceArgs($args);
	return $K;
}


class K {

	var $name;
	var $data;
	//var $api;
	var $q = array();
	function __construct($data = false){
		if ($data) {
			$this->update($data);
		}
	}

	var $handleProps = array(
		'name',
		'q',
		'data'
	);
	var $offCtx = array();
	function set($prop, $value){
		if (in_array($prop, $this->handleProps)) {
			switch ($prop) {
				case 'q': $this->qSet($value); break;
				case 'name';
				default: $this->{$prop} = $value;
			}
		} else {
			$this->offCtx[$prop] = $value;
		}
	}
	function update($data){
		if (is_string($data)) {
			$this->set('name', $data);
		} elseif (is_array($data)) {
			foreach ($data as $prop => $value) {
				$this->set($prop, $value);
			}
		}
	}

	function qSet(){
		if (func_num_args() === 1) {
			$data = func_get_arg(0);
			if (is_string($data) || is_numeric($data)) {
                $this->qSet(parse_str($data));
			} elseif (is_array($data)) {
				if (isAssoc($data)) {
					foreach ($data as $name => $val) {
						$this->qSet($name, $val);
					}
				} else {
					foreach ($data as $dataItem) {
						$this->qSet($dataItem);
					}
				}
			}
		} elseif (func_num_args() === 2) {
			list($name, $val) = func_get_args();
			$this->q[$name] = $val;
		}
	}


	function q(/*$data | $name, $val*/){
		if (func_num_args() === 0) {
			return $this->q; //qStr
		} elseif (func_num_args() === 1) {
			$this->qParse(func_get_arg(0));
		} else {
			list($name, $val) = func_get_args();
		}
	}


	function val(){
		if (!$this->name) return false;
		$conf = array();
		if (!empty($this->q)) {
			$conf['q'] = $this->q;
		}

		if (empty($conf)) {
			return $this->name;
		} else {
			$conf['name'] = $this->name;
			return $conf;
		}
	}
	function j(){
		return jsonString($this->val());
	}

	function ej(){
		return htmlspecialchars($this->j());
	}

	function __toString() {
		return (string) $this->ej();
	}
}