/**
 * Created by Shahzaib on 16/11/2018.
 */
var BASE_URL = location.protocol + "//" + location.host;
var SCRIPT_PATH = location.protocol + '/wp-content/themes/fount/intel/lib/all.php';

//.................................Get user default mode (Tech & Trans) filters from database table named user_map_preferences
oRsc.getDefaultMode = function () {

    //..................................................................run filters if user click from view link in saved preferences page
    var filters = JSON.parse(sessionStorage.getItem("selectedMode"));
    if ($.type(filters) == "object") {
        var istrans = filters.is_trans;
        if (istrans == true) {
            $.cookie("trans-status", "true");
            oRsc.turnTransOn();
        }
        oRsc.runDefaultFilters(filters);
        sessionStorage.setItem("selectedMode", "false");
        if (istrans == true)
            $.cookie("trans-status", "false");
        return false;
    }

    //.............................................................................................................else get user saved filters
    if ((oRsc.userPlan == 'Plan2' || oRsc.userPlan == 'Plan3')) {
        var url = SCRIPT_PATH + "?action=getDeafultMode";
        $.ajax({
            url: url,
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                //.........................if user's plan is plan2 or plan3 then run user's saved preferences modes
                if (data.success == true) {
                    if (data.active_filters[0].is_trans == true) {
                        oRsc.turnTransOn();
                        oRsc.runDefaultFilters(data.active_filters[0]);
                    } else if (data.active_filters[0].is_trans == false) {
                        oRsc.runDefaultFilters(data.active_filters[0]);
                    }
                } else {
                    //if not mode found then run default filters
                    if ($.cookie('trans-status') == 'true')
                        oRsc.turnTransOn();
                    oRsc.setDefaultDate();
                }
                oRsc.initSearch();
            }
        });
    } else {
        //if user's plan is plan 1 or unregisterd user

        //set default date to 365 days and run filters
        oRsc.setDefaultDate();
    }
    //initialize auto-complete search
    oRsc.initSearch();
};

//............................................set default date to 365 days if nonReg user else load all
oRsc.setDefaultDate = function (search) {
    if (oRsc.userPlan != 'Plan2' && oRsc.userPlan != 'Plan3') {

        $('.side-bar-filters label:not(#date_filter label):not(#commodity-group label)').css('background', '#7B868C');
        oRsc.setDateAndCommodityForNonRegUsers();

    }
    else {

        $('.side-bar-filters label').css('background', '#7B868C');
        $('.date-filter-background').addClass('date-filters').removeClass('date-filter-background');
        $('p.date_filter').css('text-decoration', 'unset');
        $('#from-date').val('');
        $('#to-date').val('');
        $('#clear-date, #save-preferences-link').css('display', 'none');
        $('#show-all').prop('checked', true);

    }
    $('.side-bar-filters').find('.content').hide();
    $('.side-bar-filters span.expander').removeClass('expanded').addClass('collapsed');
    $('.filter-background').removeClass('filter-background');
    if (!jQuery('body').hasClass('logged-in')) {
        $('span#commodity-g').addClass('filter-background');
    }
    $('.reset-filter-link').css('display', 'none');
    $('.sidebar-group label p').css('text-decoration', 'unset');
    $('#clear_filters, #save-preferences-link').css('display', 'none');
    $('.uncheck-all').each(function () {
        $(this).prop('checked', false);
    });
    if (oRsc.isMobileDevice) {
        var lastMonth = new Date();
        lastMonth.setMonth(lastMonth.getMonth() - 1);
        $("#from-date").val(oRsc.getFormattedDate(lastMonth, 'M d, yy'));
        $("#to-date").val(oRsc.getFormattedDate(new Date(), 'M d, yy'));

    }
    oRsc.clearFilters = true;
    search = search || false;

    if (search == false)
        oRsc.runFilter();
};

//..............................Active Trans mode if user sign in using Trans button
oRsc.turnTransOn = function () {
    $('#region-button-world-sidebar').removeClass().addClass('region-button region-button-off');
    $('#region-button-world').removeClass().addClass('region-button region-button-off');
    $('#region-button-trans-reports').removeClass().addClass('region-button region-button-on');
    $('#transaction-main-div').css('top', '208px');
    $('#region-button-trans-reports').removeAttr('data-target');
    $("#proj_status").hide(100);
    $("#project-stage-group").show(100);
    $('#stock-exchange').show(100);
    $("#report-location-accuracy").show(100);
    $("#transaction-type-group").show(100);
    $("#resources-type-group").hide(100);
    $("#report-type-group").hide(100);
    $("#report-code-group").hide(100);
    $('#report-type-format').hide(100);
    $("#reserves-type-group").hide(100);
    $('#bottom-share-links').css('display', 'none');
    $('#report-value_range').css('display', 'block');
    $('#reserve-all-div').hide();
    $('#legend-content-report').css('display', 'block');
    $('#legend-content-tech').css('display', 'none');
    $('#selectMe').find('option:eq(4)').hide();
    $('#selectMe').find('option:eq(5)').show();
    oRsc.isTrans = true;
    $('.toggle-layer-pdfdownloads').css('display', 'block');
    $("#reportbox_popup").remove();
    $('#filters').css('display', 'block');
    $('#report_box').css('border', '');
    $('.sidebar-group p').css('display', 'block');
    $('.sidebar-form-below-div2').css('height', 'unset');

    if (!jQuery('body').hasClass('logged-in') || oRsc.userPlan == 'Plan1') {
        $('span#commodity-g').addClass('filter-background');
    }

    $('#popupp').css('display', 'block');
};

