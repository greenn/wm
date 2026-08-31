<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

_needphp('x.class');

x::set('a', 11);
d(x::incr('a'));
d(x::incr('a'));
d(x::incr('a'));