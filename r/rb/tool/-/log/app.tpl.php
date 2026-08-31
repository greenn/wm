<?

$self_nc = 'tool-log';
$Self = _rw::name($self_nc);
$nAp = $Self::nc('app');

_rb::req_css('lay', 'flex');
css::req('rw', $self_nc, 'tool.css.php');
js::req('rw', $self_nc, 'tool.js.php');

//rb('vue', 'req', 's-toggle');

//step: добавление внутренних компонент '
//step: добавляем внутренние компоненты
foreach (array(
	'url-list' => 2, //vue: css + js
	'time-list' => 2,
	'start-date' => 2,
	//'list-filter-v1' => 2, //1
	//'list-filter-v2' => 2, //1
	'request-bar' => 2,
) as $cmpt => $set) {
	_source::req_cmpt('rw', $self_nc, $cmpt, $set);
}

?>
<?=kint_source()?>
<div id="app-tool" class="<?=$nAp?>">
    <request-bar :tick="updateTime"></request-bar>
    <h1 ta="c" class="<?=$nAp?>-headline">Log tool</h1>
	<div>
        <section name="start-date" tc>
            <div>
                <div >
                    <span time="passed">passedTime: {{ passedTime }}</span>
                    <button @click="resetStartTime">reset</button>
                </div>
                <div >
                    startTime:
                    <span time="start-info">{{ startTimeFormat }}</span>
                    <span time="start">{{ startTime }}</span>
                </div>
                <div indent style="height: 10px;"></div>
            </div>

            <start-date :start-time="startTime" @on-change="startTime = $event"></start-date>
        </section>

        <section name="pane">
            <div tc>
                <label>Update interval</label>
                <input type="text" v-model="updateInterval" />
            </div>
            <button @click="dataUpdate">update</button>
            <button @click="testLog">test log</button>
        </section>

        <section list="url">
			<url-list></url-list>
		</section>
		<section list="time">
            <time-list :log-data="logData"></time-list>
		</section>
	</div>
</div>