//........................................function that will set all filters based on default mode(Tech or Trans) and run query on it
oRsc.runDefaultFilters = function (data) {

    oRsc.isPreferencesActive = true;

    var filters = data;

    var filterArray = JSON.parse(filters.filters_json);
    var setFilters = filterArray;

    var zoom_level = filters.zoom_level;

    var a = filters.map_centre.split(",");
    var lat = a[0].split("(");
    var lng = a[1].split(")");



    oRsc.map.setView(L.latLng(parseFloat(lat[1]), parseFloat(lng[0])));
    oRsc.setCenterToWorld(parseFloat(lat[1]),parseFloat(lng[0]),zoom_level);
    //oRsc.mapforzoom.setZoom(zoom_level);

    $('.uncheck-all').each(function () {
        $(this).prop('checked', false);
    });

    $('.side-bar-filters').find('label').css('background','#7B868C');

    $('.date-filter-background').addClass('date-filters').removeClass('date-filter-background');
    $('#to-date').val('');
    $('#from-date').val('');

    $('.reset-filter-link').css('display', 'none');
    $('.sidebar-group label p').css('text-decoration', 'unset');
    $('.filter-background').removeClass('filter-background');
    $('.side-bar-filters').find('.content').hide();
    $('.side-bar-filters span.expander').removeClass('expanded').addClass('collapsed');

    //.............................................set the default filters
    $.each(setFilters, function (i, item) {

        if (item.title != 'report_mode' && item.title.indexOf('Custom-date') == -1) {
            $('#clear_filters').css('display', 'block');
            if (jQuery('body').hasClass('logged-in'))
                $('#save-preferences-link').css('display', 'inline');
            $('span#' + item.value).addClass('filter-background');
            $('input#' + item.value).prop('checked', true);
            var parentClass = $('#' + item.value).parent().attr('class');
            var id = parentClass.split(" ");
            var parentId = id[1];
            if (parentId == 'commodity-reset-filter' || parentId == 'date-filter') {
                if (parentId == 'commodity-reset-filter') {
                    $('#commodity-group .content').show();
                    $('#commodity-group span.expander').removeClass('collapsed').addClass('expanded');
                    $('#commodity-group label a').css('display', 'inline');
                    // $('#commodity-group label').css('background', '#F74640');
                    $('#commodity-group label').css('background', '#DE7070');
                } else {
                    oRsc.isDatefromPref = true;
                    $('.date_filter').find('#' + item.value).click();
                    $('#date_filter label span').removeClass('collapsed').addClass('expanded');
                    $('#date_filter .content').show();
                    $('#date_filter label a').css('display', 'inline');
                    // $('#date_filter label').css('background', '#F74640');
                    $('#date_filter label').css('background', '#DE7070');
                }

            } else {
                $('#' + parentId + ' label a').css('display', 'inline');
                // $('#' + parentId + ' label').css('background', '#F74640');
                $('#' + parentId + ' label').css('background', '#DE7070');

                $('#' + parentId).find('.content').show();
                $('#' + parentId + ' span.expander').removeClass('collapsed').addClass('expanded');
            }
        }

        if(item.title.indexOf('Custom-date') != -1) {

            var date = item.value.split('|');
            $('#from-date').val(date[0]);
            $('#to-date').val(date[1]);
            $('#date_filter label span').removeClass('collapsed').addClass('expanded');
            $('#date_filter .content').show();
            $('#clear_filters').css('display', 'block');
            if (jQuery('body').hasClass('logged-in'))
                $('#save-preferences-link').css('display', 'inline');
        }
    });

    if (oRsc.userPlan != 'Plan2' && oRsc.userPlan != 'Plan3')
        oRsc.setDateAndCommodityForNonRegUsers();

    oRsc.clearFilters = false;
    $('#show-all').prop('checked', false);
    oRsc.runFilter();

};

