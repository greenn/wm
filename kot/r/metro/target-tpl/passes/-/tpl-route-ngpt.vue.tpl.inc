<?
$Self = _kot::self();
$n = $Self::nc();

_kot::req_vue('ui', 'button', array(), 'ui-button');

?>
<?/*
    <request-bar :tick="updateTime"></request-bar>
*/?>
<div>
    <div>content: {{ content }}</div>
	<?//<pre>{{ $route }}</pre>?>

    <ui-button r-button @click="submit">
        Добавить в шаблон
    </ui-button>

</div>