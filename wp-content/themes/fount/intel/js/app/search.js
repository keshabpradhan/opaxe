/**
 * Created by ARslan on 12/15/2017.
 */

oRsc.initSearch = function () {
    this.isTransaction = $('#region-button-trans-reports').hasClass('region-button region-button-on');
    var columns = (this.isTransaction) ? this.transactionColumns() : this.searchColumns(),
        self = this,
        $search = $("#search");
    $search.multiAutoComplete({
        showHeader: true,
        columns: columns,
        source: function (request, response) {
            // var term = request.term.split(":");
            // term = $.trim(term[1]);
            if (request.term.length < 3 || CustomVariables.isCommoditySelected == false) {
                return;
            }
            oRsc.searchData.push({name: 'term', value: request.term});
            oRsc.searchData.push({name: 'transaction', value: self.isTransaction});

            oRsc.searchData.push({name: 'option_selected', value: oRsc.searchKey});
            request.data = oRsc.searchData;
            oRsc.getSelectedFilters(false);
            oRsc.setDefaultDate(true);
            $('.rsc-search-loading').show();
            $.ajax({
                url: SCRIPT_PATH + "?action=search",
                dataType: "json",
                data: request.data,
                success: function (data) {
                    oRsc.search_prj_length = 0;
                    oRsc.search_results = data.reports;
                    if (data.success == false) {
                        oRsc.searchData.push({name: 'searchentireDB', value: 'false'});
                        oRsc.searchDropdownonShowMap = true;
                        var active_filters = $('.date-filter-background');
                        active_filters = active_filters.length;
                        var active_date_filters = $('.filter-background');
                        active_date_filters = active_date_filters.length;
                        if (oRsc.userPlan != 'Plan2') {
                            var gold_filter = $('#commodity-g').length;
                            var length = (active_filters + active_date_filters) - gold_filter;
                        } else {
                            var length = active_filters + active_date_filters;
                        }

                        if (length > 0)
                            $('#message-model p').text('No result found. Try changing your selected filters to widen the search.');
                        else
                            $('#message-model p').text('No result found.');
                        $('#message-model').modal('show');
                    } else {
                        oRsc.searchData.push({name: 'searchentireDB', value: 'false'});
                        self._worldJson = data.reports;
                        self._lookup = data.lookup;

                        //................................... Load markers on map if search terms was commodity, don't load search results dropdown
                        if (oRsc.searchKey == "commodities") {

                            oRsc.setActiveCommodity(request.term);

                            self._worldJson = data.reports;
                            self._worldJsonInitial = data.reports;
                            self._lookup = data.lookup;
                            // oRsc.searchLookup = data.lookup;
                            // oRsc.searchWorldjson = data.reports;
                            // oRsc.isSearchActivated = true;

                            oRsc.overlayReports();
                            oRsc.isSearchMarkersActivated = true;
                            $(':focus').blur();

                            $('.search-dropdown-content').css('display', 'none');
                            $('.rsc-search-loading').hide();
                            return;
                        }

                        response(self._worldJson);
                        $('.if-Filters-Active').removeClass('ui-menu-item');
                        // if($('#search-other-commodity').is(':visible') && $('#search-other-commodity').is(':checked')){
                        //     $('.chk-auto-complete').each(function(){
                        //         $(this).prop('checked',true)
                        //     });
                        //         $('#search').val('Filter:silver');
                        //         $('.ui-autocomplete').hide();
                        //         $('#btn-show-makers').trigger('click');
                        // }
                    }
                    $('.rsc-search-loading').hide();
                },
            });
            setTimeout(function () {
                var sone = [];
                sone['action'] = 'Search';
                sone['action_log'] = $('#search').val();
                sone['mode'] = $('.region-button-on').text();
                oRsc.activity_log(sone);
            }, 9000);
        },
        minLength: 3,
        autoFocus: false,
        select: function (event, ui) {
            // Set the input box's value
            $("#search").val(this.value);
            return true;
        },
        response: function (event, ui) {
            if (!ui.content.length) {
                var noResult = {label: "Error", value: "No match found"};
                ui.content.push(noResult);
                //$("#message").text("No results found");
            } else {
                $("#message").empty();
            }
        }
    });
};

oRsc.searchentireDB = function () {
    $('#report-pdf-links-warning-messages span').text('This feature is available for registered users only. Please login or register for an account.');
    $('#report-pdf-links-warning-messages').modal('show');
};

