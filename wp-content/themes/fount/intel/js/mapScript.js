function decimalFromSexagesimal(input) {
    var d1 = input.split("°");
    var degs = Number(d1[0].trim());
    var d2 = d1[1].split("'");
    var d3 = d2[1].split('"');
    var secs = Number(d3[0]) / 60;
    var mins = (Number(d2[0]) + secs) / 60;
    var val = mins+degs;
    if (d3[1] == 'S' || d3[1] == 'W') {
        val = val * -1;
    }
    return val;
}

function initialiseEverything() {

    searchEnabled = false;

    //Parse.initialize("CroCUrbGQVQZgMz3wdZzH6tNerAo4yCt80E2l0rq", "hqYOi2j8hdyIwlc0XOTCe2kQrv80FAItwDGVOB10");

    L.mapbox.accessToken = 'pk.eyJ1IjoibXJjbGFya3NvbiIsImEiOiJuTmlPaTM0In0.hImtadsV4kMLI_iihZkILg';
    map = L.mapbox.map('map', 'mrclarkson.led029e4', {
        zoomControl: false,
        tileLayer: {
            continuousWorld: false,
            noWrap: true
        }
    });

    new L.Control.Zoom({
        position: 'topright'
    }).addTo(map);

    terrainLayer = L.mapbox.tileLayer('mrclarkson.l4be5cih', {
        continuousWorld: false,
        noWrap: true
    });

    geoJsonLayer = L.geoJson([], {
        onEachFeature: featureAdd
    });

    featureLayer = L.mapbox.featureLayer().addTo(map);

    clusterGroup = new L.MarkerClusterGroup({
        maxClusterRadius: 5,
        spiderfyDistanceMultiplier: 3
    });
    map.addLayer(clusterGroup);

    terrainLayer.on('ready', function(layer) {
        queryAll();
        runFilter();
    });

    map.on('popupopen', function(e) {
        var px = map.project(e.popup._latlng);
        px.y -= e.popup._container.clientHeight/2
        px.y -= 50;
        if ($('#map-sidebar-container').is(":visible")) {
            px.x -= $('#map-sidebar-container').width()/2;
        }
        map.panTo(map.unproject(px),{animate: true});
    });

    $("#from-date").datepicker({ dateFormat: 'M d, yy' });
    $("#to-date").datepicker({ dateFormat: 'M d, yy' });

    $("#layer-toggle").html('See satellite map');
    $("#layer-toggle").addClass('active');
    $(".leaflet-container").css("background", "#8bd1e3");
    //terrainLayer.addTo(map);

    $("input[type=checkbox]").change(function() {
        if ($(this).attr('id') != 'show-all') {
            $('#show-all').prop('checked', false);
        }
        else {
            if ($('#show-all').prop('checked') == true) {
                $(".uncheck-all").each(function() {
                    $(this).prop('checked', true);
                });
                $(".rsc-select-all").each(function() {
                    $(this).prop('checked', true);
                });

                //$("input[type=text]").val('');
                $("input.rsc-text").val('');
            }
            else {
                $(".uncheck-all").each(function() {
                    $(this).prop('checked', false);
                });
                $(".rsc-select-all").each(function() {
                    $(this).prop('checked', false);
                });
            }
        }
        runFilter();
    });
    $("input.rsc-text").change(function() {
        if ($(this).attr('id') != 'show-all' && $(this).attr('id') != 'search') {
            $('#show-all').prop('checked', false);
            $("#show-all-time").prop('checked', false);
        }
        runFilter();
    });
    $(".region-button").click(function() {
        selectRegion($(this))
    });
    $("#layer-toggle").click(function() {
        if (!$("#layer-toggle").hasClass('active')) {
            $("#layer-toggle").html('See satellite map');
            $("#layer-toggle").addClass('active');
            $(".leaflet-container").css("background", "#8bd1e3");
            map.removeLayer(terrainLayer);
        } else {
            $("#layer-toggle").html('See political map');
            $("#layer-toggle").removeClass('active');
            $(".leaflet-container").css("background", "#040B15");
            terrainLayer.addTo(map);
        }
    });

    $("#uncheck-all-codes").change(function() {
        if ($(this).prop('checked') == true) {
            $(".uncheck-all-codes").each(function() {
                $(this).prop('checked', true);
            });
        }
        else {
            $(".uncheck-all-codes").each(function() {
                $(this).prop('checked', false);
            });
            $('#show-all').prop('checked', false);
        }
        runFilter();
    });
    // Check if all code active
    $(".uncheck-all-codes").change(function() {
        if (!$('input.uncheck-all-codes[type=checkbox]:not(:checked)').length)
            $('#uncheck-all-codes').prop('checked', true);
        else
            $('#uncheck-all-codes').prop('checked', false);
    });
    $(".rsc-select-all").change(function() {
        if (!$('input.rsc-select-all[type=checkbox]:not(:checked)').length)
            $('#show-all').prop('checked', true);
        else
            $('#show-all').prop('checked', false);
    });


    $("#uncheck-all-commodities").change(function() {
        if ($(this).prop('checked') == true) {
            $(".uncheck-all-commodities").each(function() {
                $(this).prop('checked', true);
            });
        }
        else {
            $(".uncheck-all-commodities").each(function() {
                $(this).prop('checked', false);
            });
            $('#show-all').prop('checked', false);
        }
        runFilter();
    });

    $("#uncheck-all-types").change(function() {
        if ($(this).prop('checked') == true) {
            $(".uncheck-all-types").each(function() {
                $(this).prop('checked', true);
            });
        }
        else {
            $(".uncheck-all-types").each(function() {
                $(this).prop('checked', false);
            });
            $('#show-all').prop('checked', false);
        }
        runFilter();
    });

    $("#uncheck-all-resources").change(function() {
        if ($(this).prop('checked') == true) {
            $(".uncheck-all-resources").each(function() {
                $(this).prop('checked', true);
            });
        }
        else {
            $(".uncheck-all-resources").each(function() {
                $(this).prop('checked', false);
            });
            $('#show-all').prop('checked', false);
        }
        runFilter();
    });

    $("#show-last-month").click(function() {
        $('#show-all-time').prop('checked', false);
        var m = new Date();
        m.setMonth(m.getMonth() - 1);
        $('#from-date').datepicker('setDate', m);
        $('#to-date').datepicker('setDate', new Date());
        $('#show-all').prop('checked', false);
        runFilter();
    });

    $("#show-last-week").click(function() {
        $('#show-all-time').prop('checked', false);
        var oneWeekAgo = new Date();
        oneWeekAgo.setDate(oneWeekAgo.getDate() - 7);
        $('#from-date').datepicker('setDate', oneWeekAgo);
        $('#to-date').datepicker('setDate', new Date());
        $('#show-all').prop('checked', false);
        runFilter();
    });

    $("#show-all-time").change(function() {
        if ($(this).prop('checked') == true) {
            $("input[type=text]").val('');
        }
        else {
            var m = new Date();
            m.setMonth(m.getMonth() - 1);
            $('#from-date').datepicker('setDate', m);
            $('#to-date').datepicker('setDate', new Date());
            $('#show-all').prop('checked', false);
            runFilter();
        }
        runFilter();
    });

    // Info Link
    $("div.tooltip").mouseover(function(){
        var position = $(this).offset();
        var top =position.top - $(document).scrollTop() - 6;
        var left =position.left + 32;
        $("div.tooltip-popup").css({'top': top, 'left': left, 'display': 'inline'} );

        var popupContent;
        if(this.id == "tooltip-Scoping-Study-and-pea"){
            popupContent = "Preliminary Economic Assessment.";
        }
        if(this.id == "tooltip-eia-esia"){
            popupContent = "Environmental (Social) Impact Assessment. NB these are not technical reports.";
        }

        $("div.tooltip-popup > p").html(popupContent);
    });
    $("div.tooltip").mouseout(function(){
        $("div.tooltip-popup").css( "display", "none" );
    });

    //Search
    //$('input#btn-search').click(function() {
    //    var $search = $('#search'),
    //        val =$search.val();
    //    $search.multiAutoComplete('search', val);
    //});
    // Reset Search
    var $search = $('#search'), $btnClose = $('.close-icon');
    $search.on('change keydown keyup paste input',function(e){
        if ($search.val().length > 2) {
            $btnClose.show();
        }else{
            $btnClose.css('display','none');
        }
    });
    $btnClose.click(function() {
        $search.val('');
        $btnClose.css('display','none');
    });
    // Click other than Search Container
    $(document).mouseup(function (e)
    {
        if(searchCheckedValues().length <= 0 || searchEnabled == false){
            var container = $("#search");
            var autocompleteDiv = $(".ui-autocomplete");
            var target = $(e.target);

            if (!container.is(target) && !autocompleteDiv.is(target)
                && container.has(target).length === 0 && autocompleteDiv.has(target).length === 0)  // ... nor a descendant of the container
            {
                $search.val('');
                $btnClose.css('display','none');
            }
        }
    });

    //Disable Back Button
    $(document).on("keydown", function (e) {
        if (e.which === 8 && !$(e.target).is("input, textarea")) {
            e.preventDefault();
        }
    });

    // Set Map Center to WorldWide Including NZ
    setCenterToWorld();
}

