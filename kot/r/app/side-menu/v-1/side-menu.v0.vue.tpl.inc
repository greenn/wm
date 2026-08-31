<?
$Self = _kot::self();
$n = $Self::nc();
$vueName = prop($Self::tempCtx(), 'id', basename(__FILE__, '.vue.js.inc')); //'side-menu'

$Self::req_css('side-menu');
?>

<section class="<?=$n?>">

    <div r class="<?=$n?>-item" v-for="(item, index) in list" :num="item.addr">

        <div fxr class="<?=$n?>-link-w" :class="{

        }">

            <div>index: {{ index }}</div>
            <pre>item: {{ item }}</pre>
        </div>
        <hr />



    </div>

</section>