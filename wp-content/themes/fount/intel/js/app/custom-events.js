/**
 * Created by Shahzaib on 26/02/2019.
 */

var CustomVariables = {

    isCommoditySelected: true,
};

$(document).ready(function () {
    $("#reportbox_popup").remove();
    // $('#search-container').css('width', $(window).width() - 375);
});

$(window).load(function () {

    setmapZoom();
    var options = {
        'closeOnAnyClick': false
    };

    var pdf_url = localStorage.getItem("pdf_Url");
    var pdf_temporary_url = localStorage.getItem("pdf_temporary_Url");

    if (
        $.cookie("splash") != 'false' && !jQuery('body').hasClass('logged-in')
        && !pdf_url && !pdf_temporary_url && $.cookie("disclamier") != 'read'
        && localStorage.getItem("disclamier") != 'read'
    ) {
        $('[data-remodal-id=modal]').remodal(options).open();
    }
    var rsc_advises = $.cookie("rsc_advises");
    if ($.cookie('login') == "loggedIn" && rsc_advises == 'unread') {
        $('[data-remodal-id=registered-reviewers]').remodal(options).open();
    }

});

$(window).resize(function () {

    if (!oRsc.isMobileDevice) {
        $('#map').css('min-height', $(window).height() - $('#prk_responsive_menu').height());
        $('#map').css('width', $(window).width() - 350);
    }

    if ($('#report-pdf-modal').is(':visible') && ($('.region-button-on').text().indexOf('Transaction') == -1)) {
        var width = $(window).width();
        if (width < 768) {
            var height = window.innerHeight - 50;
            var heightIframe = height - 10;
            $('#prk_menu_els,.map-header-mobile.show-below-768px').hide();
            $('#bottom-share-links').removeClass('right-share-links');
            if ($('a.next-report').is(':visible') || $('a.prev-report').is(':visible')) {
                $('a.next-report.desktop-version, a.previous-report.desktop-version').hide();
                oPdf.showrelatedButtons('next-report', 'inline-block');
                oPdf.showrelatedButtons('previous-report', 'inline-block');
            }
        } else {
            $('#prk_menu_els').show();
            if ($('a.next-report').is(':visible') || $('a.prev-report').is(':visible')) {
                $('a.next-report.mobile-version, a.previous-report.mobile-version').hide();
                oPdf.showrelatedButtons('next-report', 'inline-block');
                oPdf.showrelatedButtons('previous-report', 'inline-block');
            }
            if ($('.right-share-links').is(':visible')) {
                var height = window.innerHeight - 148;
                var heightIframe = height - 50;
            } else {
                var height = window.innerHeight - 110;
                var heightIframe = height - 80;
            }
            if ($('.tec-trans-pdf').is(':visible'))
                $('#bottom-share-links').addClass('right-share-links');
        }
        $('#report-pdf-modal .modal-body').css({height: height + "px"});
        $('#pdfViewerIframe').css('height', heightIframe);
    }
    // $('#search-container').css('width', $(window).width() - 395);
    setmapZoom();
});

$(document).on("click", ".search-dropdown-content span", function () {

    var search = $('#search');
    switch ($(this).text()) {
        case 'Company':
            oRsc.searchKey = 'company';
            search.css('padding-left','85px');
            break;
        case 'Ticker':
            oRsc.searchKey = 'ticker';
            search.css('padding-left','60px');
            break;
        case 'Project':
            oRsc.searchKey = 'project';
            search.css('padding-left','68px');
            break;
        case 'Consultant':
            oRsc.searchKey = 'consultant';
            search.css('padding-left','94px');
            break;
        case 'Commodity':
            if (oRsc.userPlan == 'Plan2' || oRsc.userPlan == 'Plan3') {
                oRsc.addKeyUpKeydownOnSearch($('#search-commodity-dropdown span'));
                CustomVariables.isCommoditySelected = false;
                oRsc.searchKey = 'commodities';
                search.css('padding-left','99px');
            } else {
                // $('#commodity_checkboxes_popup span').text('This feature is available for registered users only. Please login or register for an account.');
                // $('#commodity_checkboxes_popup').modal('show');
                // return;
                oRsc.searchKey = 'commodities';
                search.css('padding-left','99px');
            }
            break;
        default :
            break;
    }

    oRsc.initSearch();
    $('.search-category').text($(this).text() + ': ');

    $("#search").focus();
    //$('#search').val(': ');
    $('.search-dropdown-content, .search-dropdown-content div').css('display', 'none');

    var region = $('.region-button-on').text();
    if (region != 'Technical Reports') {
        $('.toggle-layer-pdfdownloads').show();
    }

});

$(document).on("click", ".search-commodity-dropdown-content span", function () {

    CustomVariables.isCommoditySelected = true;

    // var val = $('#search').val();
    // val = val.split(':');

    $('#search').val($(this).text());
    $('#search').trigger('keydown');

    $('.search-commodity-dropdown-content, .search-commodity-dropdown-content div').slideUp('slow');
});


$(document).on("click", function (event) {

    var $trigger = $(".search-dropdown");

    if ($trigger !== event.target && !$trigger.has(event.target).length) {
        $("#search-dropdown").slideUp("fast");
        var region = $('.region-button-on').text();
        if (region != 'Technical Reports') {
            $('.toggle-layer-pdfdownloads').show();
        }
    }

});

