<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

?>

<div id="app" class="demo">
    <div>
        {{message}}
    </div>

    <div>
        <i v-bind:title="title">AttributeBinding</i>
    </div>

    <div>Счётчик: {{ counter }}</div>

    <div id="event-handling">
        <p>{{ message }}</p>
        <button v-on:click="reverseMessage">Перевернуть сообщение</button>
    </div>

</div>