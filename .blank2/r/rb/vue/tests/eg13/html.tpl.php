<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

_needphp(
	'dirUrl'
);

$dirUri = dirUrl(__FILE__);
?>


<div id="app">
    <div>
        <h1>User Settings</h1>
        <NavBar />
        <router-view />
        <router-view name="helper" />
    </div>


    <router-view class="view left-sidebar" name="LeftSidebar"></router-view>
    <router-view class="view main-content"></router-view>
    <router-view class="view right-sidebar" name="RightSidebar"></router-view>
</div>

