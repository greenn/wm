<?
include_once $_SERVER['DOCUMENT_ROOT'].'/kot/iq.inc';

//_kot::req_vue('side-menu', 'v-2/side-menu', array(), 'side-menu');
_kot::req_vue_v('side-menu', 'v-2');

return array(
	//'output' => 'vue', //handler | router

	'img' => 'kot/side-menu/xnview_6tBUzd3RQX.png',

	'embody' => rb_tpl('wd', 'vue/v1/app', array(
		'opt' => 'api=kot',
		'content' => join(newline, array(
			'<div style="padding: 15px 10px;">',
				'<side-menu mock="wd"></side-menu>',
			'</div>',
		))
	))
);