<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

?>

<div id="app" class="demo">

    <input v-model="h1">
    <br />
    <button @click="postFontSize += 0.1">enlarge 0.1</button>

    <button @click="postFontSize += 0.1">enlarge 0.1</button>

    <enlarge-button @enlarge-text="postFontSize += $event"></enlarge-button>

    <enlarge-button @enlarge-text="doEnlargeText"></enlarge-button>

    <div>
        <div><input :value="postFontSize" /></div>
        <div><input v-bind:value="postFontSize" /></div>
        <div><input style="font-weight: bold" v-model="postFontSize" /></div>
        <div><span>{{ postFontSize }}</span></div>
        <h1 :style="{ fontSize: postFontSize + 'em' }">
            {{ h1 }}
        </h1>
    </div>

</div>