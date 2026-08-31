<?
//include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
?>
<link type="text/css" rel="stylesheet" href="/r/rb/css/aq.css.php" />
<style>
    .container {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* Создаем сетку из 3 столбцов */
        grid-template-rows: repeat(4, auto); /* Определяем количество строк */
        gap: 10px; /* Отступы между элементами сетки */
    }

    .item {
        background-color: lightblue;
        padding: 10px;
    }

    .item2 {
        grid-row: 1 / span 3; /* Элемент item2 будет занимать 3 строки */
    }

</style>
<div class="container">
    <div class="item">1</div>
    <div class="item item2">2 (rowspan)</div>
    <div class="item">3</div>
    <div class="item">4</div>
    <div class="item">5</div>
    <div class="item">6</div>
</div>