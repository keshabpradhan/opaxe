/**
 * Created by ARslan on 12/21/2017.
 */
oRsc.queryAll = function () {
    $('#loading-spin-markers').show();

    var self = this, isNavTopFilter;
    oRsc.setFilters();
    if ($('#region-button-trans-reports').hasClass('region-button-on')) {
        var path = "?action=getAllTrans";
        oRsc.trans_call = true;
    }
    else {
        var path = "?action=getAll";
        oRsc.trans_call = false;
    }
    var url = SCRIPT_PATH + path,
        data = $('#sidebarForm').serializeArray();
    var fields = {'to': $('#to-date').val(), 'from': $('#from-date').val()};
    if ($("#show-all-time").prop('checked') == true) {
        var chck = true;
    }
    else {
        chck = false;
    }
    data.push({name: 'isMobileDevice', value: this.isMobileDevice});

    if ($('#project-stage-group').find('label:first-child p,span').hasClass('expanded') == false )
        var isProjectStage = $('a.project-stage-group').is(':visible');
    else
        isProjectStage =  $('#project-stage-group').find('label:first-child p,span').hasClass('expanded');

    data.push({
        name: 'isProjectStage',
        value: isProjectStage
    });

    if ($('#transaction-type-group').find('label:first-child p,span').hasClass('expanded') == false )
        var isTransectionType = $('a.transaction-type-group').is(':visible');
    else
        isTransectionType =  $('#transaction-type-group').find('label:first-child p,span').hasClass('expanded');

    data.push({
        name: 'isTransectionType',
        value: isTransectionType
    });

    if ($('#report-value_range').find('label:first-child p,span').hasClass('expanded') == false )
        var valueRange = $('a.report-value_range').is(':visible');
    else
        valueRange =  $('#report-value_range').find('label:first-child p,span').hasClass('expanded');

    data.push({
        name: 'valueRange',
        value: valueRange
    });

    if ($('#report-location-accuracy').find('label:first-child p,span').hasClass('expanded') == false )
        var locationAccuracy = $('a.report-location-accuracy').is(':visible');
    else
        locationAccuracy =  $('#report-location-accuracy').find('label:first-child p,span').hasClass('expanded');


    data.push({
        name: 'locationAccuracy',
        value: locationAccuracy
    });

    if ($('#report-code-group').find('label:first-child p,span').hasClass('expanded') == false )
        var isReportCode = $('a.report-code-group').is(':visible');
    else
        isReportCode =  $('#report-code-group').find('label:first-child p,span').hasClass('expanded');

    data.push({
        name: 'isReportCode',
        value: isReportCode
    });

    if ($('#report-type-group').find('label:first-child p,span').hasClass('expanded') == false )
        var isReportType = $('a.report-type-group').is(':visible');
    else
        isReportType =  $('#report-type-group').find('label:first-child p,span').hasClass('expanded');


    data.push({
        name: 'isReportType',
        value: isReportType
    });

    if ($('#resources-type-group').find('label:first-child p,span').hasClass('expanded') == false )
        var isResourcesType = $('a.resources-type-group').is(':visible');
    else
        isResourcesType =  $('#resources-type-group').find('label:first-child p,span').hasClass('expanded');

    data.push({
        name: 'isResourcesType',
        value: isResourcesType
    });

    if ($('#reserves-type-group').find('label:first-child p,span').hasClass('expanded') == false )
        var isReservesType = $('a.reserves-type-group').is(':visible');
    else
        isReservesType =  $('#reserves-type-group').find('label:first-child p,span').hasClass('expanded');

    data.push({
        name: 'isReservesType',
        value: isReservesType
    });

    if ($('#stock-exchange').find('label:first-child p,span').hasClass('expanded') == false )
        var isStockExchange = $('a.stock-exchange').is(':visible');
    else
        isStockExchange = $('#stock-exchange').find('label:first-child p,span').hasClass('expanded');

    data.push({
        name: 'isStockExchange',
        value: isStockExchange
    });


    if ($('#commodity-group').find('label:first-child p,span').hasClass('expanded') == false )
        var commodityFilter = $('#clear-commodities').is(':visible');
    else
        commodityFilter =  $('#commodity-group').find('label:first-child p,span').hasClass('expanded');
    data.push({
        name: 'isCommodity',
        value: commodityFilter
    });

    if($('.search-category').is(':visible')) {
        data.push({
            name: 'searchFilter',
            value: $('.search-category').text()
        });
        data.push({
            name: 'searchValue',
            value: $.trim($('#search').val())
        });
    }
    data.push({name: 'isNavTopFilter', value: $('#region-button-seabed-resources').hasClass('region-button-on')});
    data.push({name: 'to', value: $('#to-date').val()});
    data.push({name: 'from', value: $('#from-date').val()});
    data.push({name: 'checkbox', value: chck});

    if ($('#report-type-format').find('label:first-child p,span').hasClass('expanded') == false )
        var isReportformat = $('a.report-type-format').is(':visible');
    else
        isReportformat = $('#report-type-format').find('label:first-child p,span').hasClass('expanded');

    data.push({
        name: 'isReportformat',
        value: isReportformat
    });

    if ($('#proj_status').find('label:first-child p,span').hasClass('expanded') == false )
        var ProjectStatus = $('a.proj_status').is(':visible');
    else
        ProjectStatus = $('#proj_status').find('label:first-child p,span').hasClass('expanded');

    data.push({name: 'ProjectStatus', value: ProjectStatus });
    data.push({name: 'pdf_url', value: oPdf.pdf_url});
    $.post(url, data, function (response) {

        oRsc.featureLayer.removeLayer(oRsc.geoJsonLayer);
        if (response.success) {
            oRsc.featureLayer.removeLayer(oRsc.geoJsonLayer);

            if (response.reports) {
                self._worldJson = response.reports;
                self._worldJsonInitial = response.reports;
                oRsc.reportIds = response.reportIDs;
                self._lookup = response.lookup;
                oRsc.filteres_reports = response.reports;
                self.overlayReports();

            }
            $('#loading-spin-markers').hide();
        } else {
            oRsc.featureLayer.removeLayer(oRsc.geoJsonLayer);
            oRsc.featureLayer.removeLayer(oRsc._selectedMarkers);
            $("#userLogout").html("LOGIN");
            $("#userLogout").attr("href", "/login");
            $('#loading-spin-markers').hide();
            //Todo: Display some error
        }
        // oRsc.customReporting();
    }, 'json');

};

