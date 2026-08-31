<?
//note: закрыто от внешнего вызова (т.к. расширение php)

_needphp('parser\strTabMenuParser.class');

$data = <<<text
Updates \ q=12
	sub-1
	sub-2
Teams
	sub-1
	sub-2
Projects \ expanded=true add-project=true
	Coin Calc
	Fractal
	Habitlog
	Deepclip
Tasks \ add-task=true expanded=true
	All \ q=48
	In progress \ q=8
	Done \ q=24
Archived
	sub-1
	sub-2
text;

return strTabMenuParser::parse($data);
