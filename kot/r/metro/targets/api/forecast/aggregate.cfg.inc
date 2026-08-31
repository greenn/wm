<?

if (isLocalhost) targets_aggregate::$perDay = 500000;
targets_aggregate::$curCoverage = targets_aggregate::$perDay;

//Таблица 4 - стр.64(67)
targets_aggregate::$map_passenger = array(
	'reg' => array(#+
		'registrationDateTimeInterval' => 'interval',
		//'registrationDateTimeFrom' => 'regFrom',
		//'registrationDateTimeTo' => 'regTo',
		'allRegisteredPassengers' => 'flag', //regHas
	),
	'bio' => array(#+
		'passengerSex' => 'value', //sex ~ select
	),
	'age' => array(#+
		'passengerAgeFrom' => 'numFrom', //ageFrom
		'passengerAgeTo' => 'numTo', //ageTo
	),
	'tech' => array(#+
		'passengerDevice' => 'list', //device ~ multi-select
	),
	'acc' => array(#+
		'lastActivityDateTimeInterval' => 'interval', //loginInterval
		//'lastActivityDateTimeFrom' => '', //loginFrom
		//'astActivityDateTimeTo' => '', //loginTo
	),
);

//Таблица 5 - стр.65(68)
targets_aggregate::$map_card = array(
	'card-type' => array(#+
		'cardType' => 'list', //cardType ~ multi-select
	),
	'card-factor' => array(#+
		'cardFormFactor' => 'list', //cardFactor ~ multi-select
	),
	'card-status' => array(#+
		'cardStatus' => 'value', //cardStatus ~ select
	),
	'pers-exist' => array(#+
		'hasPersonifiedCard' => 'flag',
	),
	'pers-qy' => array(#+
		'personifiedCardsNumFrom' => 'numFrom', //persFrom
		'personifiedCardsNumTo' => 'numTo', //persTo
	),
	'pers-on' => array(#+
		'personificationDateTimeInterval' => 'interval',
		//'personificationDateTimeFrom' => 'persStartFrom',
		//'personificationDateTimeTo' => 'persStartTo',
	),
	'pers-off' => array(#+
		'unpersonificationDateTimeInterval' => 'interval',
		//'unpersonificationDateTimeFrom' => 'persEndFrom',
		//'unpersonificationDateTimeTo' => 'persEndTo',
	),

	'ticket-type' => array(#+
		'ticketType' => 'list', //ticketType ~ multi-select
	),
	'ticket-design' => array(#+
		'cardDesign' => 'list', //cardDesign ~ multi-select
	),
);

//Таблица 6 - стр.67(70)
targets_aggregate::$map_sale = array(
	'sale' => array(#+
		'saleDateTimeInterval' => 'interval',
		//'saleDateTimeFrom' => '',
		//'saleDateTimeTo' => '',
	),
);

//Таблица 7 - стр.68(71)
targets_aggregate::$map_place = array(
	'transport' => array(#+
		'carrier' => 'list', //transportType
	),
	'equipment' => array(#+
		'deviceType' => 'list', //operationEquipment / type
	),
	'operation' => array(#~
		'operationPlace' => 'list', //operationLocation
	),

);

//Таблица 8 - стр.69(72)
targets_aggregate::$map_passes = array(
	'passes-qy' => array(#-
		'passesNum' => 'qy', //passes_min
		'passesInterval' => 'interval',
		//'passesPeriodFrom' => 'from',
		//'passesPeriodTo' => 'to',
	),
	'station-freq' => array(#+
		'frequentStations' => array('src' => 'list', 'glue' => ',',
            'pair' => array('frequentStation', 'frequentStationPassesNum')
		),
		//'frequentStationPassesNum' => 'qy', //passes_min
		'frequentStationPassesInterval' => 'interval',
		//'frequentStationPassesPeriodFrom' => 'from',
		//'frequentStationPassesPeriodTo' => 'to',
	),
	'route-ngpt' => array(#-
		'frequentGroundRouteTransports' => array('src' => 'list', 'glue' => ',',
            'pair' => array('frequentGroundRouteTransport', 'frequentGroundRouteNumber', 'frequentGroundRoutePassesNum')
		),
		//frequentGroundRouteTransport => '',
		//frequentGroundRouteNumber => '',
		//frequentGroundRoutePassesNum => 'qy',
		'frequentGroundRoutePassesPeriodInterval' => 'interval',
		//'frequentGroundRoutePassesPeriodFrom' => 'from',
		//'frequentGroundRoutePassesPeriodTo' => 'to',
	),
	'station-mcd' => array(#+
		//'frequentMccStation' => '',
		//'frequentMccStationPassesNum' => 'qy', //passes_min
		'frequentMccStations' => array('src' => 'list', 'glue' => ',',
            'pair' => array('frequentMccStation', 'frequentMccStationPassesNum')
		),
		'frequentMccStationPassesPeriodInterval' => 'interval',
		//'frequentMccStationPassesPeriodFrom' => 'from',
		//'frequentMccStationPassesPeriodTo' => 'to',
	),
);

//Таблица 9 - стр.71(74)
targets_aggregate::$map_restore = array(
	'rebalance' => array( #+
		'restoreRequestDateTimeInterval' => 'interval',
		//'restoreRequestDateTimeFrom' => 'rebalanceFrom',
		//'restoreRequestDateTimeTo' => 'rebalanceTo',
	),
	'rebalance-time' => array(#+
		'restoreProcessDateTimeInterval' => 'interval',
		//'restoreProcessDateTimeFrom' => 'rebalanceDateFrom',
		//'restoreProcessDateTimeTo' => 'rebalanceDateTo',
	),
	'rebalance-reason' => array(#+
		'restoreByLkp' => 'flag', //rebalanceRequest
	),
);

//Таблица 10 - стр.72(75)
targets_aggregate::$map_write = array(
	'balance' => array(#+
		'writeDateTimeInterval' => 'interval',
		//'writeDateTimeFrom' => 'topupFrom',
		//'writeDateTimeTo' => 'topupTo',
	),
);

//Таблица 11 - стр.73(76)
targets_aggregate::$map_topup = array(
	'time' => array(#+
		'topupDateTimeInterval' => 'interval',
		//'topupDateTimeFrom' => 'topupFrom',
		//'topupDateTimeTo' => 'topupTo',
	),
	'sum' => array(#+
		'topupAmountFrom' => 'numFrom',
		'topupAmountTo' => 'numTo',
	),
);

//Таблица 12 - стр.74(77)
targets_aggregate::$map_helpdesk = array(
	'ticket' => array(#+
		'helpdeskDateTimeInterval' => 'interval',
		//'helpdeskDateTimeFrom' => '',
		//'helpdeskDateTimeTo' => '',
	),
);

//Таблица 13 - стр.75(78)
targets_aggregate::$map_services = array(
	'usage' => array(#+
		'serviceName' => 'list', //type ~ multi-select
		'serviceDateTimeInterval' => 'interval',
		//'serviceDateTimeFrom' => '',
		//'serviceDateTimeTo' => '',
	),
);

//Таблица 14 - стр.76(79)
targets_aggregate::$map_message = array(
	'feedback' => array(#+
		'messageDateTimeInterval' => 'interval',
		//'messageDateTimeFrom' => '',
		//'messageDateTimeTo' => '',
		'messagesNumFrom' => 'numFrom',
		'messagesNumTo' => 'numTo',
	),
);