oRsc.userMembershipLevels = function () {

    //$('#loading-spin-markers').show();
    var self = this, isNavTopFilter;
    var url = SCRIPT_PATH + "?action=userMembershipLevels";
    $.post(url, function (response) {
        if (response) {
            oPdf.pdf_url = localStorage.getItem("pdf_Url");
            oPdf.pdf_temporary_url = localStorage.getItem("pdf_temporary_Url");
            if (oPdf.pdf_url)
            {
                 rep = oPdf.pdf_url.split('-');
                 if($.isNumeric(rep[0]) && $.isNumeric(rep[1]))
                 {
                         oRsc.isDatePeriod = true;
                 }
                 else
                 {
                     oPdf.viewReportonLoad(oPdf.pdf_url);
                     oRsc.isDatePeriod = false;
                 }

            }


            if (response.userStatus == "UserLogout") {
            } else {
                oRsc.CurrentUser = response;
                if ((oPdf.pdf_temporary_url) && (response.subPlan == 'Plan2')) {
                    oPdf.viewReportonLoad(oPdf.pdf_temporary_url);
                    localStorage.setItem("pdf_temporary_Url", '');

                }
                $('#phone').val(response.phone);
                if (response.subPlan == 'Free' || response.subPlan == '') {
                }
                else {
                    $("#transactionBtnPartDown p").off();
                }
                oRsc.userPlan = response.subPlan;
                oRsc.reportIds = response.reportIDs;
                oRsc.last_visit = response.lastVisit;
                oRsc.dailyDownloads = parseInt(response.Dailydownloads[0]);
                oRsc.weeklyDownloads = parseInt(response.weeklyDownloads[0]);

                var TotalpdfDownloads = response.totalDownloads[0];
                $('.today-downloads').text(response.Dailydownloads[0] + ' / ' + ' 3');
                $('.weekly-downloads').text(response.weeklyDownloads[0] + ' /' + '10');
                $('#pdf-credit').empty();
                $('#pdf-credit').text(response.weeklyDownloads[0] + ' /' + '10');
                $('.total-downloads').text(TotalpdfDownloads);

                var userProfile = ' <span id="user-name-header">' + 'Welcome  ' + response.firstName + '</span>';
                userProfile += '<div class="dropdown" aria-hidden="true" id="userProfile"><div id="img-dist">';
                userProfile += '</div>';
                userProfile += '<div class="dropdown-content" id="myDropdown">';
                userProfile += '<div id="first-row-user-profile">';
                userProfile += '<span id="user-name">Membership:</span> <span class="plan-name">' + response.subPlan + '</span><a href="/user-profile?ihc_ap_menu=subscription" class="upgrade-plan">  (upgrade)</a>';
                userProfile += '<div><span style="all: unset;text-transform: initial">Registered Since ' + response.userRegistered + '</span></div>';
                userProfile += '</div>';
                userProfile += '<a class="User-dropdown-Last2" href="/user-profile?ihc_ap_menu=profile">MANAGE PROFILE</a>';
                var shared_url = false;
                // userProfile += '<a class="User-dropdown-Last2 last2-links" onclick="oPdf.weeklyBulletin(' + shared_url + ');" href="#">Weekly Intel Bulletin</a>';
                // userProfile += '<a class="User-dropdown-Last2 last2-links" onclick="oRsc.underDeveolpment()" href="#">List of published reports (PDF)</a>';
                userProfile += '<a class="User-dropdown-Last2 saved-pref"  href="/user-profile?ihc_ap_menu=savedPreferences">SAVED PREFERENCES</a>';
                // userProfile += '<a class="User-dropdown-Last2" href="#">My Downloads</a>';
                userProfile += '<a class="User-dropdown-Last2"  onclick="oRsc.onlogOut();" href="/iump-logout-2?ihcdologout=true">LOGOUT</a></div></div>';
                $('#menu_section.unpad_right .sf-menu>li:last-child').empty();
                $("#menu_section.unpad_right .sf-menu>li:last-child").append(userProfile);
                $('.header-menu-search-bar').removeClass('header-menu-search-bar');
                if (response.subPlan == 'Plan1') {
                    $('#clear-commodities').removeClass('reset-filter-link').addClass('gold-only');
                    $('#clear-commodities').text('gold only').css('display', 'inline');
                    $('span#commodity-g').addClass('filter-background');
                    $('.saved-pref').css('display', 'none');
                    $('.plan-name').text('SILVER');
                    sessionStorage.setItem("selectedMode", "false");
                }
                else if (response.subPlan == 'Plan2') {
                    $('.plan-name').text('GOLD');
                }
                else if (response.subPlan == 'Plan3') {
                    $('.plan-name').text('PLATINUM');
                }

                $("#img-dist").css("background", "url(" + response.imageUrl + ")50% 50% no-repeat");
                oRsc.comp_text = 'I would like to report a compliance or data error issue with this report.';
                $('#text').hide();
                $('#subscribe').hide();

            }


            $("#userLogout").html("LOGOUT");
            $("#user_login").html(response.userStatus);
            // if (response.userStatus == 'php-dev') {
            //     $("#my-activity-log").show();
            // }
        }
        if(oRsc.isDatePeriod == false){
            oRsc.getDefaultMode();
        }
        else {
            var from_date = rep[0].substring(0, 4) + '-' + rep[0].substring(4, 6) + '-' + rep[0].substring(6, 8);
            var to_date = rep[1].substring(0, 4) + '-' + rep[1].substring(4, 6) + '-' + rep[1].substring(6, 8);
            oPdf.setDateperiod(from_date,to_date);
            localStorage.setItem("pdf_Url", '');
        }

    }, 'json');
};
oRsc.getReportDetailById = function (report_id) {
    var feature = $.grep(geoJson, function (e) {
        return e.id == report_id;
    });
    return feature[0].properties;
};