oRsc.onlogOut = function () {
    $('.modal').modal('hide');
};

oRsc.searchonfocus = function () {

    //Hide Commodity in search bar if user not logged in
    if (oRsc.userPlan == 'Plan2' || oRsc.userPlan == 'Plan3') {
        if($('#commodity_span').length == 0){
            $('#search-dropdown').append("<span id='commodity_span'>Commodity</span>");
        }
    }

    if (!$('.search-category').is(':visible')) {

        // $('#search-dropdown span').removeClass('selected');
        // $('#search-dropdown span:nth-child(1)').addClass('selected');

        //$('#search').val(': ');
        $('.search-dropdown-content span').css('display', 'block');
        $("#search-dropdown").slideDown("fast");

        $('.toggle-layer-pdfdownloads').hide();
        oRsc.searchKey = 'company';
        oRsc.addKeyUpKeydownOnSearch($('#search-dropdown span'));
        $('#search').css('padding-left','85px');
        $('.search-category').text('Company: ');
        $('.search-category').show();
    } else if ($('#search').val().length > 2 && oRsc.search_drop_open == true && oRsc.searchKey != "commodities"){
        $('.ui-autocomplete').css('display', 'block');
    }

};

oRsc.setActiveCommodity =function(commodity) {

    var isCommodityFound = false;

    var commodityFilter = $('#commodity-group');

    // commodityFilter.find('label').css('background','#FC2020');
    commodityFilter.find('label').css('background','#DE7070');

    commodityFilter.find('.content').show();
    commodityFilter.find('span.expander').toggleClass('collapsed').toggleClass('expanded');

    $('.uncheck-all-commodities').each(function(){
        if($(this).val() == commodity) {
            isCommodityFound = true;
           // $(this).trigger('click');
             var id = $(this).attr('id');
            $('span#'+id).trigger('click');
            //$('span#'+id).addClass('filter-background');
            // $('#clear-commodities').css('display','inline');
        }
    });

    if(isCommodityFound == true) {
        //$('.search-category').hide();
        $('#search').val('');
    }

};

oRsc.ChangeSearchPlaceholder = function (param,isCommodityDropdown) {

    var search = $('#search');
    switch (param.text()) {
        case 'Company':
            oRsc.searchKey = 'company';
            search.css('padding-left','85px');
            CustomVariables.isCommoditySelected = true;
            break;
        case 'Ticker':
            oRsc.searchKey = 'ticker';
            search.css('padding-left','60px');
            CustomVariables.isCommoditySelected = true;
            break;
        case 'Project':
            oRsc.searchKey = 'project';
            search.css('padding-left','68px');
            CustomVariables.isCommoditySelected = true;
            break;
        case 'Consultant':
            oRsc.searchKey = 'consultant';
            search.css('padding-left','94px');
            CustomVariables.isCommoditySelected = true;
            break;
        case 'Commodity':
            if (oRsc.userPlan == 'Plan2' || oRsc.userPlan == 'Plan3') {
                oRsc.addKeyUpKeydownOnSearch($('#search-commodity-dropdown span'));
                CustomVariables.isCommoditySelected = false;
                oRsc.searchKey = 'commodities';
                search.css('padding-left','99px');
            } else {
                oRsc.searchKey = 'commodities';
                search.css('padding-left','99px');
            }
            break;
        default :
            return;
            break;
    }
    oRsc.initSearch();
    $("#search").focus();
    $('.search-category').text(param.text() + ': ');
    //$('#search').val(': ');
};

oRsc.addKeyUpKeydownOnSearch = function(span) {

    var $li = span,
        getIndex  = function ( context, selector ) {

            for ( var i = 0, len = context.length; i < len; i++ ) {
                if ( $(context[i]).filter(selector).length ) {
                    return i;
                }
            }
        };

    span.parent().find('span').removeClass('selected');
    span.first().addClass('selected');
    $li.bind('click', function () {

        var $this = $(this);

        $li.removeClass('selected');

        $this.toggleClass('selected');

    });


    $li.unbind('mouseover').bind('mouseover', function () {

        var $this = $(this);
        $li.removeClass('selected');
        $this.toggleClass('selected');
        oRsc.ChangeSearchPlaceholder($this);
    });

    $(document).unbind("keydown").bind('keydown', function (e) {
   if(oRsc.isSearchMarkersActivated == false) {
       var next, current;

       if (e.keyCode == 13) {
           span.parent().find('span.selected').trigger('click');
           span.parent().find('span.selected').removeClass('selected');
       }


       if (($('.ui-autocomplete').css('display') == 'none')) {
           if ([40, 38].indexOf(e.which) > -1 &&
               $li.filter('.selected').length) {

               current = getIndex($li, '.selected');

               if (e.which === 38) {

                   next = (((current - 1) < 0) &&
                       $li.length - 1) || current - 1;

               }

               if (e.which === 40) {

                   next = ((current === $li.length) &&
                       current - $li.length) || current + 1;

                   if (next === $li.length) {
                       next = 0;
                   }
               }
               $($li[next]).trigger('mouseover');
           }
       }
   }
    });
};

oRsc.setCookieSession = function() {
    localStorage.setItem("disclamier","read");
    $.cookie("disclamier", "read");
};
