<?#6.1.920
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

$Self = _rb::self();
$relDir = $Self::relDir();

print rb_tpl('page', 'page', array(
	'body' => $Self::tpl("$relDir/page"),

	'head' => <<<html
<script src="https://unpkg.com/vuejs-storage"></script>
<script src="https://unpkg.com/vue"></script>
<script src="https://unpkg.com/vuex"></script>

<script type="text/x-template" id="app-sub">
    <section>
	    	<div>
	        <b>{{ count }}</b>
	        <button @click="inc_global">inc_global</button>
	    </div>
	    <div>
	        <i>{{ counter }}</i>
	        <button @click="inc_self">inc_self</button>
	    </div>
    </section>
</script>

html
	,
));
