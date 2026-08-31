<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

?>

<div id="app" class="demo">

    <select v-model="selected" multiple>
        <option>А</option>
        <option>Б</option>
        <option>В</option>
    </select>
    <br>
    <span>Выбрано: {{ selected }}</span>

</div>