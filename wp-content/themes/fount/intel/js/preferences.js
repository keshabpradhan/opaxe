/**
 * Created by Shahzaib on 16/11/2018.
 */
var BASE_URL = location.protocol + "//" + location.host;
var SCRIPT_PATH = location.protocol + '/wp-content/themes/fount/intel/lib/all.php';

//get user all modes
$(document).ready(function () {
    var url = window.location.href;
    var s = url.replace(/\\/g, '/');
    s = s.substring(s.lastIndexOf('/') + 1);
    if (s.indexOf("user-profile?ihc_ap_menu=savedPreferences") >= 0) {
        getsavedpreferences();
    }
});

function getsavedpreferences() {
    $('#user-saved-preferences .container').remove();
    $("#user-saved-preferences").append('Please wait...');
    var url = SCRIPT_PATH + "?action=getSavedpreferences";
    $.ajax({
        url: url,
        type: "POST",
        dataType: "JSON",
        success: function (data) {
            if (data.success) {
                //if default mode found then list all modes in saved preferences page
                listFeatures(data.saved_preferences);
            }
            else {
                $("#user-saved-preferences").empty();
                var tabs = '';
                tabs += '<div class="container">';
                tabs += '<div class="panel panel-primary">';
                tabs += '<div class="panel-heading">Saved Preferences</div>';
                tabs += '<div class="row">';
                tabs += '<table class="table table-hover table-saved-preferences">';
                tabs += '<tbody>'
                tabs += '<span>No modes found</span>'
                tabs += '</tbody></table>';
                tabs += '</div>';
                tabs += '</div>';
                tabs += '</div>';
                $("#user-saved-preferences").append(tabs);
            }

        }
    });
}

//List all modes in saved preferences page as tabular form
function listFeatures(data) {
    $("#user-saved-preferences").empty();
    var tabs = '';
    tabs += '<div class="container">';
    tabs += '<div class="panel panel-primary" style="width:100%">';
    tabs += '<a id="delete-modes" onclick="deleteModes();"><i class="icon-trash" style="color: #7B868C;"></i>Delete selected</a>'
    tabs += '<div class="panel-heading">Saved Preferences</div>';
    tabs += '<div class="row table-row">';
    tabs += '<table class="table table-hover table-saved-preferences table-responsive">';
    tabs += '<thead>';
    tabs += '<tr>';
    tabs += '<th></th>';
    tabs += '<th style="text-align: left">Selected Filters</th>';
    tabs += '<th style="width: 100px;">Zoom Level</th>';
    tabs += '<th>Reports</th>';
    tabs += '<th>Date</th>';
    tabs += '<th style="width: 75px;">Default</th>';
    tabs += '<th style="width: 75px;">View</th>';
    tabs += '</thead>';
    tabs += '<tbody>';
    for (var i = 0; i < data.length; i++) {
        tabs += '<tr>';
        tabs += '<td><span id="preferences-id">' + data[i].id + '</span><input class="filter-checkboxes" type="checkbox" value="' + data[i].id + '"></td>';
        var filterArray = JSON.parse(data[i].filters_json);
        var filters = '';
        $.each(filterArray, function (i, item) {
            if (item.title != 'report_mode') {
                var a = item.title.split(":");
                filters += a[1];
            }
        });
        filters = filters.replace(/,/g, ', ');
        filters = filters.replace(',  ', ', ');
        var date = new Date(data[i].date),
            yr = date.getFullYear(),
            month = date.getMonth() < 10 ? '0' + date.getMonth() : date.getMonth(),
            day = date.getDate() < 10 ? '0' + date.getDate() : date.getDate(),
            newDate = yr + '-' + month + '-' + day;
        var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        newDate = day + '-' + monthNames[date.getMonth()] + '-' + yr;
        filters = filters.trim();
        var reports = data[i].is_trans == true ? 'Transaction' : 'Technical';
        var filters = filters.replace(/^,|,$/g, '');
        tabs += '<td style="text-align: left">' + filters + ' </td>';
        tabs += '<td>' + data[i].zoom_level + '</td>';
        tabs += '<td>' + reports + '</td>';
        tabs += '<td>' + newDate + '</td>';
        if (data[i].is_default == true)
            tabs += '<td><a style="color: black; font-weight: bold; text-align: right;">Active</a></td>';
        else
            tabs += '<td><a class="set-default-link" style="color: black; text-decoration: underline !important;" onclick="updateDefaultmode(' + data[i].id + ',' + data[i].is_trans + ')">set default</a></td>';

        tabs += "<td><a id='view-selected-preference' href='/intel' onclick='viewSelectedmode(" + JSON.stringify(data[i]) + ")'>view</a></td>";
        tabs += '</tr>'
    }
    tabs += '</tbody></table>';
    tabs += '</div>';
    tabs += '</div>';
    tabs += '</div>';

    $("#user-saved-preferences").append(tabs);

}

//view selected mode on intel page
function viewSelectedmode(data) {
    sessionStorage.setItem("selectedMode", JSON.stringify(data));
    var filters = JSON.parse(sessionStorage.getItem("selectedMode"));
}

//update default mode method
function updateDefaultmode(id, is_trans) {
    var url = SCRIPT_PATH + "?action=updateDefaultmode";
    var data = [{name: 'id', 'value': id}, {name: 'is_trans', 'value': is_trans}];
    $.ajax({
        url: url,
        type: "POST",
        dataType: "JSON",
        data: data,
        success: function (data) {
            if (data.success) {
                $('.leaflet-popup-close-button').css('position', 'absolute');
                $('#saved-preferences-modal span').text('Your default mode is changed');
                $('#saved-preferences-modal').modal('show');
                getsavedpreferences();
            }
        }
    });
}

//Delete modes
function deleteModes() {
    var checked = [];
    $('input[type=checkbox]').each(function () {
        if ($(this).prop('checked')) {
            checked.push(parseInt($(this).val()));
        }

    });
    if (checked.length == 0) {
        $('.leaflet-popup-close-button').css('position', 'absolute');
        $('#saved-preferences-modal span').text('Please make selection to delete modes.');
        $('#saved-preferences-modal').modal('show');
        return false;
    }
    var url = SCRIPT_PATH + "?action=deleteModes";
    var data = [{name: 'preferences-list', 'value': checked}];
    $.ajax({
        url: url,
        type: "POST",
        dataType: "JSON",
        data: data,
        success: function (data) {
            if (data.success) {
                $('.leaflet-popup-close-button').css('position', 'absolute');
                $('#saved-preferences-modal span').text('Selected preferences have been deleted.');
                $('#saved-preferences-modal').modal('show');
                $( ".saved-preferences-btn" ).bind( "click", function() {
                    getsavedpreferences();
                    $( ".saved-preferences-btn").unbind( "click" );
                });
            }
        }
    });
}
