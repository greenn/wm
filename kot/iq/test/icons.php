<?
include_once $_SERVER['DOCUMENT_ROOT'].'/metro-targets/iq.inc';

?>
<link type="text/css" rel="stylesheet" href="/r/rb/lay/flex.css.php" />
<link type="text/css" rel="stylesheet" href="/r/rb/css/aq.css.php" />

<style type="text/css">
	-DIV { border: 1px dashed grey }
	IMG { border: 1px solid blue  }
	SVG { border: 1px solid red }

	[sz1] SVG { width: 20px; height: 20px; }

</style>
<section fxr fxi="c">
	<div><?=metro_i::svg('busy/loader/Rolling-0.7s-200px.svg')?></div>
	<div><?=metro_i::svg('busy/loader/Rolling-0.8s-200px.svg')?></div>
	<div><?=metro_i::img('busy/form/Rolling-0.7s-200px.gif')?></div>
	<div><?=metro_i::img('busy/form/Rolling-0.7s-200px.svg', '', 'width: 20px; height: 20px')?></div>
	<div><?=metro_i::svg('busy/form/Rolling-0.6s-800px.svg')?></div>
	<div><?=metro_i::svg('busy/form/Rolling-0.6s-202px.svg')?></div>
	<div><?=metro_i::svg('busy/form/Rolling-0.6s-175px.svg')?></div>
</section>

<section fxr fxi="c">

	<div sz1><?=metro_i::svg('busy/form/Rolling-0.6s-800px.svg')?></div>
	<div sz1><?=metro_i::svg('busy/loader/Rolling-0.8s-200px.svg', '')?></div>
	<div sz1><?=metro_i::svg('busy/form/Rolling-0.6s-202px.svg')?></div>
	<div sz1><?=metro_i::svg('busy/form/Rolling-0.6s-175px.svg')?></div>
	<div>
        <span ib class="spinner"></span>
    </div>

</section>



<style>
    .spinner {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        border: 9px solid #eb4d3d;
        animation: spinner-bulqg1 0.8s infinite linear alternate,
        spinner-oaa3wk 1.6s infinite linear;
    }

    @keyframes spinner-bulqg1 {
        0% {
            clip-path: polygon(50% 50%, 0 0, 50% 0%, 50% 0%, 50% 0%, 50% 0%, 50% 0%);
        }

        12.5% {
            clip-path: polygon(50% 50%, 0 0, 50% 0%, 100% 0%, 100% 0%, 100% 0%, 100% 0%);
        }

        25% {
            clip-path: polygon(50% 50%, 0 0, 50% 0%, 100% 0%, 100% 100%, 100% 100%, 100% 100%);
        }

        50% {
            clip-path: polygon(50% 50%, 0 0, 50% 0%, 100% 0%, 100% 100%, 50% 100%, 0% 100%);
        }

        62.5% {
            clip-path: polygon(50% 50%, 100% 0, 100% 0%, 100% 0%, 100% 100%, 50% 100%, 0% 100%);
        }

        75% {
            clip-path: polygon(50% 50%, 100% 100%, 100% 100%, 100% 100%, 100% 100%, 50% 100%, 0% 100%);
        }

        100% {
            clip-path: polygon(50% 50%, 50% 100%, 50% 100%, 50% 100%, 50% 100%, 50% 100%, 0% 100%);
        }
    }

    @keyframes spinner-oaa3wk {
        0% {
            transform: scaleY(1) rotate(0deg);
        }

        49.99% {
            transform: scaleY(1) rotate(135deg);
        }

        50% {
            transform: scaleY(-1) rotate(0deg);
        }

        100% {
            transform: scaleY(-1) rotate(-135deg);
        }
    }
</style>




