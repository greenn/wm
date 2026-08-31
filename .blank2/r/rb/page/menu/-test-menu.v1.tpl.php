<?  //tm|rb

    $Self = self_rp();

    $_ctx = $Self::tplCtx(array(
        'nc' => 'test-menu',
        'menu' => array(
	        array('', '/'),
	        'uc',
	        array('fake?fake', 'fake'),
	        '204',
	        '404',
	        '403',
	        'undefined',
	        'error',
	        array('error?msg=error-msg', 'error?msg'),
        ),
    ));

    $menuData = $_ctx['menu'];
    $nc = $_ctx['nc'];

?>
<style type="text/css">
    .<?=$nc?> {
        margin: 10px 0;
    }
    .<?=$nc?> A {
        display: inline-block;
        padding: 2px 4px;
        margin: 0px 3px;
        border: 1px solid lightgrey;
        text-align: center;
        min-width: 50px;
    }
    .<?=$nc?>-item, .<?=$nc?>-item .<?=$nc?> {
        display: inline-table;
    }
    .<?=$nc?> A[menu="selected"] {
        border-color: black;
    }
    .<?=$nc?> A:hover {
        border-color: grey;
    }
    .<?=$nc?> A[nohref] {
        opacity: .5;
    }
</style>
<?
    if (!is_callable('_testMenu')) {
        function _testMenu($menuData, $nc){
            $html = '';
            foreach($menuData as $menu) {
                if (is_string($menu)) $menu = array($menu);

                $href = $menu[0];
                if (is_string($href)) $href = '/'.ltrim($href, '/');
                $hrefAttr = $href ? 'href="'.$href.'"' : 'nohref';

                $text = prop($menu, 1, ltrim($href, '/'));

                $title = prop($menu, 2);
                $titleAttr = $title ? 'title="'.$title.'"' : '';

                $selected = pagePath === $href;
                $selectedAttr = $selected ? 'menu="selected"' : '';

                $htmlItem = "<a $hrefAttr $titleAttr $selectedAttr>$text</a>";


                if ($subMenu = prop($menu, 3)) {
                    $htmlItem .= "\r\n";
                    $htmlItem .= _testMenu($subMenu, $nc);
                }

                $html .= "<sub class=\"$nc-item\">$htmlItem</sub>";
            }
            return "<div class=\"$nc\">$html</div>";
        }
    }
?>
<?= _testMenu($menuData, $nc)?>