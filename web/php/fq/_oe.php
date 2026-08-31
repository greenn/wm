<?#2.0

class oe { //empty-object # 2-15 | q ose
	function __construct(){ }
	function __call($m, $a){ return ''; }
	function __get($p){ return ''; }
	function __toString(){ return ''; }
}
class oee { //empty-extendable-object # d1

}

class ohe { //empty-html-object # 2-16
	var $defName = '';
	function string($note = false){
		//return sprintf("<!-- %s%s -->", $this->defName, is_stringable($note) ? ": $note": '');
		return sprintf("<!-- %s%s -->", $this->defName, is_stringable($note) ? $note : '');
	}
	function __construct($defName = ''){ $this->defName = $defName; }
	function __call($m, $a){
		//return $this->string($m);
		//return $this->string("->$m()");
		return $this->string("->$m(".(count($a) ? count($a) : '').")");
	}
	function __get($p){ return $this->string($p); }
	function __toString(){ return $this->string(); }
}