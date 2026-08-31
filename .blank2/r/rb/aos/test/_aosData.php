<?

include_once $_SERVER['DOCUMENT_ROOT'] . '/site/iq.inc';

need_rp('aos');



$attrs = _aos('t:1000', 'n:fade-right', 'd:'.(850 + 150));
dx($attrs, _aosData($attrs));