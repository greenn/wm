<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
?>

<script src="/js/knockout/3.5.1/knockout-latest.debug.js"></script>
<script>
	var a = ko.observable(10);
	a.subscribe(function(value){
	    console.log('ko (new-val)', value, arguments);
	});
	a(20);
</script>