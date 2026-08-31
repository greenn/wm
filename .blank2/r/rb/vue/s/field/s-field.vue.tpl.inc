<?
//$Self = _rb::self();
?>
<div field :class="[$attrs.class, cssClass]">
    <div label v-if="label"><label :for="id">{{ label }}</label></div>
    <div input><input
        :id="id"
        v-model="value"
        @focus="focus = true"
        @blur="focus = false"
        @mouseover="hover = true"
        @mouseleave="hover = false"
    ></div>
    <div msg v-if="show_msg" v-html="msg"></div>
</div>