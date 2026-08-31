<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

_needphp(
	'dirUrl'
);

$dirUri = dirUrl(__FILE__);
?>


<div id="app">
    <router-view></router-view>
</div>


<div id="app2">
    <h1>Hello App!</h1>
    <ul>

        <li><router-link to="/">Go to Home</router-link></li>
        <li><router-link to="/users/eduardo">eduardo</router-link></li>
        <li><router-link to="/users/eduardo/posts/123">eduardo/posts/123</router-link></li>
    </ul>

    <router-view></router-view>
</div>


