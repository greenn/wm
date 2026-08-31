http://vmk.loc/kot/iq/install.php
http://kod.nadube/metro-targets/iq/install.php?rebuild
http://kod.nadube/metro-targets/iq/test/db-table-test.php?rebuild



-	-	-	-	rep

$nSF = $Self::nc('SF'); //station-freq
$nPSF = $Self::nc('P-SF'); //passes--station-freq
station-freq

-	-	-	-	provide

kot/r/target-tpl/provide/target-tpl.js.inc
kot/r/ui/provide/field-validate.js.inc

-	-	-	-


$update = $post_fields =
$except_fields = array('uid', 'date');
mc::item_pickFields('targets-list', $post, $except_fields);


-	-	-	-	dbg
_rp('tpl-passes--station-freq', 'validateItems')
_rp('ui')
_r.pick('target-view', 'targets')
_r.pick('target-constructor', 'list')
_cc(_rr._list['target-constructor'].reslist);
_Targets.getters.getItem('10000').forecast
_Targets.getters.getList()


-	-	-	-	info

mc::db_current(),
	pro::$cfg,
	pro::cfg_get('db-struct-data')



-	-	-	-	kot test
	-	-	icons
		kot/iq/test/icons.php

-	-	-	-	vue
	-	-	test api
		kot/iq/test/api.php
	-	-	transition
		r/rb/vue/test/transition/index.php
		r/rb/vue/test/transition/styles.css.php

    	r/rb/vue/test/transition/eg.php

-	-	-	-	qp
php/parser/strTabMenuParser.class.php



-	-	-	-	db
http://vmk.loc/kot/iq/install.php?rebuild


-	-	-	-	api
http://vmk.loc/api/kot/ui/select-station
http://vmk.loc/api/kot/ui/select-time-preset

http://vmk.loc/api/kot/targets/tpl-info
http://vmk.loc/api/kot/target-tpl/stations
http://vmk.loc/api/post/kot/targets/create?fields[name]=test-1&emu=true
http://vmk.loc/api/post/kot/targets/copy?id=10000
http://vmk.loc/api/post/kot/targets/copy?id=10980

forecast-agregate
http://vmk.loc/api/post/kot/targets/forecast/aggregate?targets[0][id]=0&targets[0][passes_min]=0&targets[0][passes_min-fix]=false&targets[0][interval]=&targets[0][from]=2023-09-10&targets[0][to]=2023-09-10&targets[0][name]=passes/passes-qy&targets[1][id]=2&targets[1][passes_min]=5&targets[1][passes_min-fix]=true&targets[1][interval]=last-7d&targets[1][from]=2023-09-03&targets[1][to]=2023-09-10&targets[1][name]=passes/passes-qy&targets[1][interval-fix]=true&targets[2][id]=3&targets[2][passes_min]=4&targets[2][passes_min-fix]=false&targets[2][interval]=last-7d&targets[2][station][]=504&targets[2][station-fix]=true&targets[2][to]=2023-09-10&targets[2][from]=2023-09-03&targets[2][name]=passes/station-freq&targets[2][interval-fix]=true
	http://vmk.loc/api/post/kot/targets/forecast/aggregate?targets[0][id]=2&targets[0][passes_min]=5&targets[0][passes_min-fix]=true&targets[0][interval]=last-7d&targets[0][from]=2023-09-03&targets[0][to]=2023-09-09&targets[0][name]=passes/passes-qy&targets[0][interval-fix]=true&targets[1][id]=3&targets[1][passes_min]=4&targets[1][passes_min-fix]=false&targets[1][interval]=last-7d&targets[1][station][]=504&targets[1][station-fix]=true&targets[1][to]=2023-09-09&targets[1][from]=2023-09-03&targets[1][name]=passes/station-freq&targets[1][interval-fix]=true&targets[2][id]=0&targets[2][passes_min]=0&targets[2][passes_min-fix]=true&targets[2][interval]=&targets[2][from]=2023-09-10&targets[2][to]=2023-09-09&targets[2][name]=passes/passes-qy

