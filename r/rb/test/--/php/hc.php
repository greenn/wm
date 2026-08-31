<? include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

_needphp('_h.class');

print _h('p', 'aaa');
print _h::p('bbb');
print _hc('p', 'ddd');
print _hc::p('eee');

print _h::div(array(
	'текст',
	' ',
	_h::b('h::b', 'color: blue'),
	' ',
	_hc::b('hc::b', 'color: green'),
));