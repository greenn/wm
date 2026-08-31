<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

/*
	post
		https://stackoverflow.com/questions/59610614/what-is-axios-defaults-headers-post-content-type-application-json
	get
		https://stackoverflow.com/questions/46404051/send-object-with-axios-get-request
*/


print rb_tpl('page', 'page', array(
	'pageTitle' => 'jQuery $.Ajax',
	'body' => <<<html

<h4>jQuery / Ajax</h4>
<hr />
<pre>
await $.ajax({ 
	method: 'get',  
	url: "/api/rw/tool-log/test",
});
</pre>
<hr />
html
	,
	'webkit' => array(
		'jquery'
	),
));