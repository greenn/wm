<?
//include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
?>
<link type="text/css" rel="stylesheet" href="/r/rb/css/aq.css.php" />

<style>
    /*
        .grid-container определяет контейнер сетки с тремя столбцами.
        Каждый .grid-item представляет собой ячейку сетки.
        .item3 использует grid-row: 1 / span 2;, чтобы занять две строки в высоту, начиная с первой строки. Это имитирует rowspan=2 для третьей ячейки первого ряда.
        Таким образом, третья ячейка (item3) растягивается на две строки, создавая эффект rowspan=2, а остальные ячейки (item4 и item5) автоматически позиционируются во второй строке сетки.
   */
    .grid-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* 3 столбца с одинаковой шириной */
        grid-auto-rows: auto; /* Автоматическая высота строк */
        gap: 10px; /* Отступы между ячейками */
    }

    .grid-item {
        background-color: lightblue;
        padding: 20px;
        text-align: center;
    }

    .item3 {
        <?// grid-row: 1 / span 2; /* Занимает 2 строки (первый столбец)*/ ?>
        grid-column: 3; /* Помещаем ячейку в третий столбец */
        grid-row: 1 / span 2; /* Занимает 2 строки */
    }

</style>
<div class="grid-container">
    <div class="grid-item item1">Ячейка 1</div>
    <div class="grid-item item2">Ячейка 2</div>
    <div class="grid-item item3">Ячейка 3 (rowspan=2)</div>
    <div class="grid-item item4">Ячейка 4</div>
    <div class="grid-item item5">Ячейка 5</div>
</div>