function setCenterToWorld(){
    map.setView(L.latLng(16.13026201203477,-42.1875),2);
}

function featureAdd(feature, layer) {

    var marker = layer;

    if (!feature) {
        return;
    }

    var bcolour = 'grey-bg';
    if (feature.properties["status"] == 'Updated') {
        bcolour = "blue-bg";
    }
    if (feature.properties["status"] == 'Maiden') {
        bcolour = "orange-bg";
    }
    if (feature.properties["status"] == 'Upgraded') {
        bcolour = "green-bg";
    }

    var hasOther = false;
    var icons = '';
    var history = '';
    var histories = feature.properties['history'].trim().split(">");
    for (var i = 0; i < histories.length; i++) {
        var h = histories[i];
        var parts = h.trim().split(";");
        if ((parts[0] == "no previous report available") || (parts[0] == undefined) || (parts[0] == "") || (typeof(parts[0]) == undefined)) {
            continue;
        }
        var link = parts[1].trim() + '&nbsp;<a href="' + parts[0].trim() + '" target="_blank"><i class="fa fa-arrow-circle-o-down"></i> Download</a><br/>';
        history += link;
    }

    var types = feature.properties['commodity'].toLowerCase().split("-");
    for (var i = 0; i < types.length; i++) {
        var thisType = types[i];
        switch (thisType) {
            case 'gold':
                icons += '<div class="commodity-icon-and-desc cf">\
      <div class="commodity-icon-gold"></div>\
      <p class="commodity-desc">GOLD</p>\
      </div>';
                break;
            case 'silver':
                icons += '<div class="commodity-icon-and-desc cf">\
      <div class="commodity-icon-silver"></div>\
      <p class="commodity-desc">SILVER</p>\
      </div>';
                break;
                break;
            case 'copper':
                icons += '<div class="commodity-icon-and-desc cf">\
      <div class="commodity-icon-copper"></div>\
      <p class="commodity-desc">COPPER</p>\
      </div>';
                break;
                break;
            case 'lead':
                icons += '<div class="commodity-icon-and-desc cf">\
      <div class="commodity-icon-lead"></div>\
      <p class="commodity-desc">LEAD</p>\
      </div>';
                break;
                break;
            case 'ree':
                icons += '<div class="commodity-icon-and-desc cf">\
      <div class="commodity-icon-ree"></div>\
      <p class="commodity-desc">REE</p>\
      </div>';
                break;
                break;
            case 'zinc':
                icons += '<div class="commodity-icon-and-desc cf">\
      <div class="commodity-icon-zinc"></div>\
      <p class="commodity-desc">zinc</p>\
      </div>';
                break;
                break;
            case 'coal':
                icons += '<div class="commodity-icon-and-desc cf">\
      <div class="commodity-icon-coal"></div>\
      <p class="commodity-desc">Coal</p>\
      </div>';
                break;
            case 'diamonds':
                icons += '<div class="commodity-icon-and-desc cf">\
      <div class="commodity-icon-diamonds"></div>\
      <p class="commodity-desc">Diamonds</p>\
      </div>';
                break;
            case 'iron':
                icons += '<div class="commodity-icon-and-desc cf">\
      <div class="commodity-icon-iron"></div>\
      <p class="commodity-desc">Iron</p>\
      </div>';
                break;
            case 'nickel':
                icons += '<div class="commodity-icon-and-desc cf">\
      <div class="commodity-icon-nickel"></div>\
      <p class="commodity-desc">Nickel</p>\
      </div>';
                break;
            case 'phosphate':
                icons += '<div class="commodity-icon-and-desc cf">\
      <div class="commodity-icon-phosphate"></div>\
      <p class="commodity-desc">Phosphate</p>\
      </div>';
                break;
            case 'tin':
                icons += '<div class="commodity-icon-and-desc cf">\
      <div class="commodity-icon-tin"></div>\
      <p class="commodity-desc">Tin</p>\
      </div>';
                break;
            case 'uranium':
                icons += '<div class="commodity-icon-and-desc cf">\
      <div class="commodity-icon-uranium"></div>\
      <p class="commodity-desc">Uranium</p>\
      </div>';
                break;
                break;
            default:
                {
                    if (!hasOther) {
                        icons += '<div class="commodity-icon-and-desc cf">\
          <div class="commodity-icon-other"></div>\
          <p class="commodity-desc">OTHER</p>\
          </div>';
                    }
                    hasOther = true;
                    break;
                }
                break;
        }
    }

    var review = '';
    if($.cookie('login') == "loggedIn") {
        review += '<a id="' + feature.id + '" onclick="javascript:saveDataInCookie(this);">Review This Report</a>';
    }else{
        $('#reportId').val(feature.id);
        review += '<a href="#login_form" id="'+feature.id+'">Login To Review</a>';
    }


    var totalNumberOfReview = 0;
    if (typeof feature.properties["totalReview"] != 'undefined')
        totalNumberOfReview = feature.properties["totalReview"];

    var rating = '<fieldset class="rating">';

    //if(totalNumberOfReview <= 3){
    //    rating += '<span>Insufficient Reviews</span>';
    //}else{
        rating += '<img src="/wp-content/themes/fount/images/icons/info.png" onclick="javascript:showRatingDetail(this);" />';
        rating += '<input type="radio" id="star5" disabled /><label for="star5" title="Very Good"></label>';
        rating += '<input type="radio" id="star4" disabled /><label for="star4" title="Good"></label>';
        rating += '<input type="radio" id="star3" disabled checked /><label for="star3" title="Average"></label>';
        rating += '<input type="radio" id="star2" disabled /><label for="star2" title="Poor"></label>';
        rating += '<input type="radio" id="star1" disabled /><label for="star1" title="Very Poor"></label>';
    //}
    rating += '</fieldset>';
    rating += '<a id="' + feature.id + '" onclick="javascript:viewReportSummary(this);">' + totalNumberOfReview + ' Reviews</a>';


    var popupContent = '<div class="leaflet-popup-content">\
  <h2 id="yui_3_17_2_2_1431404870956_1958">' + feature.properties["company"] + '</h2>\
        <table id="yui_3_17_2_2_1431404870956_1977">\
            <tbody id="yui_3_17_2_2_1431404870956_1976"><tr>\
                <td><b>Project:</b></td>\
                <td>' + feature.properties["project"] + '</td>\
            </tr>\
            <tr>\
                <td><b>Deposit:</b></td>\
                <td>' + feature.properties["deposit"] + '</td>\
            </tr>\
            <tr id="yui_3_17_2_2_1431404870956_1975">\
                <td><b>Date:</b></td>\
                <td id="yui_3_17_2_2_1431404870956_1974">' + feature.properties["date"] + '</td>\
            </tr>\
            <tr id="yui_3_17_2_2_1431404870956_1991">\
                <td><b>Report Code:</b></td>\
                <td id="yui_3_17_2_2_1431404870956_1990">' + feature.properties["code"] + '</td>\
            </tr>\
            <tr>\
                <td><b>Report Type:</b></td>\
                <td>' + feature.properties["type"] + '</td>\
            </tr>\
            <tr>\
                <td><b>Download</b></td>\
                <td><a href="' + feature.properties["download"] + '" target="_blank"><i class="fa fa-arrow-circle-o-down"></i> Download this Report.</a></td>\
            </tr>\
            <tr>\
                <td><b>Report Details:</b></td>\
                <td>' + feature.properties["detail"] + '</td>\
            </tr>\
            <tr>\
                <td><b>Resources:</b></td>\
                <td>' + feature.properties["status"] + ' - ' + feature.properties["resources"] + '</td>\
            </tr>\
            <tr>\
                <td><b>CP/QP:</b></td>\
                <td>' + feature.properties["cpqp"] + '</td>\
            </tr>\
            <tr>\
                <td>\
                    <b>Commodities</b></td>\
                <td>' + icons + '</td>\
            </tr>\
            <tr id="tr-history">\
                <td><b>History:</b></td>\
                <td>' + history + '</td>\
            </tr>\
            <tr id="tr-rating">\
                <td><b>OVERALL RATING:</b></td>\
                <td>' + rating + '</td>\
            </tr>\
            <tr id="tr-rating-review">\
                <td></td>\
                <td>'+review+'</td>\
            </tr>\
        </tbody></table>\
  </div>';

    marker.setIcon(L.mapbox.marker.icon({
        'marker-color': feature.properties["marker-color"],
        'marker-size': 'large',
        'marker-symbol': feature.properties["marker-symbol"]
    }));

    marker.bindPopup(popupContent, {
        closeButton: true,
        minWidth: 320,
        autoPanPaddingTopLeft: [0,100]
    });
}