oRsc.setFilters = function () {
    var self = this, isNavTopFilter;
    oRsc.searchData = $('#sidebarForm').serializeArray();
    var fields = {'to': $('#to-date').val(), 'from': $('#from-date').val()};
    if ($("#show-all-time").prop('checked') == true) {
        //do something
        var chck = true;
    } else {
        chck = false;
    }
    oRsc.searchData.push({name: 'isMobileDevice', value: this.isMobileDevice});
    oRsc.searchData.push({
        name: 'isProjectStage',
        value: $('#project-stage-group').find('label:first-child p,span').hasClass('expanded')
    });
    oRsc.searchData.push({
        name: 'isTransectionType',
        value: $('#transaction-type-group').find('label:first-child p,span').hasClass('expanded')
    });
    oRsc.searchData.push({
        name: 'valueRange',
        value: $('#report-value_range').find('label:first-child p,span').hasClass('expanded')
    });
    oRsc.searchData.push({
        name: 'locationAccuracy',
        value: $('#report-location-accuracy').find('label:first-child p,span').hasClass('expanded')
    });
    oRsc.searchData.push({
        name: 'isReportCode',
        value: $('#report-code-group').find('label:first-child p,span').hasClass('expanded')
    });
    oRsc.searchData.push({
        name: 'isReportType',
        value: $('#report-type-group').find('label:first-child p,span').hasClass('expanded')
    });
    oRsc.searchData.push({
        name: 'isResourcesType',
        value: $('#resources-type-group').find('label:first-child p,span').hasClass('expanded')
    });
    oRsc.searchData.push({
        name: 'isReservesType',
        value: $('#reserves-type-group').find('label:first-child p,span').hasClass('expanded')
    });
    oRsc.searchData.push({
        name: 'isStockExchange',
        value: $('#stock-exchange').find('label:first-child p,span').hasClass('expanded')
    });
    oRsc.searchData.push({
        name: 'isCommodity',
        value: $('#commodity-group').find('label:first-child p,span').hasClass('expanded')
    });
    oRsc.searchData.push({
        name: 'isNavTopFilter',
        value: $('#region-button-seabed-resources').hasClass('region-button-on')
    });
    oRsc.searchData.push({name: 'to', value: $('#to-date').val()});
    oRsc.searchData.push({name: 'from', value: $('#from-date').val()});
    oRsc.searchData.push({name: 'checkbox', value: chck});
    oRsc.searchData.push({
        name: 'isReportformat',
        value: $('#report-type-format').find('label:first-child p,span').hasClass('expanded')
    });
    oRsc.searchData.push({
        name: 'ProjectStatus',
        value: $('#proj_status').find('label:first-child p,span').hasClass('expanded')
    });

};

oRsc.searchColumns = function () {
        return [
            {name: 'ID', width: '3%', valueField: 'id'},
            {name: 'Company', width: '28%', valueField: 'company'},
            {name: 'Ticker', width: '30%', valueField: 'ticker'},
            {name: 'Project', width: '20%', valueField: 'project'},
            {name: 'Deposit', width: '18%', valueField: 'deposit'},
            {name: 'Commodities', width: '20%', valueField: 'commodities'},
            {name: 'CP / QP Affiliation', width: '25%', valueField: 'cpqp'},
            {name: 'Latest Date', width: '12%', valueField: 'date1'}
        ];
};

oRsc.transactionColumns = function () {
    return [
        {name: 'ID', width: '2%', valueField: 'id'},
        {name: 'Company', width: '16%', valueField: 'company'},
        {name: 'Project', width: '14%', valueField: 'project'},
        {name: 'Ticker', width: '14%', valueField: 'ticker'},
        {name: 'Commodities', width: '14%', valueField: 'commodities'},
        {name: 'Latest Date', width: '14%', valueField: 'date'}
    ];
};


