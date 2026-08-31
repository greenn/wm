<?//=$Self::tpl('prod-item/product-item-side-sizes-1')?>

<? if (1) { ?>
    <prod-size
            :idn="true"
    ></prod-size>
<? } ?>


<prod-size-1
        :prod="curProd"
	<?//:sizes="curProdProp('sizes')"?>
	<?//@on-select-price="log('@on-select-price', $event)"?>
></prod-size-1>