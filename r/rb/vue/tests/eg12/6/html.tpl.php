<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

_needphp(
	'dirUrl'
);

$dirUri = dirUrl(__FILE__);
?>


<div id="app">
    <ul>
    <li><router-link to="/">Go to Home</router-link></li>
    <li>
        <router-link :to="{ name: 'user', params: { username: 'erina' }}">
            User
        </router-link>
    </li>

    </ul>
    <router-view></router-view>
</div>