function queryAll() {

    Report = Parse.Object.extend("Report");

    query = new Parse.Query(Report);
    query.descending('createdAt');
    query.limit(1000);
    query.find({
        success: function(results) {
            //Success callback

            json = [];
            geoJson = [];
            for (var i = 0; i < results.length; i++) {
                var point = results[i];
                var array = point.get("Commodities").split("-");
                var nice = array.join(", ");
                var symbol = "o";
                if (point.get("Code") == 'NI43-101' || point.get("Code") == 'NI 43-101') {
                    symbol = "n";
                }
                if (point.get("Code") == 'JORC') {
                    symbol = "j";
                }
                if (point.get("Code") == '(Enviro)') {
                    symbol = "e";
                }
                var colour = "#505050";
                if (point.get("Status") == 'Updated') {
                    colour = "#1F51A4";
                }
                if (point.get("Status") == 'Maiden') {
                    colour = "#F76200";
                }
                if (point.get("Status") == 'Upgraded') {
                    colour = "#009273";
                }
                if (point.get("Status") == 'Not Defined') {
                    colour = "#808080";
                }

                var lat = decimalFromSexagesimal(point.get("Latitude"));
                var lng = decimalFromSexagesimal(point.get("Longitude"));

                var properties = [point.get("Company"), point.get("Project"), point.get("Deposit"),point.get("Commodities") , point.get("CPQP")];
                var single = {
                    id: point.id,
                    type: 'Feature',
                    "geometry": { "type": "Point", "coordinates": [lng, lat]},
                    "properties": {
                        /* "marker-symbol": "circle", */
                        "marker-color": colour,
                        "marker-size": "large",
                        "marker-symbol": symbol,
                        "code": point.get("Code"),
                        "state": point.get("State"),
                        "country": point.get("Country"),
                        "project": point.get("Project"),
                        "company": point.get("Company"),
                        "region": point.get("Region"),
                        "type": point.get("Type"),
                        "status": point.get("Status"),
                        "detail": point.get("Detail"),
                        "cpqp": point.get("CPQP"),
                        "deposit": point.get("Deposit"),
                        "download": point.get("Download"),
                        "history": point.get("History"),
                        "resources": point.get("Resources"),
                        "commodity": point.get("Commodities"),
                        "totalReview": point.get("TotalReview"),
                        "commoditiesNice": nice,
                        "locationNice": point.get("Latitude")+" "+point.get("Longitude"),
                        "date": point.get("Date")
                    }
                };

                json.push(properties);
                geoJson.push(single);
            }
            geoJsonLayer = L.geoJson(geoJson, {
                filter: geoJsonFilter,
                onEachFeature: featureAdd
            });
            // //clusterGroup.addLayer(geoJsonLayer);
            featureLayer.addLayer(geoJsonLayer);
            //initialize auto-complete search
            iniSearch();
        },
        error: function(error) {
            //Error Callback
            console.log("total failure");
        }
    });
}

