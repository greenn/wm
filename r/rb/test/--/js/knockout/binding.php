<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
?>

<script src="/js/jquery/1.12.4/jquery.js"></script>
<script src="/js/knockout/3.5.1/knockout-latest.debug.js"></script>

<script>
	let A = { tx: 'AA' };
	let B = { tx: 'BB' };

	$(function(){
        ko.applyBindings(A, $('#a')[0]);
        ko.applyBindings(B, $('#b')[0]);
    });
</script>

<section id="a">
    <b data-bind="text: tx"></b>
</section>
<section id="b">
    <b data-bind="text: tx"></b>
</section>