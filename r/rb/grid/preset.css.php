<?#3.1.0
    include_once $_SERVER['DOCUMENT_ROOT'].'/site/iq.inc';
    _needphp('pcss');
     _needphp('css/dec');
    //_needphp('css/image1px');

    $Self = self_rp();
    $nG = $Self::nc();

    $tr = data_css('tr0');

    //выполняем cssTpl заранее, чтобы подхватить etag-ctx
    $site_cols2_sz1 = $Self::cssTpl('grid', array(
        'ng' => $nG.'[mq="site"][cols="2"][sz="1"]',
        'cols' => 2,
        'wx' => null,
        'wxI' => 450,
        's' => '5vw',
        'svsHalf' => true,

        'mq_' => array(
            array(MQ1, array(
                'cols' => 2,
                'sh' => '3vw',
                'sv' => '4vw',
                'shsHalf' => true,
            )),
            array(MQ2C, array(
                'cols' => 1,
                'sh' => 1,
                'sv' => '5vw',
                'ss' => false,
            )),
        ),
    ));

    $site_cols3_sz1 = $Self::cssTpl('grid', array(
        'ng' => $nG.'[mq="site"][cols="3"][sz="1"]',
        'cols' => 3,
        'wx' => null,
        'wxI' => 450,
        's' => '2vw',
        'svsHalf' => true,
        'shs' => true,

        'mq_' => array(
            array(MQ1, array(
                'cols' => 3,
                'sh' => '1vw',
                //'sv' => '4vw',
                'shs' => true,
            )),
            array(MQ2B, array(
                'cols' => 2,
                's' => '2vw',
            )),
            array(MQ2, array(
                'cols' => 1,
                'sh' => 0,
                'sv' => '5vw',
            )),
        ),
    ));

    headers('css', 'utf8', 'nosniff', etag::ctx(
        pcss_etag_ctx('transition'),
        etag::extra(
            $nG,
            $tr
        ),
        __FILE__
    ), SITE_CACHE);

    print $site_cols2_sz1;
    print $site_cols3_sz1;

    exit;
    //L-d
?>

/*              SZ                      */
/*              sz: 1                   */

<?=$Self::cssTpl('grid/sz', array(
    'np' => $nG.'[sz="1"]',
    'w' => 1200,
    'wI' => 450,
    's' => '3vw',
))?>

/*              cols: 2                 */
<?=$Self::cssTpl('grid2', array(
    'np' => $nG.'[cols="2"]',
))?>

/*              cols: 2 / sz1           */
<?=$Self::cssTpl('grid1', array(
    'np' => $nG.'[mq="site"][cols="2"]',
    '_mq' => MQ2C
))?>

<?=$Self::cssTpl('grid/sz-cols2_', array(
    'np' => $nG.'[sz="1"][cols="2"]',
    'mq_' => array(MQ1C, MQ2C),
    'sh_' => array('2vw', '1vw', '0'),
    'sv_' => array('3vw', '3vw', '2.5vw'),
))?>



/*              cols: 3                 */
<?=$Self::cssTpl('grid3', array(
    'np' => $nG.'[cols="3"]',
))?>

/*              cols: 3 / sz1           */

<? $Self::cssTpl('grid/sz-cols3', array(
    'np' => $nG.'[sz="1"][cols="3"]',
    'sh' => '50px',
    'sv' => 50,
))?>

<? $Self::cssTpl('grid/sz-cols3_', array(
    'np' => $nG.'[sz="1"][cols="3"]',
    'mq_' => array(MQ1C, MQ2C),
    'sh_' => array('2vw', '1vw', '0'),
    'sv_' => array('3vw', '3vw', '2.5vw'),
))?>