function padLeft(nr, n, str){
    return Array(n-String(nr).length+1).join(str||'0')+nr;
}

function geoJsonFilter(f) {

    var match = false;

    // check for code matches
    if ($("#code-jorc").prop('checked')) {
        if (f.properties['code'] == 'JORC') {
            match = true;
        }
    }
    if ($("#code-ni-43-101").prop('checked')) {
        if ((f.properties['code'] == 'NI43-101') || (f.properties['code'] == 'NI 43-101')) {
            match = true;
        }
    }
    if ($("#code-environmental").prop('checked')) {
        if (f.properties['code'] == '(Enviro)') {
            match = true;
        }
    }
    if ($("#code-other").prop('checked')) {
        if ((f.properties['code'] != 'NI43-101') && (f.properties['code'] != 'NI 43-101') && (f.properties['code'] != 'JORC') && (f.properties['code'] != '(Enviro)') ) {
            match = true;
        }
    }
    // nothing to do if "other"
    if (!match) {
        return false;
    }

    // check for report type matches
    match = false
    if ($("#type-exploration-update").prop('checked')) {
        if (f.properties['type'].toLowerCase().indexOf("exploration") > -1) {
            match = true;
        }
    }
    if ($("#type-resource-estimate").prop('checked')) {
        if (f.properties['type'] == 'Resource Estimation') {
            match = true;
        }
    }
    /*if ($("#type-scoping-study").prop('checked')) {
        if (f.properties['type'] == 'Scoping Study') {
            match = true;
        }
    }
    if ($("#type-pea").prop('checked')) {
        if (f.properties['type'] == 'PEA') {
            match = true;
        }
    }*/
    if ($("#type-Scoping-Study-and-pea").prop('checked')) {
        if (f.properties['type'] == 'Scoping Study' || f.properties['type'] == 'PEA') {
            match = true;
        }
    }
    if ($("#type-supporting-acquisition").prop('checked')) {
        if (f.properties['type'] == 'Supporting Acquisition') {
            match = true;
        }
    }
    if ($("#type-feasibility").prop('checked')) {
        if (f.properties['type'] == 'Feasibility Study') {
            match = true;
        }
    }
    if ($("#type-pre-feasibility").prop('checked')) {
        if (f.properties['type'] == 'Pre-Feasibility Study') {
            match = true;
        }
    }
    if ($("#type-eia-esia").prop('checked')) {
        if (f.properties['type'] == 'EIA/ESIA') {
            match = true;
        }
    }
    if ($("#type-optimisation-study").prop('checked')) {
        if (f.properties['type'] == 'Optimisation Study') {
            match = true;
        }
    }
    if (!match) {
        return false;
    }

    // check for commodity matches
    match = false
    if ($("#commodity-gold").prop('checked')) {
        if (f.properties['commodity'].toLowerCase().indexOf("gold") > -1) {
            match = true;
        }
    }
    if ($("#commodity-silver").prop('checked')) {
        if (f.properties['commodity'].toLowerCase().indexOf("silver") > -1) {
            match = true;
        }
    }
    if ($("#commodity-copper").prop('checked')) {
        if (f.properties['commodity'].toLowerCase().indexOf("copper") > -1) {
            match = true;
        }
    }
    if ($("#commodity-ree").prop('checked')) {
        if (f.properties['commodity'].toLowerCase().indexOf("ree") > -1) {
            match = true;
        }
    }
    if ($("#commodity-lead").prop('checked')) {
        if (f.properties['commodity'].toLowerCase().indexOf("lead") > -1) {
            match = true;
        }
    }
    if ($("#commodity-zinc").prop('checked')) {
        if (f.properties['commodity'].toLowerCase().indexOf("zinc") > -1) {
            match = true;
        }
    }
    if ($("#commodity-coal").prop('checked')) {
        if (f.properties['commodity'].toLowerCase().indexOf("coal") > -1) {
            match = true;
        }
    }
    if ($("#commodity-phosphate").prop('checked')) {
        if (f.properties['commodity'].toLowerCase().indexOf("phosphate") > -1) {
            match = true;
        }
    }
    if ($("#commodity-uranium").prop('checked')) {
        if (f.properties['commodity'].toLowerCase().indexOf("uranium") > -1) {
            match = true;
        }
    }
    if ($("#commodity-iron").prop('checked')) {
        if (f.properties['commodity'].toLowerCase().indexOf("iron") > -1) {
            match = true;
        }
    }
    if ($("#commodity-nickel").prop('checked')) {
        if (f.properties['commodity'].toLowerCase().indexOf("nickel") > -1) {
            match = true;
        }
    }
    if ($("#commodity-tin").prop('checked')) {
        if (f.properties['commodity'].toLowerCase().indexOf("tin") > -1) {
            match = true;
        }
    }
    if ($("#commodity-diamonds").prop('checked')) {
        if (f.properties['commodity'].toLowerCase().indexOf("diamonds") > -1) {
            match = true;
        }
    }
    if ($("#commodity-other").prop('checked')) {
        var types = f.properties['commodity'].toLowerCase().split("-");
        for (var i = 0; i < types.length; i++) {
            var thisType = types[i];
            if (thisType != 'gold' && thisType != 'silver' &&  thisType != 'copper' &&
                thisType != 'ree' && thisType != 'lead' && thisType != 'zinc' && thisType != 'coal' &&
                thisType != 'uranium' && thisType != 'diamonds' && thisType != 'nickel' &&
                thisType != 'tin' && thisType != 'iron' && thisType != 'phosphate') {
                match = true;
            }
        }
    }
    if (!match) {
        return false;
    }

    // check for report status
    match = false
    if ($("#resource-maiden-resources").prop('checked')) {
        if (f.properties['status'] == 'Maiden') {
            match = true;
        }
    }
    if ($("#resource-updated-resources").prop('checked')) {
        if (f.properties['status'] == 'Updated') {
            match = true;
        }
    }
    if ($("#resource-unchanged").prop('checked')) {
        if (f.properties['status'] == 'Unchanged') {
            match = true;
        }
    }
    if ($("#resource-upgraded").prop('checked')) {
        if (f.properties['status'] == 'Upgraded') {
            match = true;
        }
    }
    if ($("#resource-not-defined").prop('checked')) {
        if (f.properties['status'] == 'Not Defined') {
            match = true;
        }
    }
    if (!match) {
        return false;
    }

    // check for region match
    match = false
    if ($("#region-button-world").hasClass('region-button-on')) {
        match = true;
    }
    if ($("#region-button-north-america").hasClass('region-button-on')) {
        if (f.properties['region'] == 'North America') {
            match = true;
        }
    }
    if ($("#region-button-central-america").hasClass('region-button-on')) {
        if (f.properties['region'] == 'Central America') {
            match = true;
        }
    }
    if ($("#region-button-south-america").hasClass('region-button-on')) {
        if (f.properties['region'] == 'South America') {
            match = true;
        }
    }
    if ($("#region-button-europe").hasClass('region-button-on')) {
        if (f.properties['region'] == 'Europe') {
            match = true;
        }
    }
    if ($("#region-button-africa").hasClass('region-button-on')) {
        if (f.properties['region'] == 'Africa') {
            match = true;
        }
    }
    if ($("#region-button-middle-east").hasClass('region-button-on')) {
        if (f.properties['region'] == 'Middle East') {
            match = true;
        }
    }
    if ($("#region-button-asia").hasClass('region-button-on')) {
        if (f.properties['region'] == 'Asia') {
            match = true;
        }
    }
    if ($("#region-button-oceania").hasClass('region-button-on')) {
        if (f.properties['region'] == 'Oceania') {
            match = true;
        }
    }
    /*if ($("#region-button-int-water").hasClass('region-button-on')) {
        if (f.properties['region'] == 'International Waters') {
            match = true;
        }
    }*/
    if ($("#region-button-seabed-resources").hasClass('region-button-on')) {
        if (f.properties['region'] == 'Seabed Resources') {
            match = true;
        }
    }
    if (!match) {
        return false;
    }

    if (!$("#show-all").prop('checked')) {
        // check for date match
        var d = f.properties['date'].split('/');
        var date = new Date(d[2]+'-'+padLeft(d[1],2)+'-'+padLeft(d[0],2));

        if ($("#from-date").datepicker("getDate")) {
            if (date < $("#from-date").datepicker("getDate")) {
                return false;
            }
        }
        if ($("#to-date").datepicker("getDate")) {
            if ($("#to-date").datepicker("getDate") < date) {
                return false;
            }
        }
    }

    return true;
}