forecast

http://vmk.loc/api/post/kot/targets/forecast?id=10000
http://vmk.loc/api/post/kot/targets/forecast/batch?id-list[]=10000&id-list[]=10020
http://vmk.loc/api/post/kot/targets/forecast/batch?id-list%5B%5D=10000&id-list%5B%5D=10020

http://vmk.loc/api/patch/kot/targets/aproove?id=10000

http://vmk.loc/api/kot/targets/list

http://vmk.loc/api/kot/targets/item?id=10000

http://vmk.loc/api/post/kot/targets/update?id=10000&fields[title]=updated-title

create
	http://vmk.loc/api/post/kot/targets/create?fields[uid]=&fields[title]=555&fields[targets][0][passes_min]=10&fields[targets][0][passes_min-fix]=false&fields[targets][0][station]=&fields[targets][0][station-fix]=true&fields[targets][0][from]=2023-08-06T19:40&fields[targets][0][from-fix]=true&fields[targets][0][to]=2023-08-13T19:40&fields[targets][0][to-fix]=true&fields[targets][0][name]=station-freq&fields[targets][1][passes_min]=15&fields[targets][1][passes_min-fix]=false&fields[targets][1][from]=2023-08-06T19:40&fields[targets][1][from-fix]=true&fields[targets][1][to]=2023-08-13T19:40&fields[targets][1][to-fix]=true&fields[targets][1][name]=passes-qy

create-target
	http://vmk.loc/api/post/kot/targets/target?target[passes_min]=10&target[passes_min-fix]=false&target[station]=&target[station-fix]=true&target[from]=2023-08-06T19:40&target[from-fix]=true&target[to]=2023-08-13T19:40&target[to-fix]=true&target[name]=station-freq

update
	http://vmk.loc/api/put/kot/targets/update?id=10000&fields[uid]=10000&fields[title]=тест2&fields[date]=14.08.2023+11:35:25&fields[aprooved]=&fields[targets][0][passes_min]=200&fields[targets][0][passes_min-fix]=0&fields[targets][0][station]=&fields[targets][0][station-fix]=&fields[targets][0][from]=2023-07-01T04:35&fields[targets][0][from-fix]=0&fields[targets][0][to]=2023-08-01T01:50&fields[targets][0][to-fix]=0&fields[targets][0][id]=1&fields[targets][0][name]=station-freq&fields[targets][1][passes_min]=55&fields[targets][1][passes_min-fix]=0&fields[targets][1][from]=2023-07-01T04:35&fields[targets][1][from-fix]=0&fields[targets][1][to]=2023-08-01T01:50&fields[targets][1][to-fix]=0&fields[targets][1][id]=2&fields[targets][1][name]=passes-qy&fields[targets][1][station]=&fields[targets][1][station-fix]=&fields[aproovedTitle]=Не+согласован


-	-	-	-	db
http://vmk.loc/kot/iq/install.php
http://vmk.loc/kot/iq/install.php?rebuild
http://vmk.loc.ru/kot/iq/install.php

kot/iq/test/db-date.php
kot/iq/test/db-targets.php


kot/iq/test/icons.php



http://vmk.loc/api/kot/side-menu/list?by=link

<keep-alive>
	<component :is="viewName"></component>
</keep-alive>

<?//=kot_i::img('assets/moskot_vert_sign.svg')?>

js::wreq('mq.jq')

/r/rb/vue/test/transition/




-	-	-	-	db

http://vmk.loc/kot/iq/install

-	-	-	-	crud (prev)
php/crud_json.struct
php/crud_json.php

php/response.struct
php/response.php



-	-	-	-	test
iq/test/php/mysql.php
kot/iq/test/date.php

=	=	=	=
==	=	=	=


http://vmk.loc/wd/header

http://vmk.loc/iq/config/install/
http://vmk.loc/katalog/112



