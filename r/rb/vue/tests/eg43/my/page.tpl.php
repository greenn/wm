<?
$Self = _rb::self();
$relDir = $Self::relDir();
?>
<div id="app">
    <div>
        <span>Vue counter: {{count}}</span>
        <button @click="add">add</button>
    </div>
    <div>
        <span>Vuex counter: {{vuexcount}}</span>
        <button @click="vuexadd">add</button>
    </div>
</div>
<div id="app2">
    <div>
        <span>sessionStorage counter: {{count}} {{message}}</span>
        <button @click="add">add</button>
    </div>
</div>
<div>
    Try open this page in another tab.
</div>
<script>
    <?=$Self::tpl("$relDir/app", false, 'js.inc')?>
    <?//=$Self::tpl(array("$relDir/app", 'js.inc'))?>
</script>