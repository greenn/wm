<?
include_once $_SERVER['DOCUMENT_ROOT'].'/iq.inc';
_needphp('pcss');
?>


<style>


    .roll {
        font-weight: 700;
        display: inline-block;
        overflow: hidden;
        vertical-align: top;
        <?=pcss('perspective', '400px') #? ?>
        <?=pcss('perspective-origin', '50% 50%') #? ?>
    }

    .roll SPAN {
        display: block;
        position: relative;
        padding: 0 2px;
        <?=pcss('transition', 'all .4s ease')?>
        <?=pcss('transform-origin', '50% 0')?>
        <?=pcss('transform-style', 'preserve-3d') #! ?>
    }

    .roll:hover {
        text-decoration: none
    }

    .roll:hover SPAN {
        text-decoration: none;
        background: #39a9ce;
        <?=pcss('transform', 'translate3d(0, 0, -30px) rotatex(90deg)')?>
    }

    .roll SPAN:after {
        content: attr(data-title);
        display: block;
        position: absolute;
        left: 0;
        top: 0;
        padding: 0 2px;
        color: #fff;
        background-color: #39a9ce;

        <?=pcss('transform-origin', '50% 0')?>
        <?=pcss('transform', 'translate3d(0, 105%, 0) rotatex(-90deg)')?>
    }

</style>
<?/*
<style>


    .roll {
        font-weight: 700;
        display: inline-block;
        overflow: hidden;
        vertical-align: top;
        -webkit-perspective: 400px;
        -moz-perspective: 400px;
        -webkit-perspective-origin: 50% 50%;
        -moz-perspective-origin: 50% 50%
    }

    .roll span {
        display: block;
        position: relative;
        padding: 0 2px;
        -webkit-transition: all .4s ease;
        -moz-transition: all .4s ease;
        -webkit-transform-origin: 50% 0;
        -moz-transform-origin: 50% 0;
        -webkit-transform-style: preserve-3d;
        -moz-transform-style: preserve-3d
    }

    .roll:hover {
        text-decoration: none
    }

    .roll:hover span {
        text-decoration: none;
        background: #39a9ce;
        -webkit-transform: translate3d(0, 0, -30px) rotatex(90deg);
        -moz-transform: translate3d(0, 0, -30px) rotatex(90deg)
    }

    .roll span:after {
        content: attr(data-title);
        display: block;
        position: absolute;
        left: 0;
        top: 0;
        padding: 0 2px;
        color: #fff;
        background-color: #39a9ce;
        -webkit-transform-origin: 50% 0;
        -moz-transform-origin: 50% 0;
        -webkit-transform: translate3d(0, 105%, 0) rotatex(-90deg);
        -moz-transform: translate3d(0, 105%, 0) rotatex(-90deg)
    }

</style>
*/?>


<a href="#" class=" roll"><span data-title="make a donation">make a donation</span></a>