http://granitplace.ru/iq/install/db-connect.php

wd/header

-	-	-	-

._/man/web page


=	=	=	=	b1
-	-	-	-
index.php
site/uc/titul.tpl.php
iq/config/router.php
._/bd/pid/1/0411.pid.php
iq/config/router/http-404.php
site/uc/404.tpl.php
site/uc/uc.class.inc
site/uc/content.tpl.php
rb/page/css/aq.css.php
site/uc/titul.tpl.php
site/logo/logo-header.tpl.php

iq/config/pages/index.inc
iq/config/pages/404.inc
site/uc/uc.css.php
iq/config/pages/dev-blog.inc
iq/config/pages/dev/tlk.inc
iq.inc
iq/config/pages/blog.inc
iq/php/_pid.class.php
site/wd/wd.css.php
site/eg-logo/pik-logo.css.php
site/wd/y-dev-process.tpl.php
site/eg-logo/pik-logo.tpl.php
site/wd/index.tpl.php
site/wd/tlk.tpl.php
site/wd/tlk/0508.sageGpt.re.txt
site/wd/tlk/0508.sageGpt.tsk.txt
iq/config/settings/settings[gildia.nadube.ru].inc
iq/config/web/web[gildia.nadube.ru].inc
models-price/ib/index.php
iq/php/_router.class.php
models-price/app.tpl.php
iq/config/router/page.php


rb/lay/flex.css.php
._/hp/struct.legend
._/man/web project
iq/config/iq.cfg.inc
iq/config/domains.inc

-	-	-	-
site/menu/footer-menu.css.php
iq/config/-data/site_page.php

api
	http://gettbot.loc/api/about/titul-chart
	http://gettbot.loc/api/site/about/titul-chart

charts
	http://gettbot.loc/test/charts-js/1.php
	http://gettbot.loc/test/charts-js/2.php
	http://gettbot.loc/test/charts-js/about-demo.php
	http://gettbot.loc/test/charts-js/titul-chart.php
	http://gettbot.loc/test/charts-js/data-chart.php



links
	http://gettbot.loc/dev/acc/




page
	print site('page', 'pid', 'landing'); // landing/landing.tpl.php
	print site('page', 'html', 'uc', 'uc1'); // uc/uc1.tpl.php


php-oo
	http://gettbot.loc/iq/test/php/dataPath.php

dd-oo
	iq/config/-data/site_pages_config.php


dev/orbit-svg
	http://gettbot.loc/dev/orbit-svg/
	http://gettbot.io/dev/orbit-svg/

http://gettbot.loc/iq/test/css/3d/cube.php

site/space/test/orbit.php



iq/install/index.php

test
	iq/test/css/flex/column-wrap.php
	iq/test/php/faq/var-name.php


	iq/test/css/animate-css/index.php

css lib csshake
	css/csshake/1.7.0/docs/index.html

-	-	-	-	wd
intro
header
	http://gettbot.loc/wd/header?res
	http://gettbot.loc/wd/header-m-close?res
	http://gettbot.loc/wd/header
	http://gettbot.loc/wd/header?res&oo
	http://gettbot.loc/wd/header-m?oo
	http://gettbot.loc/wd/header-m-close?oo
	http://gettbot.loc/wd/header?res

footer
	http://gettbot.loc/wd/footer-m?oo
	http://gettbot.loc/wd/footer?embody

-	-	-	-	header/footer /pre-tpl

<div class="<?=$n?> site-p">
    <div indent="<?=$n?>-top"></div>
    <div class="site-w">
        <div fxr class="<?=$n?>-w">
        </div>
    </div>
    <div indent="<?=$n?>-bottom"></div>
</div>


-	-	-	-
<?=_svg::img('1.svg', 'style="width: 200px"')?>
<?=_svg::img('4.svg', 'style="width: 200px"')?>

[lay] {
    outline: 1px dashed aqua;
}

<? if (!PCSS_DEV_MODE) { ?>
<? } ?>