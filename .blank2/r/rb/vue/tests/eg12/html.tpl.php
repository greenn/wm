<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';

_needphp(
	'dirUrl'
);

$dirUri = dirUrl(__FILE__);
?>



<div id="app">
    <h1>Hello App!</h1>
    <ul>

        <li><router-link to="/">Go to Home</router-link></li>
        <li><router-link to="/about">Go to About</router-link></li>
        <li><router-link to="/test">test</router-link></li>
        <li><router-link to="/404">404</router-link></li>
    </ul>

    <router-view></router-view>
</div>