function updateFilter() {
    if ($("#show-all").prop('checked')) {
        //clusterGroup.removeLayer(geoJsonLayer);
        featureLayer.removeLayer(geoJsonLayer);
        geoJsonLayer = L.geoJson(geoJson, {
            filter: function(f) {
                return true;
            },
            onEachFeature: featureAdd
        });
        //clusterGroup.addLayer(geoJsonLayer);
        featureLayer.addLayer(geoJsonLayer);
        return;
    }
    else {
        //clusterGroup.removeLayer(geoJsonLayer);
        featureLayer.removeLayer(geoJsonLayer);
        geoJsonLayer = L.geoJson(geoJson, {
            filter: geoJsonFilter,
            onEachFeature: featureAdd
        });
        //clusterGroup.addLayer(geoJsonLayer);
        featureLayer.addLayer(geoJsonLayer);
    }
}

function runFilter() {

    updateFilter();
    return;

}

function selectRegion(sender) {
    var regs = ['world', 'north-america', 'central-america', 'south-america', 'africa', 'middle-east', 'europe', 'asia', 'oceania', 'int-water', 'seabed-resources'];
    for (var i=0; i < regs.length; i++) {
        var reg = regs[i];
        if ('region-button-'+reg != sender.attr('id')) {
            $('#region-button-'+reg).removeClass().addClass('region-button region-button-off');
        }
        else {
            $('#region-button-'+reg).removeClass().addClass('region-button region-button-on');
        }
    }
    if (sender.attr('id') != 'region-button-world') {
        $("#show-all").prop('checked', false);
    }
    if (sender.attr('id') == 'region-button-north-america') {
        map.setView(L.latLng(42.393969,-101.7074804),3);
    }
    if (sender.attr('id') == 'region-button-south-america') {
        map.setView(L.latLng(-14.4939981,-58.6462377),3);
    }
    if (sender.attr('id') == 'region-button-europe') {
        map.setView(L.latLng(51.9987155,22.025397),3);
    }
    if (sender.attr('id') == 'region-button-africa') {
        map.setView(L.latLng(8.2337276,17.5869204),3);
    }
    if (sender.attr('id') == 'region-button-middle-east') {
        map.setView(L.latLng(35.6164376,45.7458522),3);
    }
    if (sender.attr('id') == 'region-button-asia') {
        map.setView(L.latLng(42.4400398,97.2158267),3);
    }
    if (sender.attr('id') == 'region-button-oceania') {
        map.setView(L.latLng(-23.5232451,139.9306705),3);
    }
    if (sender.attr('id') == 'region-button-int-water') {
        map.setView(L.latLng(24.5275859,-178.6728451),3)
    }
    if (sender.attr('id') == 'region-button-seabed-resources') {
        setCenterToWorld();
    }
    if (sender.attr('id') == 'region-button-world') {
        setCenterToWorld();
    }

    runFilter();
}

