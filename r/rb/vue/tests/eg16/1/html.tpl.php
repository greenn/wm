<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

_needphp(
	'dirUrl'
);

$dirUri = dirUrl(__FILE__);
?>


<div id="dynamic-component-demo" class="demo">
    <button
        v-for="tab in tabs"
        :key="tab"
        :class="['tab-button', { active: currentTab === tab }]"
        @click="currentTab = tab"
    >
        {{ tab }}
    </button>

    <b>{{ currentTab }}</b>

    <component v-if="currentTab === 'tab1'">
        tab 1
    </component>

    <component v-if="currentTab === 'tab2'">
        tab 2
    </component>
</div>


