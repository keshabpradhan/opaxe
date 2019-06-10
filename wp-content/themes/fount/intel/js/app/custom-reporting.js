oRsc.customReporting = function () {
    $('#close-subscribe-btn').click(function () {
        //Actions performing on closing custom reporting *Shahzaib
        //Enable Transaction report
        $('#region-button-trans-reports').css('pointer-events', 'auto');
        $('#region-button-trans-reports').css('cursor', 'auto');
        //Show filters in side bar
        $('#report-code-group').show();
        $('#report-type-group').show();
        $('#report-type-group').show();
        $('#reserves-type-group').show();
        $('#resources-type-group').show();
        $('.map-topbar-container.hide-below-768px').css('display','block');
        $('#report-type-format').show();
        $('#proj_status').show();
        //Make Date filters clear
        $("#show-all-time").prop('checked', true);
        $('#from-date').val('');
        $('#to-date').val('');
    });

    $('#region-button-custom-reporting').click(function () {
        //Actions performing when click on Custom Reporting *Shahzaib
        //Disable Transaction report
        $('#region-button-trans-reports').css('pointer-events', 'none');
        $('#region-button-trans-reports').css('cursor', 'default');
        //hide sidebar filters
        $('#report-code-group').hide();
        $('#report-type-group').hide();
        $('#report-type-group').hide();
        $('#reserves-type-group').hide();
        $('#resources-type-group').hide();
        $('#report-type-format').hide();
        $('#proj_status').hide();
        $('.map-topbar-container.hide-below-768px').css('display','none');
        //Clear the date filters colors
        $("#show-all-time").prop('checked', true);

    });
    $('#other_tab').click(function () {
        //Show sidebar filters when anyother tab is opened in Custom Reporting *Shahzaib
        $('#report-code-group').show();
        $('#report-type-group').show();
        $('#report-type-group').show();
        $('#reserves-type-group').show();
        $('#resources-type-group').show();
        $('#report-type-format').show();
        $('#proj_status').show();
    });
    $('#default_tab').click(function () {
        //Hide sidebar filters when default tab is opened in custom Reporting *Shahzaib
        $('#report-code-group').hide();
        $('#report-type-group').hide();
        $('#report-type-group').hide();
        $('#reserves-type-group').hide();
        $('#resources-type-group').hide();
        $('#date_filter').show();
    });
    if (oRsc.date_filter2 == true) {
        //Make transaction report clickable on default view *Shahzaib
        $('#region-button-trans-reports').css('pointer-events', 'auto');
        $('#region-button-trans-reports').css('cursor', 'auto');
        oRsc.date_filter = true;
        oRsc.date_filter2 = false;
        //set the date from (2014-10-01 on seb demand) to present to show all data *Shahzaib
       // var m = new Date('2014-10-01');
        //m.setMonth(m.getMonth() - 43);
       // $('#from-date').datepicker('setDate', m);
        //$('#to-date').datepicker('setDate', new Date());
        //hide date on default preview 
       // $('#from-date').css('color', 'white');
        //$('#to-date').css('color', 'white');
    }
    $('.resource_consultant').click(function () {
        //resource_consultant Tab in Custom Reporting *Shahzaib
        $('#date_filter').hide();
        $('#report-code-group').hide();
        $('#report-type-group').hide();
        $('#report-type-group').hide();
        $('#reserves-type-group').hide();
        $('#resources-type-group').hide();
        $("input[name='commodity[]']").each(function ()
        {
            $('.uncheck-all-commodities').prop('checked', false);
         });
        // $("#uncheck-all-commodities").change(function() {
        //    // alert('changed');
        //     // if($(this).hasClass('uncheck-all-commodities'))
        //     // // alert('checked');
        //     if($("#uncheck-all-commodities").prop('checked') == true){
        //     //     //do something
        //     var checked = [];
        //     $('#comm_lists').empty();
        //     $('#filter-commodities').empty();
        //     var  filters=[];
        //     $("input[name='commodity[]']:checked").each(function ()
        //    {
        //         checked.push("'"+$(this).val()+"'");
        //         filters.push($(this).val()+',');
        //         $('#filter-commodities').html(filters);
        //     });

        //         var path = "?action=commodity_filter";
        //         url = SCRIPT_PATH + path;
        //         var data = {'comm_filters': checked};
        //     $.ajax(url, {
        //         type: 'POST',
        //         global: false,
        //         data: data,
        //         dataType: "json",
        //         success: function (response) {
                    
        //             for(i=0;i<response.reports.length;i++){
        //                 var j=i+1;
        //                 console.log(response.reports);
        //                 console.log(response.reports.length);
        //               // console.log(response.reports[i].resource_qp);
        //                $('#comm_lists').append('<li>' + j + '- ' + response.reports[i].resource_qp + '</li>');
        //             }
        //            // response.reports['re']
        //         },
        //         error: function(data) {
        //             successmessage = 'Error';
        //             $('#comm_lists').append('<li>  new </li>');
        //         },
        //     });
        
           
        //     }
        //      else{
        //         var checked = [];
        //         var  filters=[];
        //         $('#comm_lists').empty();
        //         $("input[name='commodity[]']:checked").each(function ()
        //        {
        //             checked.push("'"+$(this).val()+"'");
        //             filters.push($(this).val()+',');
        //             $('#filter-commodities').html(filters);
        //         });

        //             var path = "?action=commodity_filter";
        //             url = SCRIPT_PATH + path;
        //             var data = {'comm_filters': checked};
        //         $.ajax(url, {
        //             type: 'POST',
        //             global: false,
        //             data: data,
        //             dataType: "json",
        //             success: function (response) {
                        
        //                 for(i=0;i<response.reports.length;i++){
        //                     var j=i+1;
        //                     console.log(response.reports);
        //                     console.log(response.reports.length);
        //                   // console.log(response.reports[i].resource_qp);
        //                    $('#comm_lists').append('<li>' + j + '- ' + response.reports[i].resource_qp + '</li>');
        //                 }
        //                // response.reports['re']
        //             },
        //             error: function(data) {
        //                 successmessage = 'Error';
        //                 $('#comm_lists').append('<li>  new </li>');
        //             },
                  
        //         });
            
               
        //      }
        //     //      var checked = [];
              
        //     //          checked.push("'"+$(this).val()+"'");
        //     //          $('#filter-commodities').html(checked);
                

        //     //          var path = "?action=commodity_filter";
        //     //          url = SCRIPT_PATH + path;
        //     //          var data = {'comm_filters': checked};
        //     //      $.ajax(url, {
        //     //          type: 'POST',
        //     //          global: false,
        //     //          data: data,
        //     //          dataType: "json",
        //     //          success: function (response) {
                         
        //     //              for(i=0;i<response.reports.length;i++){
        //     //                 $('#comm_lists').append('<li>' +  i  + '-' +  response.reports[i].resource_qp + '</li>');
        //     //              }
        //     //             // response.reports['re']
        //     //          },
        //     //      });
        // });
        $("input[type=checkbox]").change(function() {
            if($(this).hasClass('uncheck-all-commodities'))
            // alert('checked');
            $('#comm_lists').empty();
            $('#filter-commodities').empty();
                 var checked = [];
                 var  filters=[];
                 $("input[name='commodity[]']:checked").each(function ()
                {
                     checked.push("'"+$(this).val()+"'");
                     filters.push($(this).val()+',');
                     $('#filter-commodities').html(filters);
                 });

                     var path = "?action=commodity_filter";
                     url = SCRIPT_PATH + path;
                     var data = {'comm_filters': checked};
                 $.ajax(url, {
                     type: 'POST',
                     data: data,
                     dataType: "json",
                     success: function (response) {
                        var details=response.reports
                        appendResources(details);
                     },
                     error: function(data) {
                        successmessage = 'Error';
                        $('#comm_lists').empty();
                        $('#filter-commodities').empty();
                        $('#comm_lists').append('<tr></tr>');
                    },
                 });
             
                });
    });
    function appendResources(details){
        $('#comm_lists').empty();
        for(i=0;i<25;i++){
            var j=i+1;
           
           // console.log(response.reports[i].resource_qp);
            $('#comm_lists').append('<tr><td>' + j + '- ' + details[i].resource_qp + '</td>' + '<td>'+ details[i].mycount + '</td></tr>');
         }

    }
    //Selected Filters

    // DATE RANGE:
    if ($('#to-date').val() != '' || $('#from-date').val() != '') {

        $('#custom-date').html($('#from-date').val() + " - " + $('#to-date').val());
        $('#custom-date-title').show();
    }
    else {
        if ($("#show-all-time").prop('checked') == true) {
            if (oRsc.sel_filter == 1) {
               // var m = new Date('2014-10-01');
                //m.setMonth(m.getMonth() - 43);
                //$('#from-date').datepicker('setDate', m);
                //$('#to-date').datepicker('setDate', new Date());
            }
        }
    }
    // RESOURCES
    $('#custom-resources').html(this.selectedFilters('uncheck-all-resources'));

    // RESERVES
    $('#custom-reserves').html(this.selectedFilters('uncheck-all-reserves'));

    // COMMODITY
    $('#custom-commodities').html(this.selectedFilters('uncheck-all-commodities'));


    var oneWeekAgo = new Date();
    oneWeekAgo.setDate(oneWeekAgo.getDate() - 150);
    oneWeekAgo = oRsc.getFormattedDate(oneWeekAgo, 'M d, yy'),
        oRsc.Code_JORC = -0.1;
    oRsc.Code_ENV = -0.1;
    oRsc.Code_NI43_101 = -0.1;
    oRsc.Code_OTHER = -0.1;
    oRsc.Type_eia = -0.1;
    oRsc.Type_explore = -0.1;
    oRsc.Type_resource = -0.1;
    oRsc.Type_optimisation = -0.1;
    oRsc.Type_pea = -0.1;
    oRsc.Type_supporting = -0.1;
    oRsc.Type_pre = -0.1;
    oRsc.Type_feasibility = -0.1;
    var data = this._worldJson,
        lookup = this._lookup;
    var geoJson = [];

    // for (var i = 0; i < data.length; i++) {
    //     var point = data[i];}
    // var oneWeekAgo2 = oRsc.getFormattedDate(point[lookup.date1], 'M d, yy');
    //     if(oneWeekAgo <= oneWeekAgo2){
    //         week1[0] =  week1[0]+1;

    //     }

    if (oRsc.c_reporting == true) {
        for (var i = 0; i < data.length; i++) {
            var point = data[i];
            if (point[lookup.code] == 'NI43-101' || point[lookup.code] == 'NI 43-101') {
                oRsc.Code_NI43_101++;
            }
            else if (point[lookup.code] == 'JORC') {
                oRsc.Code_JORC++;
            }
            else if (point[lookup.code] == '(Enviro)') {
                oRsc.Code_ENV++;
            }
            else {
                oRsc.Code_OTHER++;
            }

            // Report Type
            if (point[lookup.type] == 'EIA/ESIA') {
                oRsc.Type_eia++;
            }
            else if (point[lookup.type] == 'Exploration/Drilling Update') {
                oRsc.Type_explore++;
            }
            else if (point[lookup.type] == 'Resource Estimation') {
                oRsc.Type_resource++;
            }
            else if (point[lookup.type] == 'Sptimisation Study') {
                oRsc.Type_optimisation++;
            }
            else if (point[lookup.type] == 'Pea' || point[lookup.type] == 'Scoping Study') {
                oRsc.Type_pea++;
            }
            else if (point[lookup.type] == 'Supporting Acquisition') {
                oRsc.Type_supporting++;
            }
            else if (point[lookup.type] == 'Pre-Feasibility Study') {
                oRsc.Type_pre++;
            }
            else if (point[lookup.type] == 'Feasibility Study') {
                oRsc.Type_feasibility++;
            }

        }
    }
    else {
        var code, type, resource, reserves, commodities, data;
        $.each(this.geoSearchJson, function (index, json) {
            data = json.properties;
            code = (data.code !== null) ? data.code.toLowerCase() : '';
            type = (data.type !== null) ? data.type.toLowerCase().replace(" ", "-") : '';
            resource = (data.status !== null) ? data.status.toLowerCase().replace(" ", "-") : '';
            reserves = (data.reserve_status !== null) ? data.reserve_status.toLowerCase().replace(" ", "-") : '';


            // Report Code
            if (code === '(enviro)') {
                code = '#code-environmental';
                oRsc.Code_ENV++;
            }
            else if (code === 'ni43-101') {
                oRsc.Code_NI43_101++;
                code = '#code-ni-43-101';
            }
            else if (code === 'jorc') {
                oRsc.Code_JORC++;
                code = '#code-jorc';
            }
            else {
                oRsc.Code_OTHER++;
                code = '#code-other';
            }

            // Report Type
            if (type === 'eia/esia') {
                oRsc.Type_eia++;
                type = '#type-eia-esia';
            }
            else if (type === 'exploration/drilling update') {
                oRsc.Type_explore++;
                type = '#type-exploration-update';
            }
            else if (type === 'resource estimation') {
                oRsc.Type_resource++;
                type = '#type-resource-estimation';
            }
            else if (type === 'optimisation study') {
                oRsc.Type_optimisation++;
                type = '#type-optimisation-study';
            }
            else if (type === 'pea') {
                oRsc.Type_pea++;
                type = '#type-type-Scoping-Study-and-pea';
            }
            else if (type === 'supporting acquisition') {
                oRsc.Type_supporting++;
                type = '#type-supporting-acquisition';
            }
            else if (type === 'pre-feasibility study') {
                oRsc.Type_pre++;
                type = '#type-pre-feasibility';
            }
            else if (type === 'feasibility study') {
                oRsc.Type_feasibility++;
                type = '#type-feasibility';
            }


        });


    }

// Custom reporting charts

    $('#notChart').remove(); // this is my <canvas> element
    $('#doughnutss').append('<canvas id="notChart" width="30" height="30"><canvas>');
    var ctx = document.getElementById("notChart").getContext('2d');

    var notChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ["NI43_101", "ENV", "JORC", "OTHER"],
            datasets: [{
                //label: '# of Votes',
                // if(Code_NI43_101){
                //
                // },
                data: [Math.floor(oRsc.Code_NI43_101), Math.floor(oRsc.Code_ENV), Math.floor(oRsc.Code_JORC), Math.floor(oRsc.Code_OTHER)],
                //data: [-0.1,-0.1,-0.1,-0.1],
                sliceVisibilityThreshold: 0,
                //  data: [oRsc.Code_ENV],
                backgroundColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                ],
                borderWidth: 1
            }]
        },
        showDatapoints: true,
        options: {
            tooltips: {
                callbacks: {
                    label: function (tooltipItem, data) {
                        var allData = data.datasets[tooltipItem.datasetIndex].data;
                        var tooltipLabel = data.labels[tooltipItem.index];
                        var tooltipData = allData[tooltipItem.index];
                        var total = 0;
                        for (var i in allData) {
                            total += allData[i];
                        }
                        var tooltipPercentage = Math.round((tooltipData / total) * 100);
                        return tooltipLabel + ': ' + tooltipData + ' (' + tooltipPercentage + '%)';
                    }
                }
            },
            pieceLabel: {
                render: 'value',
                arc: false,
                fontColor: '#ffffff',
                position: 'inside'
            },
            legend: {
                position: 'right',
                labels: {
                    boxWidth: 8,
                    boxHeight: 2
                }
            },
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 180
                }
            },
            rotation: -0.5 * Math.PI,
            animation: {
                animateRotate: true,
                animateScale: false
            }

        }
    });


    $('#doChart').remove(); // this is my <canvas> element
    $('#pieee').append('<canvas id="doChart" width="30" height="30"><canvas>');
    var ctx2 = document.getElementById("doChart").getContext('2d');

    var doChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ["Optimisation Study", "Resource Estimation", "PEA/Scoping Study", "Feasibility Study", "Pre-Feasibility Study", "EIA/ESIA", "Exploration/Drilling Update", "Supporting Acquisition"],
            datasets: [{
                data: [
                    Math.ceil(oRsc.Type_optimisation),
                    Math.floor(oRsc.Type_resource),
                    Math.floor(oRsc.Type_pea),
                    Math.floor(oRsc.Type_feasibility),
                    Math.floor(oRsc.Type_pre),
                    Math.floor(oRsc.Type_eia),
                    Math.floor(oRsc.Type_explore),
                    Math.ceil(oRsc.Type_supporting),
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(243, 156, 18, 1)',
                    'rgba(52, 73, 94  ,1)',
                    'rgba(100, 159, 64, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(155, 89, 182 , 1)',
                    'rgba(0, 0, 254, 1)'
                ],

                borderWidth: 1
            }]
        },
        showDatapoints: true,
        options: {
            tooltips: {
                callbacks: {
                    label: function (tooltipItem, data) {
                        var allData = data.datasets[tooltipItem.datasetIndex].data;
                        var tooltipLabel = data.labels[tooltipItem.index];
                        var tooltipData = allData[tooltipItem.index];
                        var total = 0;
                        for (var i in allData) {
                            total += allData[i];
                        }
                        var tooltipPercentage = Math.round((tooltipData / total) * 100);
                        return tooltipLabel + ': ' + tooltipData + ' (' + tooltipPercentage + '%)';
                    }
                }
            },
            pieceLabel: {
                render: 'value',
                arc: false,
                fontColor: '#ffffff',
                position: 'inside'
            },
            legend: {
                position: 'right',
                align: 'center',
                display: true,
                fullWidth: true,
                reverse: false,
                labels: {
                    position: 'right',
                    boxWidth: 8,
                    boxHeight: 2,

                }
            },
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 180,

                },
            },
            rotation: -0.5 * Math.PI,
            animation: {
                animateRotate: true,
                animateScale: false
            }
        }
    });
    data = $('#sidebarForm').serializeArray();
    data.push({name: 'isCommodity', value: $('#commodity-group').find('label:first-child').hasClass('expanded')});
    data.push({name: 'to', value: $('#to-date').val()});
    data.push({name: 'from', value: $('#from-date').val()});
    var url = SCRIPT_PATH + "?action=weeklyReport";
    
    //mixed_chart = new Highcharts.chart('container');
    $.ajax({
        type: "POST",
        url: url,
       //async: false,
        data: data,
        dataType: "json",
        success: function(response) { 
            //alert(response);
            var details= response.result;
            SetChartData(details);
         },
         error: function(data) {
            oRsc.weeks.resources=[];
            oRsc.weeks.drilling=[];
            oRsc.weeks.madien=[];


        },
     });
     function SetChartData(details){
         console.log(details);
         oRsc.weeks=details;
     }
    // Create the chart
    var lenn=oRsc.weeks.dates.length;
    if(lenn< 5){
       oRsc.min_x=0;
       oRsc.max_x=0;
    }
    else if(lenn<30){
        oRsc.min_x=0;
        oRsc.max_x=8;
    }
    else{
        oRsc.min_x=lenn-9;
       oRsc.max_x=lenn-1;
    }
    mixed_chart = new Highcharts.chart('container', {
        chart: {
            width: 800,
        },
        style: {
            fontFamily: 'monospace',
            color: "#f00"
        },
        rangeSelector: {
            selected: 1
        },

        title: {
            text: 'asd',
            style: {
                color: 'rgba(225, 225, 225, 0)'
            }
        },
        // scrollbar: {
        //     enabled: true
        // },
        mapNavigation: {
            enabled: true,
            enableDoubleClickZoomTo: true
        },
        scrollbar: {
            enabled: true,
            barBackgroundColor: 'gray',
            barBorderRadius: 7,
            barBorderWidth: 0,
            buttonBackgroundColor: 'gray',
            buttonBorderWidth: 0,
            buttonBorderRadius: 7,
            trackBackgroundColor: 'none',
            trackBorderWidth: 1,
            trackBorderRadius: 8,
            trackBorderColor: '#CCC',
            margin: 100
        },
        //xAxis : {
        //     events: {
        //         setExtremes: function (e) {
        //             if (typeof(e.rangeSelectorButton) !== 'undefined') {
        //                 this.min = utc_timestamp_today;
        //                 this.max = utc_timestamp_3moFromNow;
        //             }
        //         }
        //     }
        // },
        xAxis: {
            categories: oRsc.weeks.label,
            min:oRsc.min_x,
            max:oRsc.max_x,
            gridLineWidth: 0,
            title: {
                text: 'Week Numbers',
                align: 'high',
                style: {
                    color: 'rgba(54, 162, 235, 1)',
                    fontSize: '11px',
                }
            },
            labels: {
                style: {
                    color: 'rgba(54, 162, 235, 1)'
                }
            }
        },
        yAxis: [{ // Secondary yAxis
            gridLineWidth: 0,
            title: {
                text: 'Number of Reports',
                style: {
                    color: 'rgba(54, 162, 235, 1)',
                    fontSize: '11px',
                }
            },
            labels: {
                format: '{value}',
                style: {
                    color: 'rgba(54, 162, 235, 1)',
                    fontSize: '11px',
                }
            }

        }, 
        { // Primary yAxis
            labels: {
                format: '',
                // style: {
                //     color: 'rgba(255,215,0,1)',
                //     fontSize:'11px',
                // }
            },
            title: {
                text: '',
                // style: {
                //     color: 'rgba(255,215,0,1)'  ,
                //     fontSize:'11px',
                // }
            },
            // opposite: true

        }, { // Tertiary yAxis
            // gridLineWidth: 0,
            title: {
                text: '',
                // style: {
                //     color: 'rgba(77, 208, 225,, 1)'
                // }
            },
            labels: {
                format: '',
                // style: {
                //     color: 'rgba(77, 208, 225,, 1)'            }
            },
            opposite: true
        },],

        // plotOptions: {
        //     series: {
        //         stacking: 'normal',
        //         shadow: false,
        //         groupPadding: 0,
        //         pointPadding: 0
        //     }
        // },
         tooltip: {
            formatter: function() {
                var len = oRsc.weeks.label.length;
                //alert(len);
                if(len>1){
                    var s = oRsc.weeks.label.indexOf(this.x);
                    if(s+1>=len){
                        s=oRsc.weeks.dates[s];
                    }
                    else{
                        s=oRsc.weeks.dates[s] + " - " +oRsc.weeks.dates[s+1] ;
                    } 
                }
                else{
                    var s = oRsc.weeks.label.indexOf(this.x);
                    s=oRsc.weeks.dates[s];
                    // mixed_chart.xAxis[0].update({
                    //             min: (oRsc.weeks.label.length)-9
                    //         });
                    
                    //         mixed_chart.xAxis[0].update({
                    //             max:oRsc.weeks.label.length
                    //         });
                }
                $.each(this.points, function(i, point) {

                    s += '<br/>'+ point.series.name +': '+
                        point.y;
                });
                return s;
            },
            shared: true,
           // useHTML: false
        },
        series: [{
            type: 'column',
            name: 'Drilling',
            data:oRsc.weeks.drilling,
            // yAxis: 1,
            pointPadding: 0,
            groupPadding: 0,
            pointWidth: 15,
            tooltip: {
                // valueDecimals: 2
            },
            color: 'rgba(155, 89, 182 , 1)',
        }, {
            type: 'column',
            name: 'Resources',
         data: oRsc.weeks.resources,
            pointPadding: 0,
            groupPadding: 0,
            pointWidth: 15,
            // pointPlacement: -0.2,
            yAxis: 0,
            tooltip: {
                // valueDecimals: 2
            },
            color: 'rgba(54, 162, 235, 1)',
        }, {
            type: 'column',
            name: 'Maiden',
         data: oRsc.weeks.madien,
            // yAxis: 1,
            pointPadding: 0,
            groupPadding: 0,
            pointWidth: 15,
            borderColor: 'rgba(255, 249, 196, 0)',
            pointPlacement: -0.2,
            tooltip: {
                // valueDecimals: 2
            },
            color: 'rgba(255,215,0,1)'
        }
        ]
    });
 };

oRsc.selectedFilters = function (code) {
    var selected = '';
    $('input.' + code + '[type=checkbox]:checked').each(function (index) {
        if ((index === 0))
            selected = $(this).val();
        else
            selected += ", " + " " + $(this).val();

    });

    return selected;
};