oRsc.showDownloadedReports = function () {
    var region = $('.region-button-on').text();
    var that = this;
    if (" Transaction Reports" != region) {
        oRsc.viewAll = true;
        $("#region-button-trans-reports").click();
    }
    else {
        var $search = $('#search'), $btnClose = $('.close-icon'), $rscSearchIcon = $('.rsc-search-icon');
        $btnClose.show();
        $rscSearchIcon.hide();
        $search.val('Downloaded Reports');
        geoJson = oRsc.downloadedReports;
        that.featureLayer.removeLayer(this.geoJsonLayer);
        that.geoJsonLayer = L.geoJson(geoJson, {
            onEachFeature: this.featureAdd

        });
        that.featureLayer.addLayer(this.geoJsonLayer);
        $('#loading-spin-markers').delay(2000).hide(0);
        $btnClose.click(function () {
            $btnClose.css('display', 'none');
            $rscSearchIcon.css('display', 'block');
            oRsc._exitSearch();
        });
    }

};

oRsc.overlayReports = function () {
    // Build GeoJson Layer
    $('#loading-spin-markers').show();
   // geoJson = this.getGeoJson().concat(oRsc.geoJsonSearch);
    geoJson = this.getGeoJson();
    oRsc.geojsonLength = geoJson.length;
    oRsc.curr_feature = 0;
    if (oRsc.viewAll == true) {
        $('#view-downloaded-rep').click();
        oRsc.viewAll = false;
    }
    else {
        this.featureLayer.removeLayer(this.geoJsonLayer);
        // this.featureLayer.removeLayer(this.geoJsonSearch);
        // this.featureLayer.removeLayer(this._selectedMarkersJson);
        this.featureLayer.removeLayer(this._selectedMarkers);
        this.geoJsonLayer = L.geoJson(geoJson, {
            onEachFeature: this.featureAdd

        });
        this.featureLayer.addLayer(this.geoJsonLayer);
        if(!oRsc.isMobileDevice)
        {
            southWest = L.latLng(90, -180);
            northEast = L.latLng(-70, 190); //bottom,right
            bounds = L.latLngBounds(southWest, northEast);
            oRsc.map.setMaxBounds(bounds);
            oRsc.map.on('drag', function() {
                oRsc.map.panInsideBounds(bounds, { animate: false });
            });
        }

    }
};

