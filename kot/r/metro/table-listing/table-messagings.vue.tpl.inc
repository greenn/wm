<?
$Self = _kot::self();
$n = $Self::nc();
$Self::req_css('table-listing');
//_kot::req_vue('targets', 'targets-list');
//$Self::req_vue('modal-button', array(), 'modal-button'); //tpl-name, tpl-ctx, tag-name
$Self::req_vue('modal-messagings');

_kot::req_vue('ui', 'table-handler');
_kot::req_vue('target-tpl', 'target-view-info');

?>
<?/*
    <request-bar :tick="updateTime"></request-bar>
*/?>
<div class="<?=$n?>-w">

    <?//<pre>totalItems: {{ totalItems }}</pre>?>
    <table-handler :total="totalItems" :busy="busy"></table-handler>

    <div r osx class="<?=$n?>-table-w" :class="{ '-busy': busy }">
        <busy-area a="ltrb" :busy="busy" @extra-close="busy = false"></busy-area>

        <table class="<?=$n?>-table ft-small">
            <tr>
                <th v-for="th in [
                  { title: '' },
                  { title: 'ID' },
                  { title: 'Название рассылки' },
                  { title: 'Обновлено' },
                  { title: 'Статус' },
                  { title: 'Тип оповещения' },
                  { title: 'Цель рассылки' },
                  { title: 'Канал информирования' },
                  { title: 'Обязательность информирования' },
                  { title: 'Отправлено' },
                  { title: 'Шаблон рассылки' },
                ]" class="-bld">
                    <div>{{ th.title }}</div>
                </th>
            </tr>

            <tr v-for="(item, index) in items" :key="item.uid"
                :class="[index % 2 ? '-odd' : '-even', { '-selected': tr_selected === index }]"
                @click="tr_selected = index"
            >
                <td>
                    <modal-messagings :item="item"></modal-messagings>
                </td>
                <td>
                    <div>
                        <a class="link" @click="linkRel(item.uid)">{{ item.uid }}</a>
                    </div>
                </td>

                <td>{{ item.title }}</td>

                <td>{{ item.date }}</td>

                <td nobr>{{ item.statusTitle }}</td>

                <td>{{ item['bulk-type']}}</td>

                <td>{{ item['bulk-aim']}}</td>

                <td>{{ item['channel']}}</td>

                <td>
                    {{ item.req ? 'Да' : 'Нет' }}
                </td>

                <td>{{ item['sent']}}</td>

                <td>{{ item['tpl']}}</td>

            </tr>

        </table>
    </div>

    <table-handler :total="totalItems" :busy="busy"></table-handler>

</div>