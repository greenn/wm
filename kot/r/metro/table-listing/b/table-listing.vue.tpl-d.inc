<?
$Self = _kot::self();
$n = $Self::nc();
$Self::req_css('table-listing');
//_kot::req_vue('targets', 'targets-list');
//$Self::req_vue('modal-button', array(), 'modal-button'); //tpl-name, tpl-ctx, tag-name
$Self::req_vue('modal-button');

_kot::req_vue('ui', 'table-handler');


?>
<?/*
    <request-bar :tick="updateTime"></request-bar>
*/?>
<div class="<?=$n?>-w">

    <table-handler :total="totalItems" :busy="busy"></table-handler>

    <div r osx class="<?=$n?>-table-w" :class="{ '-busy': busy }">
        <busy-area a="ltrb" :busy="busy" @extra-close="busy = false"></busy-area>

        <table class="<?=$n?>-table ft-small">
            <tr>
                <th v-for="th in [
                  { title: '' },
                  { title: 'ID' },
                  { title: 'Наименование' },
                  { title: 'Обновлено' },
                  { title: 'Статус' },
                  { title: '' },
                  { title: '' },
                  { title: '' },
                  { title: '' },
                ]" class="-bld">
                    <div>{{ th.title }}</div>
                </th>
            </tr>

            <tr v-for="(item, index) in items" :key="item.uid"
                :class="[index % 2 ? '-odd' : '-even', { '-selected': tr_selected === index }]"
                @click="tr_selected = index"
            >
                <td>
                    <modal-button :item="item"
                        <?//@onModalOpen="closeOthersModal(item.uid)"?>

	                    <?//onDelete="listRemove($event)"?>
	                    @onDelete="$emit('onDelete', $event)"

                        <?//@onCopy="linkRel($event.uid)"?>
                        @onCopy="linkAdd($event)"
                    ></modal-button>
                </td>
                <td>
                    <div>
                        <a class="link" @click="linkRel(item.uid)">{{ item.uid }}</a>
                    </div>
                </td>
                <td>{{ item.title }}</td>
                <td>{{ item.date }}</td>

                <td>{{ item.aprooved ? 'на согласовании' : 'не согласован' }}</td>
                <td>{{ item.type }}</td>
                <td>{{ item.aim }}</td>
                <td>{{ item.name }}</td>
                <td>{{ item.channel }}</td>

            </tr>

        </table>
    </div>

    <table-handler :total="totalItems" :busy="busy"></table-handler>

</div>