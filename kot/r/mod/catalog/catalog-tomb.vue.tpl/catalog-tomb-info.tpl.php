<?
$Self = _kmod::self();
$nTI = $Self::nc('TI'); //tombs-item
//$_ctx = $Self::tempCtx(array());
?>

    <div fxr="sb">
        <div mr6>номер:</div>
        <div txc>{{ id }}</div>
        <div ml6>
            <ui-button small b-button @click="rebuildItem">
                перестроить
            </ui-button>
        </div>

    </div>
    <template v-if="!ready">
        <div>- нет данных -</div>
    </template>
    <template v-else-if="busy.rebuild">
        <div>- обновление -</div>
    </template>
    <template v-else-if="ready">
        <div fxr>
            <div wp50 mr6>pic:</div>
            <div fxr>
                <span v-for="picName in info.pics" mr4>
                    {{ picName }}
                </span>
            </div>
        </div>
        <div fxr>
            <div wp50 mr6>размеры:</div>
            <div>{{ info.sizes ? info.sizes.length : '-нет-' }}</div>
        </div>
        <div fxr>
            <div wp50 mr6>описание:</div>
            <div>{{ info.description ? info.description.length : '-нет-' }}</div>
            <div>{{ info.annotation ? info.annotation.length : '-нет-' }}</div>
        </div>
        <div fxr>
            <div wp50 mr6>keywords:</div>
            <div>{{ info.keywords ? info.keywords.length : '-нет-' }}</div>
        </div>
        <div fxr>
            <div wp50 mr6>3D:</div>
            <div>{{ info._3d ? info._3d.length : '-нет-' }}</div>
        </div>

        <div a="br" wp50 hp50 :style="{
            'background': `url('${pic}') no-repeat center`,
            'background-size': `contain`,
        }"></div>
    </template>


