<?
//include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
?>
<link type="text/css" rel="stylesheet" href="/r/rb/css/aq.css.php" />
<style>
    .grid-container {
        display: grid;
        grid-template-columns: 30% 30% 40%;
        grid-gap: 10px; /* Отступ между ячейками */
    }

    .cell {
        border: 1px solid black; /* Границы ячеек для наглядности */
        padding: 10px; /* Отступ внутри ячеек */
    }

    /* Стиль для ячеек, занимающих два столбца */
    [colspan="2"] {
        grid-column: 2 / span 2; /* Начинаем с 2-го столбца и занимаем 2 столбца */
    }

</style>
<div class="grid-container">
	<div class="cell">Ячейка 1</div>
	<div class="cell">Ячейка 2</div>
	<div class="cell">Ячейка 3</div>
	<div class="cell">Ячейка 4</div>
	<div class="cell" colspan="2">Ячейка 5 и 6</div>
</div>