//.......................................... get selected filters
oRsc.getSelectedFilters = function (param) {
    if (!jQuery('body').hasClass('logged-in') && param == true) {
        $('#commodity_checkboxes_popup span').text('This feature is available for registered users only. Please login or register for an account.');
        $('#commodity_checkboxes_popup').modal('show');
        return
    } else if (oRsc.userPlan == 'Plan1' && param == true) {
        $('#commodity_checkboxes_popup span').text('This feature is not available for this plan. Go to Manage profile to upgrade your plan.');
        $('#commodity_checkboxes_popup .modal-footer').hide();
        $('#commodity_checkboxes_popup').modal('show');
        return
    }
    filters = [];
    $('.uncheck-all').each(function () {
        if ($(this).prop('checked') == true) {
            var parent = $(this).parent().attr('class');
            var parentID = parent.split(" ");
            var parentID = parentID[1];
            if (parentID == 'commodity-reset-filter')
                parentID = 'commodity-group';
            if ($('#' + parentID).find('label:first-child p,span').hasClass('expanded')) {
                var id = $(this).attr('id');
                var isvisible = $('span#' + id).is(':visible');
                if (isvisible) {
                    item = {};
                    item ["title"] = $('#' + parentID).find('label p').text() + ',' + $('span#' + id).text();
                    item['value'] = $(this).attr('id');
                    filters.push(item);
                }
            }
        }
    });
    if ($('#date_filter').find('label:first-child p,span').hasClass('expanded')) {
        $('#date_filter a:not(.reset-filter-link)').each(function () {
            if ($(this).attr('class') == 'date-filter-background') {
                var dateFilter = $(this).attr('class');
                var dateText = $('.' + dateFilter).text();
                item = {};
                item ["title"] = 'Date Range:' + ',' + dateText;
                item['value'] = $(this).attr('id');
                filters.push(item);
            }
            return;
        });
        if($('#from-date').val() != '' && $('#to-date').val() != '') {

            item = {};
            item ["title"] = 'Date Range:' + ',' + 'Custom-date';
            item['value'] = $('#from-date').val() + '|' + $('#to-date').val();
            filters.push(item);
        }
    }
    var regionBtn = $('.region-button-on').text();
    if (filters.length > 0) {
        item = {};
        item ["title"] = 'report_mode';
        item['value'] = regionBtn;
        filters.push(item);
        if (param == true)
            saveCurrentMode(filters);
        else {
            if (regionBtn == 'Technical Reports')
                is_trans = false;
            else
                is_trans = true;
            var data = {
                filters_json: JSON.stringify(filters),
                zoom_level: oRsc.map._zoom,
                map_centre: "LatLng(29.07538, -42.36328)",
                is_trans: is_trans
            };
            oRsc.selectedFilters = data;
        }
    } else if (param == true)
        $('#saved-preferences-modal').modal('show');
    else
        oRsc.selectedFilters = '';
};

//.................................................when user click save preferences savev the default mode
$(document).ready(function () {
    $('#save-preferences-link').click(function () {
        oRsc.getSelectedFilters(true);
    });
});

//.................................send default mode data to save in the database
function saveCurrentMode(filters) {
    var regionBtn = $('.region-button-on').text();
    if (regionBtn == 'Technical Reports')
        is_trans = false;
    else
        is_trans = true;
    var url = SCRIPT_PATH + "?action=saveCurrentMode";
    var data = [{name: 'filters', 'value': JSON.stringify(filters)}, {
        name: 'zoom_level',
        'value': oRsc.map._zoom
    }, {name: 'map_position', 'value': oRsc.map.getCenter()}, {name: 'is_trans', 'value': is_trans}];
    $.ajax({
        url: url,
        type: "POST",
        data: data,
        dataType: "JSON",
        success: function (data) {
            $('#saved-preferences-modal span').text('Your selected filters and current view is now saved. For more options go to Manage Profile - Saved Preferences');
            $('#saved-preferences-modal').modal('show');
        }
    });
};

//................................................... set Default date to 365 days and commodity to gold for Non Reg users
oRsc.setDateAndCommodityForNonRegUsers = function() {

    // $('#commodity-group label, #date_filter label').css('background', '#F74640');
    $('#commodity-group label, #date_filter label').css('background', '#DE7070');

    $('#date_filter label span').removeClass('expanded').addClass('collapsed');
    $('#show-allll').removeClass('date-filters').addClass('date-filter-background');
    $('a.date_filter').css('display', 'inline');
    $('a.date_filter').text('Last 365 days');
    $('#show-all-time').prop('checked', false);
    var oneWeekAgo1 = new Date();
    oneWeekAgo1.setDate(oneWeekAgo1.getDate() + 1);
    var day2 = ("0" + oneWeekAgo1.getDate()).slice(-2);
    var month2 = ("0" + (oneWeekAgo1.getMonth() + 1)).slice(-2);
    var today2 = oneWeekAgo1.getFullYear() - 1 + "-" + (month2) + "-" + (day2);
    var today3 = oRsc.getFormattedDate(today2, 'M d, yy');
    $('#from-date').datepicker('setDate', today3);
    $('#to-date').datepicker('setDate', new Date());
    $('#show-all').prop('checked', false);
    oRsc.date_filter = true;
    $('#from-date').css('color', '');
    $('#to-date').css('color', '');
    // $('#isNonreg, #isNonregUser').css('background', '#F74640');
    $('#isNonreg, #isNonregUser').css('background', '#DE7070');

};