function iniSearch(){
    var columns = [
            {name: 'Company' , width: '20%'},
            {name: 'Project' , width: '14%'},
            {name: 'Deposit' , width: '14%'},
            {name: 'Commodities' , width: '15%'},
            {name: 'CP / QP Affiliation' , width: '37%'}
        ];
    $("#search").multiAutoComplete({
        showHeader: true,
        columns: columns,
        source: json,
        minLength: 3,
        autoFocus: false,
        select: function(event, ui) {
            // Set the input box's value
            $("#search").val(this.value);
            return true;
        },
        response: function(event, ui) {
            if (!ui.content.length) {
                var noResult = {label:"Error", value:"No match found" };
                ui.content.push(noResult);
                //$("#message").text("No results found");
            } else {
                $("#message").empty();
            }
        }
    });
}

function searchCheckedValues(){
    return $('.chk-auto-complete:checked').map(function() {
        return this.value;
    }).get();
}

function showRatingDetail(e){
    var $div = $("div.rating-popup");
    $div.html('');
    var position = $('#tr-rating img').offset();
    var top =position.top - $(document).scrollTop() - 240;
    var left =position.left + 26;
    $div.css({'top': top, 'left': left, 'display': 'inline'} );

    var popupContent;
    popupContent = $('<p>This report has been reviewed by members of an <a href="#">expert panel</a>. The displayed scores are the average score for each feature based on <a href="#">5 expert reviews</a>.</p>');

    var $table,tr;
    $table = $('<table></table>');
    tr = getRating('TRANSPARENCY:',4);
    $table.append(tr);
    tr = getRating('MATERIALITY:',3);
    $table.append(tr);
    tr = getRating('METHODOLOGY:',5);
    $table.append(tr);
    tr = getRating('COMPETENCE:',2);
    $table.append(tr);
    tr = getRating('CODE-COMPLIANCE:',1);
    $table.append(tr);
    tr = getRating('OVERAL RATING:',4);
    $table.append(tr);

    var callout= $('<img id="close-rating-popup" class="callout" src="/wp-content/themes/fount/intel/images/arrow.png" />');

    var img = $('<input type="button" class="popup-close-icon " value="x">');
    img.click(function(event) {
        $div.hide();
    });
    $div.append(img);
    $div.append(callout);
    $div.append(popupContent);
    $div.append($table);
}