oRsc.getGeoJson = function () {
    // var data = $.merge(this._worldJson,oRsc.searchWorldjson),
    //     lookup = $.merge(this._lookup,oRsc.searchLookup);
    var data = this._worldJson;
        lookup = this._lookup;
    var geoJson = [];
    for (var i = 0; i < data.length; i++) {
        var point = data[i];
        var symbol = "o";
        if (point[lookup.code] == 'NI43-101' || point[lookup.code] == 'NI 43-101') {
            symbol = "n";
        }
        if (point[lookup.code] == 'JORC') {
            symbol = "j";
        }
        if (point[lookup.code] == '(Enviro)') {
            symbol = "e";
        }
        if (point[lookup.project_stage] == 'exploration') {
            symbol = "e";
        }
        if (point[lookup.project_stage] == "mining" || point[lookup.project_stage] == "Mining") {
            symbol = "m";
        }
        if (point[lookup.project_stage] == "care and maintenance") {
            symbol = "c";
        }
        if (point[lookup.project_stage] == "resource development") {
            symbol = "r";
        }
        if (point[lookup.project_stage] == "n/a") {
            symbol = "t";
        }

        var colour = '';

        if ($('#region-button-trans-reports').hasClass('region-button-on')) {

            // var colour = 'resource-trans';//"#D65076";


            // remove letters and add default 3 marker rather than pink
            symbol = "$";

            // console.log(point[lookup.project_stage]);

            if (point[lookup.project_stage] == "mining" || point[lookup.project_stage] == "Mining" || point[lookup.project_stage] == "care and maintenance" ) {
                colour = 'mining'; //"#009273";
            }

            else if (point[lookup.project_stage] == "exploration" || point[lookup.project_stage] == "Exploration") {
                colour = 'exploration'; //"#505050";
            }
            else if (point[lookup.project_stage] == "resource development") {
                colour = 'resource-definition'; //"#1F51A4";
            }
            else {
                colour = 'mining'; //"#009273";
            }
        }

        else {
            colour = 'exploration'; //"#505050";
        }

        if (point[lookup.prj_status] == "mining") {

            colour = 'mining'; //"#009273";
        }

        if (point[lookup.prj_status] == "exploration") {
            colour = 'exploration'; //"#505050";
        }
        if (point[lookup.prj_status]== "resource definition") {
            colour = 'resource-definition'; //"#1F51A4";
        }
        // if (point[lookup.prj_status] == 'Upgraded') {
        //     colour = "#009273";
        // }
        // if (point[lookup.status] == 'Not Defined') {
        //     colour = "#808080";
        // }

        if ($('#region-button-trans-reports').hasClass('region-button-on')) {
            var lat = point[lookup.latitude],
                lng = point[lookup.longitude],
                reserve = point[lookup.reserve_status] == null ? null : point[lookup.reserve_status].toLowerCase();
            var single = {
                id: point[lookup.id],
                type: 'Feature',
                "geometry": {"type": "Point", "coordinates": [lng, lat]},
                "properties": {
                    "sym": symbol,
                    "cls": colour,
                    "lat": point[lookup.latitude],
                    "lon": point[lookup.longitude],
                    "range": point[lookup.value_range],
                    "prj": point[lookup.project_stage],
                    "commo": point[lookup.commodities],
                    "type": point[lookup.type],
                    "se1": point[lookup.se1],
                    "se2": point[lookup.se2],
                    "se3": point[lookup.se3],
                    "accuracy": point[lookup.accuracy],
                }
            };
            $.each(oRsc.reportIds, function (index, value) {

                var idx = $.inArray(point[lookup.id], oRsc.downloadedReports);
                if (value[0] == point[lookup.id] && idx == -1)
                    oRsc.downloadedReports.push(single);
            });
        }
        else {
            var lat = this.decimalFromSexagesimal(point[lookup.latitude]),
                lng = this.decimalFromSexagesimal(point[lookup.longitude]),
                reserve = point[lookup.reserve_status] == null ? null : point[lookup.reserve_status].toLowerCase();
            var single = {
                id: point[lookup.id],
                type: 'Feature',
                "geometry": {"type": "Point", "coordinates": [lng, lat]},
                "properties": {
                    "cls": colour,
                    "sym": symbol,
                    "lat": point[lookup.latitude],
                    "lon": point[lookup.longitude],
                    "range": point[lookup.value_range],
                    "prj": point[lookup.project],
                    "commo": point[lookup.commodities],
                    "status": point[lookup.status],
                    "code": point[lookup.code],
                    "type": point[lookup.type],
                    "reserve": point[lookup.reserve_status],
                }
            };
        }
        geoJson.push(single);
    }

    return geoJson;
};

