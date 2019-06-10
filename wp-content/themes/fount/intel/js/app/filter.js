/**
 * Created by ARslan on 12/15/2017.
 */

oRsc.runFilter = function(){
    $('#nav-filter').val('Custom');
    
    oRsc.queryAll();
    //oRsc.overlayReports();
         return; };



oRsc.getFormattedDate = function (dateStr, format) {
    var date = new Date(dateStr),
        fullYear = date.getFullYear(),
        year = fullYear.toString().substr(2, 2),
        month = date.getMonth(),
        monthDigits = (month < 9 ) ? '0' + (month + 1) : (month + 1),
        monthShortName = this.monthNames[month],
        day = (date.getDate() < 10 ) ? '0' + date.getDate() : date.getDate(),
        formattedDate;

    switch (format) {
        case 'M d, yy':
            formattedDate = monthShortName + ' ' + day + ', ' + fullYear;
            formattedDate = monthShortName + ' ' + day + ', ' + fullYear;
            break;
        case 'ddMy':
            formattedDate = day + monthShortName + year;
            break;
        case 'yy-mm-dd':
            formattedDate = fullYear + '-' + monthDigits + '-' + day;
            break;
        case 'dd-mm-yy':
            formattedDate = day + '-' + monthDigits + '-' + fullYear;
            break;
        case 'dd-M':
            formattedDate = day + '-' + monthShortName;
            break;
        default://dd-M-yy
            formattedDate = day + '-' + monthShortName + '-' + fullYear;
            break;
    }

    return formattedDate;
};