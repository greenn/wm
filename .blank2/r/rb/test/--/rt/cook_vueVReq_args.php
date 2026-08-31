<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

//расскоментить dbg на iq/php/r/rt.class.php:152

//side-menu/v1/side-menu.vue.js.inc
_rt::req_vue_v('side-menu', 'v-1');


//side-menu/v1/pane.vue.js.inc
	//зафиксированное название темплейта - меняется версия
_rt::req_vue_v(array('side-menu', 'pane'), 'v-1');

//side-menu/v1/pane.vue.js.inc
	//версия темплейта включает номер и файл
_rt::req_vue_v('side-menu', array('v-1', 'pane'));