//Report box modal height for history tab
oRsc.changetabheight = function () {
    $('#history_conatiner #row_0').click();
};
//Report box modal height for history tab in Tech mode
oRsc.changetabheightTechMode = function () {
    $('.active').addClass('de-active');
};

//for non register user on click of commodities other than gold
oRsc.registerforComm = function () {
    $('#commodity_checkboxes_popup').modal('hide');
    $('#plansModel').modal('show');
};
//Remove report box from sidebar on close button
oRsc.closeReportbox = function () {
    oRsc.map.closePopup();
    $('.text-above-popup').remove();
    $('.highlightMarker').addClass(oRsc.markerClass).removeClass('highlightMarker');
    $("#reportbox_popup").remove();
    $('#filters').css('display', 'block');
    $('#report_box').css('border', '');
    $('#1px solid beige').css('border', '');
    $('.sidebar-group p').css('display', 'block');
    $('.sidebar-form-below-div2').css('height', 'unset');
    oPdf.replaceUrl();
};
//Remove Report box history tab height when user change it to summary tab
oRsc.removetabheight = function () {
    oRsc.selectedReport = oRsc.currentReport;
    $('.leaflet-popup-content-wrapper').css('height', 'unset');
};

oRsc.removetabheightTechReport = function (feature) {
    $('.leaflet-popup-content-wrapper').css('height', 'unset');
};

