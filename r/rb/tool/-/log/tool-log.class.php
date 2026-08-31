<?

_needphp('log');

$Self = _rw::reg('tool-log', array(
	'className' => 'tool_log',
	'rDir' => dirname(__FILE__),
	'rClass' => __FILE__,
	'nc' => array(
		'base' => 'ToLo'
	)
));

//dx($Self, _rw::$db);

class tool_log extends rw {

}