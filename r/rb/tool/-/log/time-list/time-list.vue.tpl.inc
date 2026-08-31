<?
$Self = _rw::name($self_nc = 'tool-log');
$nLT = $Self::nc('time-list');

//_source::req_cmpt('rw', $self_nc, 'list-filter', 2);
//_source::req_cmpt('rw', $self_nc, 'list-filter-v1', 2);
//_source::req_cmpt('rw', $self_nc, 'list-filter-v2', 2);

rb('vue', 'req', 's-toggle');
?>
<div class="<?=$nLT?>">
    <!--
    <list-filter></list-filter>
    <list-filter-v1></list-filter-v1>
    <list-filter-v2></list-filter-v2>
    -->
    <div
        v-for="(rec, index) in list"
        :key="index"
        :item="rec"
    >
        <div class="<?=$nLT?>-rec-headline">
            <s-toggle @open="rec.open = true; $forceUpdate()" @close="rec.open = false; $forceUpdate()"></s-toggle>
            <span date>{{ rec.date }}</span>
            <span url>{{ rec.url }}</span>

            <div v-show="rec.open" class="<?=$nLT?>-rec">
                <div
                    class="<?=$nLT?>-item"
                    v-for="(item, index2) in rec.items"
                    :key="index2"
                    :type="item.type"
                >
                    <div class="<?=$nLT?>-item-headline">
                        <s-toggle @open="item.open = true" @close="item.open = false" :state="item.open"></s-toggle>
                        <span>{{ item.line }}</span>
                    </div>
                    <div class="<?=$nLT?>-item-title" v-show="item.open">
                        <s-toggle @open="item.show = true" @close="item.show = false"></s-toggle>
                        <span time>{{ item.passedTime }}</span>
                        <span msg>{{ item.msg }}</span>
                    </div>
                    <div class="<?=$nLT?>-item-content" v-html="item['ctx-html']" v-show="item.open && item.show"></div>
                </div>
            </div>
        </div>
    </div>

    <div>time-list</div>
</div>