function getRating(name,rating){
    var $tr, $td, review, $tdRating, checked='';
    $tr = $('<tr></tr>');
    $td = $('<td><b>'+name+'</b></td>');

    review = '<fieldset class="rating">';
    checked = (rating == 5) ? 'checked' : '';
    review += '<input type="radio" id="5-'+name+'" disabled '+checked+' /><label for="5-'+name+'" title="Very Good"></label>';
    checked = (rating == 4) ? 'checked' : '';
    review += '<input type="radio" id="4'+name+'" disabled '+checked+' /><label for="4-'+name+'" title="Good"></label>';
    checked = (rating == 3) ? 'checked' : '';
    review += '<input type="radio" id="3'+name+'" disabled '+checked+' /><label for="3-'+name+'" title="Average"></label>';
    checked = (rating == 2) ? 'checked' : '';
    review += '<input type="radio" id="2'+name+'" disabled '+checked+' /><label for="2-'+name+'" title="Poor"></label>';
    checked = (rating == 1) ? 'checked' : '';
    review += '<input type="radio" id="1'+name+'" disabled '+checked+' /><label for="1-'+name+'" title="Very Poor"></label>';
    review += '</fieldset>';

    $tdRating = $('<td>'+review+'</td>');

    $tr.append($td).append($tdRating);

    return $tr;


}