oRsc.searchOnly = function () {
    this.isSearchOnly = true;
    this._worldJson = this._worldJsonInitial;
    // Remove Existing Filter
    $('#chart').css('display', 'block');
    this.featureLayer.removeLayer(this._selectedMarkersJson);
    this.featureLayer.removeLayer(this._selectedMarkers);
    this.featureLayer.removeLayer(this.geoJsonLayer);
    this._selectedMarkersJson = [];

    var self = this, checkedValues = oRsc._checkedValues();
    $.each(checkedValues, function (index, val) {
        self.selectedMarkersGeoJson(val);

    });
    this._selectedMarkers = L.geoJson(this._selectedMarkersJson, {
        filter: this.geoJsonFilter,
        onEachFeature: this.featureAdd
    });
    var selectedReports = [];
    $.each(this._selectedMarkers, function (index, val) {
        if (index == '_layers') {
            $.each(val, function (ind, val) {
                selectedReports.push(val._latlng);
            });
        }
    });
    if (selectedReports.length == 1) {
        oRsc.map.setView(L.latLng(selectedReports[0].lat, selectedReports[0].lng), 2);
    } else {
        var bounds = new L.LatLngBounds(selectedReports);
        oRsc.map.fitBounds(bounds);
    }
    this.featureLayer.addLayer(this._selectedMarkers);
    // Clear Filter
    // var $sidebarGroup = $('.sidebar-group');
    // $sidebarGroup.find('label .expander').removeClass('collapsed').addClass('expanded');
    // $sidebarGroup.find('div.content').show();
    var RegionButton = $('.region-button-on').text();
    // $(".uncheck-all").each(function() {
    //         $(this).prop('checked', false);
    // });
    if (" Transaction Reports" == RegionButton) {
        // var selectedMark=this._selectedMarkersJson;
        // for(var i=0;i<selectedMark.length;i++){
        //     str=selectedMark[i].properties.cls;
        //     commodity=selectedMark[i].properties.commo;
        //     range=selectedMark[i].properties.range;
        //     prj=selectedMark[i].properties.prj;
        //     type=selectedMark[i].properties.type;
        //     se1=selectedMark[i].properties.se1;
        //     se2=selectedMark[i].properties.se2;
        //     se3=selectedMark[i].properties.se3;
        //     accuracy=selectedMark[i].properties.accuracy;
        //     str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
        //         return letter.toUpperCase();
        //     });
        //     if(range==null)
        //         range='n/a';
        //     $(".uncheck-all").each(function() {
        //         if($(this).val()==str || commodity.indexOf($(this).val())!=-1 || $(this).val()==range  || $(this).val()==prj
        //             || $(this).val()==type || $(this).val()==se1 || $(this).val()==se2 || $(this).val()==se3 || $(this).val()==accuracy ){
        //             $(this).prop('checked', true);
        //             var id=$(this).attr('id');
        //              if(id=='n/a'){
        //                  id='n\\\\a';
        //                  $('span#'+id).addClass('filter-background');
        //                  $('a.report-value_range').css('display','inline');
        //                  $('p.report-value_range').css('text-decoration', 'underline');
        //              }
        //              else{
        //                  $('span#'+id).addClass('filter-background');
        //                  var span=$('#'+id).parent().attr('class');
        //                  var id = span.split(" ");
        //                  var str2 = id[1];
        //                  $('a.' + str2).css('display', 'inline');
        //                  $('p.' + str2).css('text-decoration', 'underline');
        //              }
        //             $('#clear_filters').css('display','block');
        //         }
        //
        //     });
        // }

    } else {
        // var selectedMark=this._selectedMarkersJson;
        // for(var i=0;i<selectedMark.length;i++){
        //     str=selectedMark[i].properties.cls;
        //     commodity=selectedMark[i].properties.commo;
        //     prj_stage=selectedMark[i].properties.prj;
        //     status=selectedMark[i].properties.status;
        //     status=selectedMark[i].properties.status;
        //     type=selectedMark[i].properties.type;
        //     code=selectedMark[i].properties.code;
        //     reserve=selectedMark[i].properties.reserve;
        //     str = str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
        //         return letter.toUpperCase();
        //     });
        //     $(".uncheck-all").each(function() {
        //         if($(this).val()==str || commodity.indexOf($(this).val())!=-1 || $(this).val()== prj_stage || $(this).val()== status || $(this).val()== code || type .indexOf($(this).val())!=-1 || $(this).val()== reserve){
        //             $(this).prop('checked', true);
        //             var id=$(this).attr('id');
        //             $('span#'+id).addClass('filter-background');
        //                 var span=$('#'+id).parent().attr('class');
        //                 var id = span.split(" ");
        //                 var str2 = id[1];
        //                     $('a.' + str2).css('display', 'inline');
        //                     $('p.' + str2).css('text-decoration', 'underline');
        //                     $('#clear_filters').css('display','block');
        //         }
        //     });
        // }
    }
    // Set Filter
    this.setSearchFilter();

};


oRsc._checkedValues = function () {
    return $('.chk-auto-complete:checked').map(function () {
        return this.value;
    }).get();
};

