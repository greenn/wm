<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
?>

<script src="/js/knockout/3.5.1/knockout-latest.debug.js"></script>
<script>
    var item
	var a = ko.observable(item = { a: 10 });
    a.subscribe(function(value){
        console.log('ko (new-val)', value, arguments);
    });

    item.a += 1;
    /*v1*///a(item);
    /*v2*///a.valueHasMutated();

</script>