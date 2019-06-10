oRsc.activity_log = function (sone) {
    var path = "?action=activity_log",
        url = SCRIPT_PATH + path;
    var data = {'log': sone['action_log'], 'action': sone['action'], 'mode': sone['mode'],'report-id':sone['report-id']};
    $.ajax(url, {
        type: 'POST',
        global: false,
        data: data,
        success: function (response) {
            //console.log(response);
        },
    });
};
oRsc.Activity_Log_Detail = function () {
    var url = SCRIPT_PATH + "?action=activity_log_detail";
    $.ajax(url, {
        type: 'POST',
        global: false,
        success: function (response) {
            var detail_log = JSON.parse(response);
            console.log(detail_log);
            if(detail_log['success']==false){
                $('.table tbody#log-detail').text('No data found');
            }
            else {
                oRsc.Log_Detail(detail_log);
            }
        },
    });
};

oRsc.Log_Detail = function (detail_log) {
    $('.log-detail-class').remove();
    for (i = 0; i < detail_log.detail.length; i++) {
                $('.table tbody#log-detail').append('<tr class="log-detail-class"><td>' + (i+1) + '</td><td>' + detail_log.detail[i].date + '</td><td>' + detail_log.detail[i].user + '</td><td>' + detail_log.detail[i].ip + '</td><td id="loc">'+ detail_log.detail[i].location + '</td><td>' + detail_log.detail[i].action + '</td><td>' + detail_log.detail[i].Action_Log + '</td><td>' + detail_log.detail[i].mode + '</td><td>' + detail_log.detail[i].report_id + '</td><td>' + detail_log.detail[i].Company + '</td><td>' + detail_log.detail[i].commodities + '</td><td>' + detail_log.detail[i].QC_CP + '</td><td>' + detail_log.detail[i].report_highlight + '</td><td>' + detail_log.detail[i].lat + '</td><td>' + detail_log.detail[i].lon + '</td></tr>')
    }

};
//get dates from table rows and append it to the dropdown list *Shahzaib
oRsc.Log = function (detail_log) {
    $('.dates-list').empty();
    for (i = 0; i < detail_log.detail.length; i++) {
        if(detail_log.detail[i].date!=null){
            if(i>0){
                if(detail_log.detail[i].date!=null && detail_log.detail[i]!=detail_log.detail[i-1] ){
                    //   var newArray = detail_log.detail[i].date.split(' ');
                    $('.dates-list').append('<li  style="padding: 0px" value="' + detail_log.detail[i].date + '"><input type="checkbox" name="dates[]"  value="' + detail_log.detail[i].date + '">' + detail_log.detail[i].date + '</li>')
                }
            }
            else{
               // var newArray = detail_log.detail[i].date.split(' ');
                $('.dates-list').append('<li style="padding: 0px" value="' + detail_log.detail[i].date + '"><input type="checkbox" name="dates[]" id="chck" value="' + detail_log.detail[i].date + '">' + detail_log.detail[i].date + '</li>')
            }

        }
    }

};
//When click on date get the data and pass it Log function to use in dropdown list *Shahzaib
$(document).ready(function () {
    $('#date').click(function () {
        var url = SCRIPT_PATH + "?action=activity_log_detail";
        $.ajax(url, {
            type: 'POST',
            global: false,
            success: function (response) {
                var detail_log = JSON.parse(response);
                oRsc.Log(detail_log);
            },
        });
        // select.append('<li class="val" value="' + detail_log + '"><input type="checkbox" name="dates[]" id="chck" value="' + val + '">' + val + '</li>');
        $('#opt-date-range').show();
        $('#select').text('Select All');
        $('#select').css('text-decoration', 'underline');
    })
});
//When user select dates and click ok to search , get the data from backend and display *Shahzaib
$(document).ready(function () {
    $('#sub_datess_tofilter').click(function () {
        var checked = [];
        $("input[name='dates[]']:checked").each(function () {
            checked.push("'" + $(this).val() + "'");
        });
           if(checked.length==0){
             checked.push("'1970-08-09'");
           }
        var path = "?action=search_log_detail",
            url = SCRIPT_PATH + path;
        var data = {'checkboxes': checked};
        $.ajax(url, {
            type: 'POST',
            global: false,
            data: data,
            success: function (response) {
                var detail_log = JSON.parse(response);
                oRsc.Log_Detail(detail_log);
               // alert(detail_log.data);
            },
        });
        //
        $('#opt-date-range').hide();
    })
});
//Unselect All or Select All Functionality
$(document).ready(function () {
    $('#select').click(function () {
        var val = $('#select').text();
        if (val == 'Select All') {
            var checked = [];
            $("input[name='dates[]']").each(function () {
                $("input[name='dates[]']").prop('checked', true);
                checked.push("'" + $(this).val() + "'");
            });
            $('#select').text('Unselect All');
            $('#select').css('text-decoration', 'underline');
        }
        else {
            var checked = [];
            $("input[name='dates[]']").each(function () {
                $("input[name='dates[]']").prop('checked', false);
                checked.push("'" + $(this).val() + "'");
            });
            $('#select').text('Select All');
            $('#select').css('text-decoration', 'underline');
        }

        });
        //
        $('#opt-date-range').hide();
});
//end
//when user click cancel then display default data *Shahzaib
$(document).ready(function () {
    $('#clear_filter').click(function () {
        oRsc.Activity_Log_Detail();
        $('#opt-date-range').hide();
    })
});
$(document).ready(function () {
    $('#cancel_filter').click(function () {
        $('#opt-date-range').hide();
    })
});
//filters in Analytics
$(document).ready(function () {
    $('.filterable .btn-filter').click(function () {
        var $panel = $(this).parents('.filterable'),
            $filters = $panel.find('.filters input'),
            $tbody = $panel.find('.table tbody');
        if ($filters.prop('disabled') == true) {
            $filters.prop('disabled', false);
            $filters.first().focus();
        } else {
            $filters.val('').prop('disabled', true);
            $tbody.find('.no-result').remove();
            $tbody.find('tr').show();
        }


        var padding=parseInt( $('.filters').css('padding-bottom'));
        if(padding==20){
            $('.filters').css('padding-bottom','');
        }
        else{
            $('.filters').css('padding-bottom','20px');
        }
        //alert(padding);
    });

    $('.filterable .filters input').keyup(function (e) {
        /* Ignore tab key */
        var code = e.keyCode || e.which;
        if (code == '9') return;
        /* Useful DOM data and selectors */
        var $input = $(this),
            inputContent = $input.val().toLowerCase(),
            $panel = $input.parents('.filterable'),
            column = $panel.find('.filters th').index($input.parents('th')),
            $table = $panel.find('.table'),
            $rows = $table.find('tbody tr');
        /* Dirtiest filter function ever ;) */
        var $filteredRows = $rows.filter(function () {
            var value = $(this).find('td').eq(column).text().toLowerCase();
            return value.indexOf(inputContent) === -1;
        });
        /* Clean previous no-result if exist */
        $table.find('tbody .no-result').remove();
        /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
        $rows.show();
        $filteredRows.hide();
        /* Prepend no-result row if all rows are filtered */
        if ($filteredRows.length === $rows.length) {
            $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="' + $table.find('.filters th').length + '">No result found</td></tr>'));
        }
    });
});
