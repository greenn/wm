<?
$baseUri = dirUrl();
?>
<div>
    <div v-show="isActive">s-e-l-e-c-t-e-d</div>
    {{ content }}

    <div>
        <a :href="'<?=$baseUri?>/login'" @click.prevent="link('/login')">login titul</a>
    </div>

    <div>
        <a :href="'<?=$baseUri?>/login/name'" @click.prevent="link('/login/name')">Name</a>
    </div>

    <div>
        <a href="<?=$baseUri?>/login/password" @click.prevent="link('/login/password')">Password</a>
    </div>

</div>