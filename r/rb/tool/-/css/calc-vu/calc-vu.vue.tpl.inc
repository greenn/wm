<?
    $Self = _rw::name('tool-css');
    $nCV = $Self::nc('calc-vu');

    //css::req('rw', 'tool-css', 'calc-vu/calc-vu.css.php');
?>
<div class="<?=$nCV?>">
    <h2>Vu</h2>
    <div class="<?=$nCV?>-w">
        <div class="<?=$nCV?>-col" size>
            <label>size</label>
            <input v-model="size" size="3" />
        </div>

        <div class="<?=$nCV?>-col" input>
            <label>input</label>
            <input v-model="input" size="3" />
        </div>
        <div class="<?=$nCV?>-col" vu>
            <label>vu</label>
            <b v-text="value"></b>
        </div>
    </div>
</div>