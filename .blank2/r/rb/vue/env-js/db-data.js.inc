<?
    _needphp('json/jsonPrettyEncode');

    $db = array();
    include 'db/clients.data.inc';
    include 'db/bookings.data.inc';
    include 'db/licenses.data.inc';
    include 'db/cards.data.inc';
    include 'db/passports.data.inc';

?>

const DbData = <?=jsonPrettyEncode($db)?>;


var db_rebuild = function(){
    _.each(DbData, function(data, table){
        //var table_nm = table + dbSuffix;
        Store.set([dbSuffix, table], data)
    })
};
var db_verify = function(){
    var updated = false;
    _.each(DbData, function(data, table){
        //var table_nm = table + dbSuffix;
        var cur_data = Store.get([dbSuffix, table]);
        if (!cur_data) {
            console.log('DB:VERIFY', [table, cur_data, data])
            Store.set([dbSuffix, table], data)
            updated += true;
        }
    })
    if (updated) location.reload();
};

<? if (0) { ?>
var DbInitedNm = 'db_inited' + dbSuffix;
if (!Store.get(DbInitedNm)) {
    console.log('DBSET', DbData);
    db_rebuild();
    Store.set(DbInitedNm, true);
}
<? } ?>