oRsc._exitSearch = function () {
    this._worldJson = this._worldJsonInitial;
    this.isSearchOnly = false;
    var $search = $('#search'), $btnClose = $('.close-icon');
    $search.val('');
    $btnClose.css('display', 'none');
    if (!jQuery('body').hasClass('logged-in') || oRsc.userPlan == 'Plan1') {
        $('span#commodity-g').addClass('filter-background');
    }

    $('.rsc-search-loading').hide();
    $('#btn-clear-search').remove();
    // Remove Existing Feature
    oRsc.c_reporting = true;
    this.featureLayer.removeLayer(this.geoJsonSearch);
    this.featureLayer.removeLayer(this._selectedMarkersJson);
    this.featureLayer.removeLayer(this._selectedMarkers);
    // Added default features
    // this.featureLayer.addLayer(this.geoJsonLayer);
    // $('#region-button-world').removeClass().addClass('region-button region-button-on');
    // $('#region-button-new-resource').removeClass().addClass('region-button region-button-off');
    // $('#region-button-reserve').removeClass().addClass('region-button region-button-off');
    // $('#region-button-exploration').removeClass().addClass('region-button region-button-off');
    // $('#region-button-seabed-resources').removeClass().addClass('region-button region-button-off');


    // Display Search Only
    $('#search-results-only').css('display', 'none');

    oRsc.runFilter();
};

oRsc.selectedMarkersGeoJson = function (val) {
    var self = this;
    $.each(this.geoSearchJson, function (index, json) {
        if (json.id == val) {
            self._selectedMarkersJson.push(json);
        }
    });
};

oRsc.setSearchFilter = function () {
    oRsc.Code_JORC = 0;
    oRsc.Code_ENV = 0;
    oRsc.Code_NI43_101 = 0;
    oRsc.Code_OTHER = 0;
    oRsc.Type_eia = 0;
    oRsc.Type_explore = 0;
    oRsc.Type_resource = 0;
    oRsc.Type_optimisation = 0;
    oRsc.Type_pea = 0;
    oRsc.Type_supporting = 0;
    oRsc.Type_pre = 0;
    oRsc.Type_feasibility = 0;
    var code, type, resource, reserves, commodities, data;
    $.each(this.geoSearchJson, function (index, json) {
        data = json.properties;
        code = (data.code !== null) ? data.code.toLowerCase() : '';
        type = (data.type !== null) ? data.type.toLowerCase().replace(" ", "-") : '';
        resource = (data.status !== null) ? data.status.toLowerCase().replace(" ", "-") : '';
        reserves = (data.reserve !== null) ? data.reserve.toLowerCase().replace(" ", "-") : '';

        // Report Code
        if (code === '(enviro)') {
            code = '#code-environmental';
            oRsc.Code_ENV++;
        } else if (code === 'ni43-101') {
            oRsc.Code_NI43_101++;
            code = '#code-ni-43-101';
        } else if (code === 'jorc') {
            oRsc.Code_JORC++;
            code = '#code-jorc';
        } else {
            oRsc.Code_OTHER++;
            code = '#code-other';
        }

        // Report Type
        if (type === 'eia/esia') {
            oRsc.Type_eia++;
            type = '#type-eia-esia';
        } else if (type === 'exploration/drilling-update') {
            oRsc.Type_explore++;
            type = '#type-exploration-update';
        } else if (type === 'resource estimation') {
            oRsc.Type_resource++;
            type = '#type-resource-estimation';
        } else if (type === 'optimisation study') {
            oRsc.Type_optimisation++;
            type = '#type-optimisation-study';
        } else if (type === 'pea') {
            oRsc.Type_pea++;
            type = '#type-type-Scoping-Study-and-pea';
        } else if (type === 'supporting acquisition') {
            oRsc.Type_supporting++;
            type = '#type-supporting-acquisition';
        } else if (type === 'pre-feasibility study') {
            oRsc.Type_pre++;
            type = '#type-pre-feasibility';
        } else if (type === 'feasibility study') {
            oRsc.Type_feasibility++;
            type = '#type-feasibility';
        }


        // Resource
        resource = '#resource-' + resource;

        // Reserves
        reserves = '#reserves-' + reserves;

        $(code).prop('checked', true);
        $(type).prop('checked', true);
        $(resource).prop('checked', true);
        $(reserves).prop('checked', true);

        // Commodities
        commodities = data.commo.toLowerCase().split("-");
        for (var i = 0; i < commodities.length; i++) {
            $('#commodity-' + commodities[i]).prop('checked', true);
        }
    });
};
