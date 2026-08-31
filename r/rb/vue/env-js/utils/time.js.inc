<?/*eg
    _getCurrentDateTime({ week: -1 }, true),
*/?>
function _getCurrentDateTime(ext, format, dateValue){

    if (dateValue === true) dateValue = _getCurrentDateTime.last;

    var now = dateValue || new Date();
    now.setUTCHours(now.getUTCHours() + 3); // Добавляем 3 часа к текущему времени UTC
    //console.log(dateUC3.toISOString()); // Выведет текущую дату и время в UTC+3
    _.each(ext, function(val, prop){
        switch(prop) {
            case 'sec': {
                now.setSeconds(now.getSeconds() + val);
            } break;
            case 'min': {
                now.setMinutes(now.getMinutes() + val);
                //now.setSeconds(now.getSeconds() + val*60);
            } break;
            case 'hour': {
                now.setHours(now.getHours() + val);
            } break;
            case 'day': {
                now.setDate(now.getDate() + val);
            } break;
            case 'week': {
                now.setDate(now.getDate() + val*7);
            } break;
            case 'month': {
                now.setMonth(now.getMonth() + val);
                //now = subMonths(now, -val); //npm 'date-fns'
            } break;
            case 'year': {
                now.setFullYear(now.getFullYear() + val);
            } break;
        }
    })
    _getCurrentDateTime.last = now;

    return format ? _formatDateTime(now, format) : now;
};
_getCurrentDateTime.date = undefined;


function _formatDateTime(_Date, format){
    if (format === true) format = 'ISO 8601';
    var res = _Date;
    switch (format) {
        case 'date': {
            res = _formatDate(_Date, 'Y-M-D')
        } break;
        case 'datetime-local': case 'datetime': case 'ISO 8601': {
            res = _Date.toISOString().slice(0, 16);
        } break;
        default: {
            res = _formatDate(_Date, format)
        }
    }
    return res;
}

function _formatDate(date, pattern) {
    var _Date = date instanceof Date ? date : new Date(date);

    /*const day = String(_Date.getDate()).padStart(2, '0');
    const month = String(_Date.getMonth() + 1).padStart(2, '0');
    const year = _Date.getFullYear();
    const hours = String(_Date.getHours()).padStart(2, '0');
    const minutes = String(_Date.getMinutes()).padStart(2, '0');*/
    //return `${day}.${month}.${year} ${hours}:${minutes}`;

    const patternMapping = {
        'Y': _Date.getFullYear(),
        'M': String(_Date.getMonth() + 1).padStart(2, '0'),
        'D': String(_Date.getDate()).padStart(2, '0'),
        'H': String(_Date.getHours()).padStart(2, '0'),
        'i': String(_Date.getMinutes()).padStart(2, '0'),
        's': String(_Date.getSeconds()).padStart(2, '0')
    };

    return pattern.replace(/(Y|M|D|H|i|s)/g, function(match){ return patternMapping[match] });
}
