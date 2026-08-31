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

    <component :is="currentTabComponent" class="tab"></component>
</div>


    <div id="app">
        <tabs>
            <tab title="tab 1">
                <p>Tab #1 content</p>
            </tab>
            <tab title="tab 2">
                <p>Tab #2 content</p>
            </tab>
            <tab title="tab 3">
                <p>Tab #3 content</p>
            </tab>
        </tabs>
    </div>


