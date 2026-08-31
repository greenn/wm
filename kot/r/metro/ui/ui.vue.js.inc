<?
$Self = _kot::self();

/*
    http://vmk.loc/api/get/kot/ui/select-card-type
*/
$js =  array();
$js['select-station'] = $Self::path('apis/select-station.js.inc');
$js['select-mcd'] = $Self::path('apis/select-mcd.js.inc');
$js['select-ngpt'] = $Self::path('apis/select-ngpt.js.inc');
$js['select-ngpt-station'] = $Self::path('apis/select-ngpt-station.js.inc');
$js['select-time-preset'] = $Self::path('apis/select-time-preset.js.inc');
$js['select-sex'] = $Self::path('apis/select-sex.js.inc');
$js['select-cardType'] = $Self::path('apis/select-card-type.js.inc');
$js['select-cardFactor'] = $Self::path('apis/select-card-factor.js.inc');
$js['select-cardStatus'] = $Self::path('apis/select-card-status.js.inc');
$js['select-ticketType'] = $Self::path('apis/select-ticket-type.js.inc');
$js['select-ticketDesign'] = $Self::path('apis/select-ticket-design.js.inc');
$js['select-equipment'] = $Self::path('apis/select-equipment.js.inc');
$js['select-carrier'] = $Self::path('apis/select-carrier.js.inc');
$js['select-passengerDevice'] = $Self::path('apis/select-passenger-device.js.inc');
$js['select-service'] = $Self::path('apis/select-service.js.inc');

$Self::req_js('ui.vue-ext');
?>


_vue('ui', function(_log, _cmd){

    return {
        template: ' ',

        _vue: {
            //provide: [],
        },

        data(){
            return {
                selectStation: false,
                selectStationById: false,

                selectTimePreset: false,
                selectTimePresetInfo: false,

                selectNgpt: false,
                selectNgptById: false,

                selectNgptStation: false,
                //selectNgptStationById: false,

                selectMcd: false,
                selectMcdById: false,

                selectCardFactor: false,
                selectCardFactorById: false,

                selectCardStatus: false,
                selectCardStatusById: false,

                selectCardType: false,
                selectCardTypeById: false,

                selectCarrier: false,
                selectCarrierById: false,

                selectEquipment: false,
                selectEquipmentById: false,

                selectPassengerDeviceSex: false,
                selectPassengerDeviceById: false,

                selectService: false,
                selectServiceById: false,

                selectSex: false,
                selectSexById: false,

                selectTicketDesign: false,
                selectTicketDesignById: false,

                selectTicketType: false,
                selectTicketTypeById: false,
            }
        },

        methods: {

            <? include $js['select-station'] //selectStation_getOptions(), -selectStation_setColorData() ?>

            <? include $js['select-ngpt'] //selectNgpt_getOptions() ?>

            <? include $js['select-ngpt-station'] //selectNgptStation_getOptions() ?>

            <? include $js['select-mcd'] //selectMcd_getOptions() ?>

            <? include $js['select-time-preset'] //selectTimePreset_getOptions() ?>

            <? include $js['select-sex'] //selectSex_getOptions() ?>

            <? include $js['select-cardType'] //selectCardType_getOptions() ?>

            <? include $js['select-cardFactor'] //selectCardFactor_getOptions() ?>

            <? include $js['select-cardStatus'] //selectCardStatus_getOptions() ?>
            
            <? include $js['select-ticketType'] //selectTicketType_getOptions() ?>

            <? include $js['select-ticketDesign'] //selectTicketDesign_getOptions() ?>

            <? include $js['select-equipment'] //selectEquipment_getOptions() ?>

            <? include $js['select-carrier'] //selectCarrier_getOptions() ?>

            <? include $js['select-service'] //selectService_getOptions() ?>

            <? include $js['select-passengerDevice'] //selectPassengerDevice_getOptions() ?>

        },


        mounted() {
            //_log('mounted');
        }
    }
})