oRsc.loggedin = function () {
    $('.login-error-message').remove();
    var fields = {
        userName: $('#iump_login_username').val(),
        password: $('#iump_login_password').val()
    };
    var url = SCRIPT_PATH + '?action=checkUserstatus';
    $.post(url, fields, function (response) {
        if (response.success) {
            if (response.active != '1') {
                $('.login-error-message').remove();
                $('.user-password').after('<span style="color:red" class="login-error-message">Your account is not active yet.</span>');
            }
            else {
                $('#login').click();
            }
        } else {
            // Todo: Display error msg
            $('.login-error-message').remove();
            $('.user-password').after('<span style="color:red" class="login-error-message">Wrong email or password, please try again.</span>');
        }

    }, 'json');
};
//open Register page on Sign up free click
oRsc.register = function () {
    $('.modal').modal('hide');
    $('#plansModel').modal('show');
    var sone = [];
    sone['action'] = 'button:signup';
    sone['action_log'] = 'view plans';
    oRsc.activity_log(sone);
};
//open when user click under deveolpment options
oRsc.underDeveolpment = function () {
    $('#under-deveolpment').modal('show');
};
//Display Login error message
oRsc.Loginerrors = function () {
    $('#login-erorr-modal').modal('hide');
    $('#login-modal').modal('show');
};

//Close Trans modal
oRsc.closeTrans = function () {
    $('#trans-modal').modal('hide');
};

//open signup model on click on register for free
oRsc.openSignupmodel = function () {
    $('.Tooltip-trans-header').hide();
    $('#trans-modal').modal('hide');
    $('#plansModel').modal('show');
};

oRsc.openLoginmodel = function () {
    $('.Tooltip-trans-header').hide();
    $('#login-modal').modal('show');
};
oRsc.reportById = function (rid) {
    var self = this, feature;
    if ($('#region-button-trans-reports').hasClass('region-button-on')) {
        var path = "?action=getTransReportById";
        var found = true;
        var fields = {'rid': rid, 'found': found};
    }
    else {
        var path = "?action=getReportById";
        found = false;
        var fields = {'rid': parseInt(rid), 'found': found};
    }


    var url = SCRIPT_PATH + path;
    $.post(url, fields, function (response) {
        if (response.success) {
            if (response.reports) {
                feature = response.reports[0];

                //Add Google Analytics Events
                ga('send', {
                    hitType: 'event',
                    eventCategory: 'Intel',
                    eventAction: 'MarkerClick',
                    eventLabel: feature.url_name
                });
                self.selectedReport = feature;
                self.displayFeaturePopup(feature);

                if ($('#region-button-trans-reports').hasClass('region-button-on')) {
                    self.selectedReport = feature;
                    self.displayFeaturePopup(feature);
                    self.getTransHistory(feature);
                }
                else {
                    self.getHistory(feature);
                }
            }
        } else {
            //Todo: Display some erro
        }
    }, 'json');
};

$('#info-tag').click(function () {
    $('#trans-modal').modal('show');
});