function saveDataInCookie(elm){
    var feature = $.grep(geoJson, function(e){ return e.id == elm.id; });
    feature =feature[0];

    resetCookie();
    setCookie(feature);
    var url = 'http://rscmme.com/review-form';
    window.open(url, '_blank');
}

function viewReportSummary(elm){
    var feature = $.grep(geoJson, function(e){ return e.id == elm.id; });
    feature =feature[0];

    resetCookie();
    setCookie(feature);
    var url = 'http://www.rscmme.com/review-summary';
    window.open(url, '_blank');
}
function validate(){
    var username = $('#username').val();
    var password = $('#password').val();
    var $error = $('.login-error');

    if ((username == null || username == "") && (password == null || password == "")) {
        $error.html("Username & Password must be filled out.").show();
        return false;
    }else if (username == null || username == "") {
        $error.html("Username must be filled out.").show();
        return false;
    }else if(password == null || password == ""){
        $error.html("Password must be filled out.").show();
        return false;
    }

    return true;
}

function login(){
    var $error = $('.login-error');
    var $success = $('.login-success');
    var reportId = $('#reportId');

    if(validate()){
        $error.hide();
        $success.hide();

        var username = $('#username').val();
        var password = $('#password').val();
        $.ajax({
            url: 'http://dev.businessclout.com/rsc-mapbox/parse/lib.php?action=login',
            dataType: 'jsonp',
            data: {
                'username': username,
                'password': password
            },
            success: function(data){
                //$.removeCookie('login', { path: '/' });
                $success.show();

                // Dev
                var date = new Date();
                var minutes = 30;
                date.setTime(date.getTime() + (minutes * 60 * 1000));
                $.cookie('login', 'loggedIn', { expires: date, path: '/' });
                // end Dev

                //$.cookie('login', true, { expires: 1, path: '/' });
                $.cookie('userId', data.userId, { expires: 1, path: '/' });
                $.cookie('username', data.username, { expires: 1, path: '/' });
                $.cookie('profileImg', data.url, { expires: 1, path: '/' });

                // Refresh Page
                document.location.href = String( document.location.href ).replace( "#login_form", "" );

            },
            error: function(e){
                $error.html("Username or Password Incorrect.").show();
            }
        });
    }

}

function setCookie(feature){
    $.cookie('reportId', feature.id, { expires: 1, path: '/' });
    $.cookie('company', feature.properties["company"], { expires: 1, path: '/' });
    $.cookie('project', feature.properties["project"], { expires: 1, path: '/' });
    $.cookie('code', feature.properties["code"], { expires: 1, path: '/' });
    $.cookie('type', feature.properties["type"], { expires: 1, path: '/' });
    $.cookie('cpqp', feature.properties["cpqp"], { expires: 1, path: '/' });
    $.cookie('date', feature.properties["date"], { expires: 1, path: '/' });
}
function resetCookie(){
    $.removeCookie('reportId', { path: '/' });
    $.removeCookie('company', { path: '/' });
    $.removeCookie('project', { path: '/' });
    $.removeCookie('code', { path: '/' });
    $.removeCookie('type', { path: '/' });
    $.removeCookie('cpqp', { path: '/' });
    $.removeCookie('date', { path: '/' });
}
