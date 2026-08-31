<?
$mount = 'MAIN';

_rb::req_css('lay', 'flex');
_rb::req_css('page', 'css/base');
//_rb::req_css('page', 'css/aq');


_kot::req_vue('ui', 'icon-mat', array(), 'icon-mi');
_kot::req_vue('ui', 'icon-mat', array(), 'icon-mitt');
_kot::req_vue('ui', 'icon-mat', array(), 'icon-mo');
_kot::req_vue('ui', 'icon-mat', array(), 'icon-mr');
_kot::req_vue('ui', 'icon-mat', array(), 'icon-ms');
//_kot::req_vue('ui', 'icon-mat');



?>

<style>
    TABLE {
        border-collapse: collapse;
    }

    TABLE, TD {
        border: 1px solid paleturquoise;
    }

    TD {
        width: 20px;
        height: 20px;
        padding: 20px;
        vertical-align: middle;
        text-align: center;
    }


     [c1] [icon] {
         color: lightseagreen;
         font-variation-settings:
             'FILL' 0,
             'wght' 400,
             'GRAD' 0,
             'opsz' 48
     }

</style>

<main>
    <table>
        <tr>
            <td>
                <icon-mo c1>add</icon-mo>
            </td>
        </tr>

        <?
        if(0){

            $defSet = array(
                array('add'),
                array('add_circle_outline'),
                //array('add_circle_outline', 'style="color:black"'),
                array('add_circle'),
                array('&#xe147;'),


                ///array('x'),
                ///array('emoticon'),
                //array('chevron_right'),
            );
            $moSet[0][1] = 'dbg tooltip="add"';
        }

        $defSet = array(
            array('arrow_back_ios')
        );



        $mSet = $moSet = $mrSet = $msfSet = $defSet;

        foreach (array(
            array('icon-mi', 'Material Icons', $mSet),
            array('icon-mitt', 'Material Icons Two Tones', $mSet),
            array('icon-mo', 'Material Symbols Outlined', $moSet),
            array('icon-mr', 'Material Symbols Rounded', $mrSet),
            array('icon-ms', 'Material Symbols Sharp', $msfSet),
        ) as $data) {
	        list($tag, $title, $list) = $data;
        ?>
            <tr>
                <td colspan="<?=count($list)?>">
                    <?=$title?>
                </td>
            </tr>
            <tr>
                <? foreach ($list as $item) {
                    $name = $item[0];
                    $a = prop($item, 1, '');
                ?>
                <td>
                    <?="<$tag $a>$name</$tag>"?>
                </td>
                <? } ?>
            </tr>
        <? } ?>



    </table>
</main>