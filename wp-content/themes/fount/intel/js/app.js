/**
 * Created by ARslan on 7/27/2015.
 */

var BASE_URL = location.protocol + "//" + location.host;
var SCRIPT_PATH = location.protocol + '/wp-content/themes/fount/intel/lib/all.php';

var oRsc = {
    CurrentUser : {},
    default_mode: true,
    isPreferencesActive:false,
    searchKey: '',
    searchLookup:[],
    searchWorldjson :[],
    isDatePeriod: false,
    isSearchMarkersActivated:false,
    selectedFilters: '',
    tech_filters: '',
    search_prj_length: 0,
    geojsonLength: '',
    search_first_column: false,
    curr_feature: '',
    isDatefromPref: false,
    searchData: '',
    search_results: '',
    previous_reports: '',
    filteres_reports: '',
    trans_filters: '',
    that: '',
    userPlan: '',
    date_filter: true,
    scroll_br: true,
    scroll_pos: 0,
    searchDropdown: false,
    searchDropdownonShowMap: false,
    search_drop_open: false,
    reportIds: [],
    viewAll: false,
    markerClass: '',
    sel_filter: 0,
    last_visit: '',
    currentReport: '',
    reportbox: 0,
    trans_call: false,
    len: 0,
    dailyDownloads: 0,
    weeklyDownloads: 0,
    def: 0,
    min_x: 0,
    max_x: 9,
    comp_text: '',
    clearFilters: false,
    def2: 0,
    date_filter2: true,
    isMobileDevice: false,
    isSearchOnly: false,
    isTrans: false,
    map: null,
    mapforzoom: null,
    weeks: [],
    geoJsonSearch: [],
    downloadedReports: [],
    geoSearchJson: [],
    _selectedMarkersJson: [],
    _selectedMarkers: [],
    terrainLayer: null,
    geoJsonLayer: null,
    geoJsonLayer2: null,
    featureLayer: null,
    searchEnabled: false,
    filterRating: false,
    isTransaction: false,
    Code_NI43_101: 0,
    Code_OTHER: 0,
    Code_JORC: 0,
    Code_ENV: 0,
    Type_eia: 0,
    Type_explore: 0,
    Type_resource: 0,
    Type_optimisation: 0,
    Type_pea: 0,
    Type_supporting: 0,
    Type_pre: 0,
    Type_feasibility: 0,
    selectedReport: {},
    _worldJsonInitial: {},
    _worldJson: {},
    _lookup: {},
    c_reporting: true,
    _transactionJson: {},
    monthNames: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    init: function () {
        this.isMobileDevice = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        this.buildMap();
        this.initialiseEverything();
        oRsc.that = this;
        if (this.isMobileDevice) {
            $('#nav-filter').val('Mobile');
            var lastMonth = new Date();
            lastMonth.setMonth(lastMonth.getMonth() - 1);
            $("#from-date").val(oRsc.getFormattedDate(lastMonth, 'M d, yy'));
            $("#to-date").val(oRsc.getFormattedDate(new Date(), 'M d, yy'));
        }
        if (jQuery('body').hasClass('logged-in')) {
            $('#menu_section.unpad_right .sf-menu>li:last-child').empty();
            $('.circle-text-numbers').hide();
            $('.map-topbar-container').css('z-index', '1');
            $('#menu_section.unpad_right .sf-menu>li:nth-child(4)>a span').css("display", "none");
            $('#register-btn').css('display', 'none');
        } else {
            // $('#menu_section.unpad_right .sf-menu>li:last-child').empty();
            sessionStorage.setItem("selectedMode", "false");
            $('#clear-commodities').removeClass('reset-filter-link').addClass('gold-only');
            $('#clear-commodities').text('gold only').css('display', 'inline');
            $('span#commodity-g').addClass('filter-background');
            $('#last-visit').css('display', 'none');
            $('#commodity-tip').text('*Tip: become a member to unlock all other commodities.');
            $(".uncheck-all-commodities").each(function () {
                if ($(this).val() == 'Gold') {
                } else {
                    $(this).prop('checked', false);
                    $(this).on("click", false);
                }
            });
            //jQuery('ul.sf-menu.sf-vertical.mini-site-header.sf-js-enabled li:nth-child(6)').css("display", "block");
            $('#menu_section.unpad_right .sf-menu>li:nth-child(4)>a').css("display", "block");
            $('#menu_section.unpad_right .sf-menu>li:nth-child(4)>a').attr({
                href: "#",
                'data-toggle': "modal",
                'data-target': '.login-register-form',
                class: 'close-tooltips header-login-link'
            });
            // $("#menu_section.unpad_right .sf-menu>li:last-child>a").attr("data-toggle", "modal");
            // $('#menu_section.unpad_right .sf-menu>li:last-child>a').attr('data-target', '.login-register-form');
            $("#userLogout").html("LOGIN");
            $("#userLogout").attr("href", "/login");
            $("#user_login").html("");
            oRsc.comp_text = 'I would like to anonymously report a compliance or data error issue with this report.';
            $('#menu_section.unpad_right .sf-menu>li:nth-child(4)').before('<button onclick="oRsc.register();" id="register-btn" class="btn btn-primary close-tooltips" id="submit">Sign Up</button>');
        }
        if (jQuery('body').hasClass('logged-in') && ($.cookie('isTrans') == 'true')) {
            $.cookie("trans-status", "true");
        } else {
            $.cookie("trans-status", "false");
            $.cookie("isTrans", "false");
        }

        //call to fetch user information and display in user profile dropdown
        oRsc.userMembershipLevels();
        // this.queryAll();


    },

    // Todo: Remove unnecessary code
    initialiseEverything: function () {
        if (!oRsc.isMobileDevice) {
            $('#map').css('min-height', $(window).height() - $('#prk_responsive_menu').height());
            $('#map').css('width', $(window).width() - 350);
        }
        var that = this, $layerToggle = $("#layer-toggle");
        oRsc.mapforzoom = this.map;
        this.map.on('popupopen', function (e) {
            if (oRsc.that.isMobileDevice) {
                //map.setView(marker.latLng);
                var px = that.map.project(e.popup._latlng);
                px.y -= e.popup._container.clientHeight / 2;
                px.y -= 50;
                // if ($('#map-sidebar-container').is(":visible")) {
                //     px.x -= $('#map-sidebar-container').width() / 2;
                // }
                that.map.panTo(that.map.unproject(px), {animate: true});
                //oRsc.setCenterToWorld();
            }
        });
        $("#Sidebar-reports").before("<span style='color:#6A262C;margin-left: 256px'>New!</span>");
        $("#from-date").datepicker({dateFormat: 'M d, yy'});
        $("#to-date").datepicker({dateFormat: 'M d, yy'});
        $layerToggle.html('Satellite map');
        $layerToggle.addClass('active');
        $(".leaflet-container").css("background", "#cad2d3");
        // Check if all code active
        this.toggleNavBar('uncheck-all-codes');
        this.toggleSubNavBar('uncheck-all-codes');
        // Check if all type active
        this.toggleNavBar('uncheck-all-types');
        this.toggleSubNavBar('uncheck-all-types');
        // Check if all report project status active
        this.toggleNavBar('uncheck-all-pstatus');
        this.toggleSubNavBar('uncheck-all-pstatus');
        // Check if all Value Range active
        this.toggleNavBar('uncheck-all-range');
        this.toggleSubNavBar('uncheck-all-range');
        // Check if all Location Accuracy is active
        this.toggleNavBar('uncheck-all-accuracy');
        this.toggleSubNavBar('uncheck-all-accuracy');
        // Check if all report format status active
        this.toggleNavBar('uncheck-all-format');
        this.toggleSubNavBar('uncheck-all-format');
        // Check if all resources active
        this.toggleNavBar('uncheck-all-resources');
        this.toggleSubNavBar('uncheck-all-resources');
        // Check if all commodities active
        this.toggleNavBar('uncheck-all-commodities');
        this.toggleSubNavBar('uncheck-all-commodities');
        //check if all project-stages active
        this.toggleNavBar('uncheck-all-stages');
        this.toggleSubNavBar('uncheck-all-stages');
        //check if the transaction type active
        this.toggleNavBar('uncheck-all-transactions');
        this.toggleSubNavBar('uncheck-all-transactions');
        // check if the reserves filter
        this.toggleNavBar('uncheck-all-reserves');
        this.toggleSubNavBar('uncheck-all-reserves');
        // check if the Stock exchange
        this.toggleNavBar('uncheck-all-stockExchange');
        this.toggleSubNavBar('uncheck-all-stockExchange');

        //.............................Sidebar filters functionalities
        $(document).ready(function () {
            // $('#selectMe').on('change', function() {
            //     alert( this.value );
            // });
            /*$('#search').mouseover(function(){
            //gets the current placeholder
            this.holder=$(this).attr('placeholder');
            $(this).attr('placeholder', value);
            });
            $('#search').mouseout(function(){
            $(this).attr('placeholder', this.holder); //sets it back to the initial value
            });
            /*oRsc.SearchFunction=function() {
                $('i').toggleClass('fa-caret-down fa-caret-left');
                var x = document.getElementById("checkbox-div-search-bar");
                var y = document.getElementById("search");
                var z = document.getElementById("advan-search");
                if (x.style.display === "none") {
                    x.style.display = "block";
                }
                else {
                    x.style.display = "none";
                }
                if (z.style.display === "block") {
                    z.style.display = "none";
                }
                 else {
                    z.style.display = "block";
                }
                if (y.style.height==="65px") {
                    y.style.height = "32px";
                }
                else {
                   y.style.height = "65px";
                }
            }
            $('#search-side-bar-down-carrot').click(function () {
                $(".side-bar-filters").toggleClass("side-bar-filters-toogle")
            });*/


            document.getElementById("ihc_login_form").onkeypress = function (e) {
                var key = e.charCode || e.keyCode || 0;
                if (key == 13) {
                    $('.login-form-submit').trigger('click');
                    e.preventDefault();
                }
            };

            $('.close-tooltips').click(function () {
                $('.circle-text-numbers').hide();
                $('.CoachingTooltip-signup').css('display', 'none');
                $('.page-id-2237 .Tooltip-trans-header').css('bottom', '0');
                $('.map-topbar-container').css('z-index', '1');
            });

            $('.Tooltip-trans-header .CoachingTooltip-dismissLink').click(function () {
                $('.Tooltip-trans-header').css('display', 'none');
            });

            //.................................change icon of sidebar label filters
            $('p.expander').click(function () {
                $(this).toggleClass('collapsed').toggleClass('expanded');
                $(this).parent().find('span.expander').toggleClass('collapsed').toggleClass('expanded');
            });

            $('.sidebar-group label').click(function () {
                $(this).find('p').toggleClass('collapsed').toggleClass('expanded');
                $(this).find('span.expander').toggleClass('collapsed').toggleClass('expanded');
            });

            //...................................................................if user is redirected on intel mapbox
            var isuserRedirected = sessionStorage.getItem("redirect-to-intel");
            if (isuserRedirected == 'true') {
                $('.circle-text-numbers').hide();
                $('.CoachingTooltip').css('display', 'none');
                $('.map-topbar-container').css('z-index', '1');
                sessionStorage.setItem("redirect-to-intel", "false");
            }


            //.........................................on reset filter click
            $('.reset-filter-link').click(function () {
                if ($.trim($(this).text()) != 'Reset filter') {
                    return false;
                }

                //clearsearch();

                $(this).css('display', 'none');
                if ($('.reset-filter-link:visible').length == 0) {
                    $('#clear_filters, #save-preferences-link').css('display', 'none');
                }

                var element = $(this).attr('class');
                var id = element.split(" ");
                var str2 = id[1];
                $('#' + str2 + ' label p').css('text-decoration', 'none');
                $('#' + str2 + ' label').css('background', '#7B868C');
                $('#' + str2 + ' span').removeClass('filter-background');
                $('#' + str2 + ' input[type=checkbox]').each(function () {
                    $(this).prop('checked', false);
                });
                that.runFilter();
                return false;
            });

            function clearsearch() {
                this._worldJson = this._worldJsonInitial;
                this.isSearchOnly = false;
                var $search = $('#search'), $btnClose = $('.close-icon');
                $search.val('');
                $btnClose.css('display', 'none');
                $('.rsc-search-loading').hide();
                $('#btn-clear-search').remove();
                // Remove Existing Feature
                oRsc.c_reporting = true;
                oRsc.featureLayer.removeLayer(oRsc.geoJsonSearch);
                oRsc.featureLayer.removeLayer(oRsc._selectedMarkersJson);
                oRsc.featureLayer.removeLayer(oRsc._selectedMarkers);
                // Display Search Only
                $('#search-results-only').css('display', 'none');
            }

            //...................................on every individual filter click
            $('.new_filters').click(function () {
                if (!jQuery('body').hasClass('logged-in') || oRsc.userPlan == 'Plan1') {
                    $('span#commodity-g').addClass('filter-background');
                    var filters = $(this).attr('class');
                    var filter = filters.split(" ");
                    var getclass = filter[1];
                    if (getclass == 'commodity-filters') {
                        if ($(this).text() != 'Gold') {
                            if (oRsc.userPlan == 'Plan1') {
                                $('.commodity-checkboxes-register').css('display', 'none');
                                $('#commodity_checkboxes_popup span').text('Your current plan is restricted to gold reports. Go to Manage profile to upgrade your plan and unlock all commodities.');
                            } else {
                                $('.commodity-checkboxes-register').css('display', 'inline');
                                $('#commodity_checkboxes_popup span').text('For registered users only.');
                            }
                            $('#commodity_checkboxes_popup').modal('show');
                        }
                        return false;
                    }
                }

                var a = $(this).attr('id');
                setTimeout(function () {
                    var activeFilters = $('.filter-background');
                    var span = $('#' + a).parent().attr('class');
                    var id = span.split(" ");
                    var str2 = id[1];
                    if ($('.' + str2).find('.filter-background').length > 0) {
                        $('a.' + str2).css('display', 'inline');
                        // $('p.' + str2).css('text-decoration', 'underline');
                    } else {
                        $('p.' + str2).css('text-decoration', 'unset');
                        $('a.' + str2).css('display', 'none');
                    }
                    if (activeFilters.length == 0) {
                        $('.sidebar-group label span').css('text-decoration', 'unset');
                        $('.reset-filter-link').css('display', 'none');
                        $('#clear_filters, #save-preferences-link').css('display', 'none');
                    } else {
                        $('#clear_filters').css('display', 'block');
                        if (jQuery('body').hasClass('logged-in'))
                            $('#save-preferences-link').css('display', 'inline');
                    }
                }, 1000);

                if (!jQuery('body').hasClass('logged-in')) {
                    if (a.indexOf('commodity') == 0) {
                        if (a != 'commodity-g')
                            return false;
                    }
                }

                $('#show-all').prop('checked', false);
                if (oRsc.clearFilters == true) {
                   // if(oRsc.isSearchActivated == false) {
                        $(".uncheck-all").each(function () {
                            $(this).prop('checked', false);
                        });
                    //}
                    oRsc.clearFilters = false;
                }

                var id = $(this).attr('id');
                $(this).toggleClass('filter-background');
                var filter = $('#' + id + '').prop('checked');
                if (filter == true) {
                    $('#' + id + '').prop('checked', false);
                } else {
                    $('#' + id + '').prop('checked', true);
                }
                var head = $('#' + id).parent().attr('class');
                head = head.split(" ");
                //.................................................................set background of active filers to red else grey
                if ($("#" + head[1] + " span.filter-background").length > 0) {
                    // $('#' + head[1]).find('label').css('background', '#FC2020');
                    $('#' + head[1]).find('label').css('background', '#DE7070');
                } else {
                    $('#' + head[1]).find('label').css('background', '#7B868C');
                }
                if (head[1] == 'commodity-reset-filter') {
                    if ($("." + head[1] + " span.filter-background").length > 0) {
                        // $('#commodity-group').find('label').css('background', '#FC2020');
                        $('#commodity-group').find('label').css('background', '#DE7070');
                    } else {
                        $('#commodity-group').find('label').css('background', '#7B868C');
                    }
                }

                if (head[1].indexOf("commodity-reset-filter") >= 0)
                    head = "Commodity";
                else
                    head = $('#' + head[1]).find('label p').text();
                head = head.replace(/:/g, '');
                var sone = [];
                sone['action'] = head;
                sone['action_log'] = 'filter:' + $(this).text();
                sone['mode'] = $('.region-button-on').text();
                oRsc.activity_log(sone);
                that.runFilter();
            });

            //....................................on click of reset all filter
            $('#clear_filters').click(function () {
                if (oRsc.userPlan != 'Plan2' && oRsc.userPlan != 'Plan3') {
                    $('.side-bar-filters label:not(#date_filter label):not(#commodity-group label)').css('background', '#7B868C');
                } else {
                    $('.side-bar-filters label').css('background', '#7B868C');
                    //$('.date-filter-background').addClass('date-filters').removeClass('date-filter-background');
                    //$('p.date_filter').css('text-decoration', 'unset');
                    //$('#from-date').val('');
                    //$('#to-date').val('');
                    $('#clear-date').css('display', 'inline');
                    //$('#show-all').prop('checked', true);
                }
                $('#date_filter label').css('background', '#DE7070');
                $('a.date_filter').text('Last 365 days');
                $('.date-filter-background').addClass('date-filters').removeClass('date-filter-background');
                $('#show-allll').removeClass('date-filters').addClass('date-filter-background');
                var oneWeekAgo1 = new Date();
                oneWeekAgo1.setDate(oneWeekAgo1.getDate() + 1);
                var day2 = ("0" + oneWeekAgo1.getDate()).slice(-2);
                var month2 = ("0" + (oneWeekAgo1.getMonth() + 1)).slice(-2);
                var today2 = oneWeekAgo1.getFullYear() - 1 + "-" + (month2) + "-" + (day2);
                var today3 = oRsc.getFormattedDate(today2, 'M d, yy');
                $('#from-date').datepicker('setDate', today3);
                $('#to-date').datepicker('setDate', new Date());
                $('#show-all').prop('checked', false);
                $('#show-all-time').prop('checked', false);
                $(this).css('display', 'none');
                $('#save-preferences-link').css('display', 'none');
                $(".uncheck-all").each(function () {
                    $(this).prop('checked', false);
                });
                $('.reset-filter-link').css('display', 'none');
                $('.sidebar-group label p').css('text-decoration', 'unset');
                $('.sidebar-group div.content').hide();
                $('.sidebar-group label span.expander').removeClass('expanded').addClass('collapsed');
                $('.sidebar-group label p.expander').removeClass('expanded').addClass('collapsed');
                $('.filter-background').removeClass('filter-background');
                oRsc.searchLookup = [];
                oRsc.searchWorldjson = [];
                oRsc._exitSearch();
            });

            //.................................on click of reset date filter or all filter in Date range
            $('#all-reports').click(function () {

                if (oRsc.userPlan != 'Plan1' && oRsc.userPlan != 'Plan2' && oRsc.userPlan != 'Plan3'){

                    $('#commodity_checkboxes_popup span').text('For registered users only.');
                    $('#commodity_checkboxes_popup').modal('show');
                    return

                } else {

                    $('a.date_filter').text('all');
                    $('#date_filter label').css('background', '#7B868C');
                    oRsc.clearDate();

                }

            });

            oRsc.clearDate = function () {
               // clearsearch();
                $('.date-filter-background').addClass('date-filters').removeClass('date-filter-background');
                $('#all-reports').removeClass('date-filters').addClass('date-filter-background');
                $('p.date_filter').css('text-decoration', 'unset');
                if ($('.reset-filter-link:visible').length == 0) {
                    $('#clear_filters, #save-preferences-link').css('display', 'none');
                }
                oRsc.sel_filter = 1;
                if ($(this).prop('checked') == true) {
                    $("input[type=text]").val('');
                } else {
                    $('#from-date').val('');
                    $('#to-date').val('');
                    $('#show-all').prop('checked', false);
                }
                $('#clear-date').css('display', 'none');
                that.runFilter();

            };

            //.........................................on click of reset all commodities filter
            $('#clear-commodities').click(function () {

                if ($(this).text() == 'gold only') {
                    return false;
                }

                //clearsearch();

                $('#commodity-group span.filter-background').click();
                $('label[for="commodity"]').click();

                $('.uncheck-all-commodities').each(function () {
                    $(this).prop('checked', false);
                });

                that.runFilter();
                return false;
            });
        });

        // $("input[type=checkbox]").change(function () {
        //     if ($(this).val() == 'otherStockExchange') {
        //         if ($(this).is(":checked")) {
        //             $('.uncheck-all-stockExchange').each(function () {
        //                 $(this).prop('checked', true);
        //             });
        //         }
        //         $('#stock-exchange-Private').prop('checked', false);
        //     }
        //     if ($(this).hasClass('not-left-nav') || $(this).hasClass('subGroup'))
        //         return;
        //     if ($(this).attr('id') != 'show-all') {
        //         $('#show-all').prop('checked', false);
        //     }
        //     else {
        //         if ($('#show-all').prop('checked') == true) {
        //             $(".uncheck-all").each(function () {
        //                 $(this).prop('checked', true);
        //             });
        //             $(".rsc-select-all").each(function () {
        //                 $(this).prop('checked', true);
        //             });
        //             var region = $('.region-button-on').text();
        //             if (" Transaction Reports -BETA " == region) {
        //                 $("input.rsc-text").val('');
        //                 $('#region-button-world').removeClass().addClass('region-button region-button-off');
        //             }
        //             else {
        //                 $("input.rsc-text").val('');
        //                 $('#region-button-world').removeClass().addClass('region-button region-button-on');
        //                 $('#region-button-new-resource').removeClass().addClass('region-button region-button-off');
        //                 $('#region-button-reserve').removeClass().addClass('region-button region-button-off');
        //                 $('#region-button-exploration').removeClass().addClass('region-button region-button-off');
        //                 $('#region-button-seabed-resources').removeClass().addClass('region-button region-button-off');
        //                 $('#region-button-trans-reports').removeClass().addClass('region-button region-button-off');
        //             }
        //         }
        //         else {
        //             $(".uncheck-all").each(function () {
        //                 $(this).prop('checked', false);
        //             });
        //             $(".rsc-select-all").each(function () {
        //                 $(this).prop('checked', false);
        //             });
        //         }
        //     }
        //     that.runFilter();
        // });
        // $("input.rsc-text").change(function () {
        //     if ($(this).attr('id') != 'show-all' && $(this).attr('id') != 'search') {
        //         $('#show-all').prop('checked', false);
        //         $("#show-all-time").prop('checked', false);
        //     }
        //     that.runFilter();
        // });
        //.......................................................................set trans cookie to false when user click on login or logout link
        $('#menu_section.unpad_right .sf-menu>li:nth-child(4)').click(function () {
            $.cookie("trans-status", "false");
            $.cookie("isTrans", "false");
        });

        //......................................terms of services link in Disclamier message
        // $('#terms-services').click(function () {
        //     // $('[data-remodal-id=terms-services-popup]').remodal().open();
        //     $('#terms-services-popup').modal('show');
        // });

        //...................................... click to show faq popup
        $('#faq-to').click(function () {
            // $('[data-remodal-id=faqPopup]').remodal().open();
            $('#faqPopup').modal('show');
        });

        //...................................... click to show privacy policy popup
        $('#privacy-pol').click(function () {
            // $('[data-remodal-id=privacyPopup]').remodal().open();
            if (document.querySelector("#privacyPopup .close-custom-modal-remodal").classList.contains("not-hide"))
            {
                document.querySelector("#privacyPopup .close-custom-modal-remodal").classList.remove("not-hide");
            }

            $('#privacyPopup').modal('show');

        });

        //...................................... click to show about us popup
        // $('#about-us').click(function () {
        //     $('[data-remodal-id=aboutusPopup]').remodal().open();
        // });

        //...................................... click to show faq popup
        // $('#terms-co').click(function () {
        //     $('#terms-services-popup').modal('show');
        // });

        //..........................................show more link in header mobile device
        $('.show-more-link-mob').click(function () {
            $('#show-more-link-mob').modal('show');
            $('[data-remodal-id=show-more-link-mob]').remodal().open();
        });

        $(".region-button").click(function (e) {
            var target = $(e.target);
            if (!target.is('#down-arrow-review-img') || $("#region-button-reviewed-reports").hasClass('region-button-off'))
                that.selectRegion($(this)); // Exclude when clicked on reviewed button arrow
        });

        $layerToggle.click(function () {
            if (!$layerToggle.hasClass('active')) {
                $layerToggle.html('Satellite map');
                $layerToggle.addClass('active');
                $(".leaflet-container").css("background", "#cad2d3");
                that.map.removeLayer(that.terrainLayer);
            } else {
                $layerToggle.html('Political map');
                $layerToggle.removeClass('active');
                $(".leaflet-container").css("background", "#040B15");
                that.terrainLayer.addTo(that.map);
            }
        });


        // Check if all option
        $(".rsc-select-all").change(function () {
            that.toggleAllNavBar();
        });

        //custom date range
        $("#from-date, #to-date ").change(function () {
            var from_date = $('#from-date').val();
            var to_date = $('#to-date').val();
            if (from_date != '' && to_date != '') {
                $('.select-custom-date').show();
            }
        });

        $('.select-custom-date').click(function () {
            $('a.date_filter').text('');
            $('#date_filter a:not(.reset-filter-link)').removeClass('date-filter-background').addClass('date-filters');
            var from_date = $('#from-date').val();
            var to_date = $('#to-date').val();
            if (from_date != '' && to_date != '') {
                $('#clear_filters').css('display', 'block');
                if (jQuery('body').hasClass('logged-in'))
                    $('#save-preferences-link').css('display', 'inline');
                $('#show-all-time').prop('checked', false);
                $('#show-all').prop('checked', false);
                var sone = [];
                sone['action'] = 'filter:date';
                sone['action_log'] = $('#to-date').val() + " | " + $('#from-date').val();
                sone['mode'] = $('.region-button-on').text();
                oRsc.activity_log(sone);
                that.runFilter();
                $('.select-custom-date').hide();
            }
        });

        //last month data
        $("#show-last-month").click(function () {
            // $('#date_filter label').css('background', '#FC2020');
            $('#date_filter label').css('background', '#DE7070');
            $('a.date_filter').text('Last 30 days');
            $('#date_filter a:not(.reset-filter-link)').removeClass('date-filter-background').addClass('date-filters');
            $(this).removeClass('date-filters').addClass('date-filter-background');
            // $('p.date_filter').css('text-decoration', 'underline');
            $('a.date_filter').css('display', 'inline');
            $('#clear_filters').css('display', 'block');
            if (jQuery('body').hasClass('logged-in'))
                $('#save-preferences-link').css('display', 'inline');
            $('#show-all-time').prop('checked', false);
            var m = new Date();
            m.setDate(m.getDate() - 29);
            $('#from-date').datepicker('setDate', m);
            $('#to-date').datepicker('setDate', new Date());
            $('#show-all').prop('checked', false);

            if (oRsc.isDatefromPref != true) {
                var sone = [];
                sone['action'] = 'filter:date';
                sone['action_log'] = $('#to-date').val() + " | " + $('#from-date').val();
                sone['mode'] = $('.region-button-on').text();
                oRsc.activity_log(sone);
                that.runFilter();
            }

            oRsc.date_filter = false;
            oRsc.isDatefromPref = false;

            if (oRsc.count == true) {
                oRsc.count == false;
            }
            $('#from-date').css('color', '');
            $('#to-date').css('color', '');

        });
        $("#last-visit").click(function () {
            // $('#date_filter label').css('background', '#FC2020');
            $('#date_filter label').css('background', '#DE7070');

            $('a.date_filter').text('since my last visit');
            $('.date-header-text.date_filter').css('margin-left', '12%');
            $('#date_filter a:not(.reset-filter-link)').removeClass('date-filter-background').addClass('date-filters');
            $(this).removeClass('date-filters').addClass('date-filter-background');
            $('#date_filter').find('');
            // $('p.date_filter').css('text-decoration', 'underline');
            $('a.date_filter').css('display', 'inline');
            $('#clear_filters').css('display', 'block');
            if (jQuery('body').hasClass('logged-in'))
                $('#save-preferences-link').css('display', 'inline');
            $('#show-all-time').prop('checked', false);
            var m = new Date(oRsc.last_visit);
            $('#from-date').datepicker('setDate', m);
            $('#to-date').datepicker('setDate', new Date());
            $('#show-all').prop('checked', false);

            if (oRsc.isDatefromPref != true) {
                var sone = [];
                sone['action'] = 'filter:date';
                sone['action_log'] = $('#to-date').val() + " | " + $('#from-date').val();
                sone['mode'] = $('.region-button-on').text();
                oRsc.activity_log(sone);
                that.runFilter();
            }

            oRsc.date_filter = false;
            oRsc.isDatefromPref = false;
            $('#from-date').css('color', '');
            $('#to-date').css('color', '');

        });
        $("#show-allll").click(function () {
            // $('#date_filter label').css('background', '#FC2020');
            $('#date_filter label').css('background', '#DE7070');

            $('a.date_filter').text('Last 365 days');
            $('#date_filter a:not(.reset-filter-link)').removeClass('date-filter-background').addClass('date-filters');
            $(this).removeClass('date-filters').addClass('date-filter-background');
            // $('p.date_filter').css('text-decoration', 'underline');
            $('a.date_filter').css('display', 'inline');

            if (jQuery('body').hasClass('logged-in')) {
                $('#clear_filters').css('display', 'block');
                if (jQuery('body').hasClass('logged-in'))
                    $('#save-preferences-link').css('display', 'inline');
            }

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


            if (oRsc.isDatefromPref != true) {
                var sone = [];
                sone['action'] = 'filter:date';
                sone['action_log'] = $('#to-date').val() + " | " + $('#from-date').val();
                sone['mode'] = $('.region-button-on').text();
                oRsc.activity_log(sone);
                that.runFilter();
            }

            oRsc.date_filter = true;
            oRsc.isDatefromPref = false;
            $('#from-date').css('color', '');
            $('#to-date').css('color', '');

        });

        $("#show-last-week").click(function () {
            // $('#date_filter label').css('background', '#FC2020');
            $('#date_filter label').css('background', '#DE7070');

            $('a.date_filter').text('Last 7 days');
            $('#date_filter a:not(.reset-filter-link)').removeClass('date-filter-background').addClass('date-filters');
            $(this).removeClass('date-filters').addClass('date-filter-background');
            // $('p.date_filter').css('text-decoration', 'underline');
            $('a.date_filter').css('display', 'inline');
            $('#clear_filters').css('display', 'block');
            if (jQuery('body').hasClass('logged-in'))
                $('#save-preferences-link').css('display', 'inline');
            $('#show-all-time').prop('checked', false);
            var oneWeekAgo = new Date();
            oneWeekAgo.setDate(oneWeekAgo.getDate() - 6);
            $('#from-date').datepicker('setDate', oneWeekAgo);
            $('#to-date').datepicker('setDate', new Date());
            $('#show-all').prop('checked', false);

            if (oRsc.isDatefromPref != true) {
                var sone = [];
                sone['action'] = 'filter:date';
                sone['action_log'] = $('#to-date').val() + " | " + $('#from-date').val();
                sone['mode'] = $('.region-button-on').text();
                oRsc.activity_log(sone);
                that.runFilter();
            }
            oRsc.date_filter = false;
            oRsc.isDatefromPref = false;
            $('#from-date').css('color', '');
            $('#to-date').css('color', '');
        });


        // Info Link
        $("div.tooltip").mouseover(function () {
            var position = $(this).offset();
            var top = position.top - $(document).scrollTop() - 6;
            var left = position.left + 32;
            $("div.tooltip-popup-report").css({
                'top': top,
                'left': left,
                'display': 'inline',
                'width': 'auto',
                'max-width': '550px',
                'max-height': '400px'
            });
            $("div.tooltip-popup-report .callout").css({top: '4px'});
            var popupContent;
            if (this.id == "tooltip-Scoping-Study-and-pea") {
                popupContent = "Preliminary Economic Assessment.";
            }
            if (this.id == "tooltip-eia-esia") {
                popupContent = "Environmental (Social) Impact Assessment. NB these are not technical reports.";
            }
            if (this.id == "tooltip-optimisation-study") {
                top = position.top - $(document).scrollTop() - 195;
                $("div.tooltip-popup-report").css({
                    'top': top,
                    'left': left,
                    'display': 'inline',
                    'width': 'auto',
                    'max-width': '550px',
                    'max-height': '400px'
                });
                $("div.tooltip-popup-report .callout").css({top: '190px'});
                popupContent = "’Optimisation Studies’ are not a recognised category by CRIRSCO-affiliated reporting codes. However, many companies use this (or similar) term to update on material changes that they feel go outside the normal public reporting requirements and compliance formatting. These may include the results of metallurgical, environmental, geotechnical, pit-optimisation or other related studies, and often do not include production targets or financial forecasts (which then don’t trigger specific stringent ASX listing rules on reporting of Scoping Studies).<br/><br/>\
                                Essentially, we see these as part of the continuous process of Scoping, and would be better placed in the Scoping Study category. However, for now we have decided to keep these separate, so that they can be filtered and analysed by interested parties wishing to investigate where the current norm of acceptance/compliance lies. \
                                <br/><br/>For further information, please contact us.";
            }
            if (this.id == "tooltip-pgm") {
                popupContent = "<b>Platinum Group Metals</b> (includes Platinum and Palladium).";
            }

            $("div.tooltip-popup-report > p").html(popupContent);
        });
        $("div.tooltip").mouseout(function () {
            $("div.tooltip-popup-report").css("display", "none");
        });

        // Compliance Link
        $(document).on('mouseover', 'img#tooltip-compliance', function () {
            var position = $(this).offset();
            var top = position.top - $(document).scrollTop() - 280;
            var left = position.left + 32;
            $("div.tooltip-popup-report").css({'top': top, 'left': left, 'display': 'inline', width: '440px'});
            $("div.tooltip-popup-report .callout").css({display: 'none', top: '280px'});

            var popupContent = "<h3 style='color:#FC2020'> WHAT  HAPPENS WHEN I REPORT A COMPLIANCE ISSUE?</h3>";
            popupContent += "<p>1. By ticking this box and clicking the submit button, Opaxe staff will receive an automated message that for research purposes prompts us to internally review the quality of the report.</p>";
            popupContent += "<p>2. After review, we may decide in our own right to submit a complaint for alleged non-compliance to the organisation to which the CP is registered, or with ASIC, depending on the nature of the breach.</p>";
            popupContent += "<p>3. <b>Using this feature is anonymous.</b> We do not store your details. Neither do we track your IP address in any way that we or anyone else can connect it with you or your organisaiton.</p>";
            popupContent += "<p>4. You are not required to fill out any details about the report, but you may optionally do this should you wish to direct us toward the compliance issue, e.g. “JORC Code clause 5 breached”, etc.</p>";
            popupContent += "<p>5. Your notification to us will not be made public, nor will it be stored in our database.</p>";

            $("div.tooltip-popup-report > p").html(popupContent);
        });
        $(document).on('mouseout', 'img#tooltip-compliance', function () {
            $("div.tooltip-popup-report").css({"display": "none", width: '240px'});
            $("div.tooltip-popup-report .callout").css({top: '4px'});
        });

        // Reset Search
        var $search = $('#search'), $btnClose = $('.close-icon'), $rscSearchIcon = $('.rsc-search-icon');
        $search.on('change keydown keyup paste input keypress', function (e) {
            if (e.type == 'keypress' && oRsc.searchKey == '') {
                $('#message-model p').text('Please select a category from the list');
                $('#message-model').modal('show');
                return;
            }
            if (oRsc.searchKey == 'commodities') {

                // if ((oRsc.userPlan != 'Plan2' && oRsc.userPlan != 'Plan3') && (e.type == 'keypress') ) {
                //     oRsc.searchKey = '';
                //     $('#commodity_checkboxes_popup span').text('This feature is available for registered users only. Please login or register for an account.');
                //     $('#commodity_checkboxes_popup').modal('show');
                //     return;
                // }

                $('.search-commodity-dropdown-content span').css('display', 'block');
                $("#search-dropdown").hide();
                if(CustomVariables.isCommoditySelected == false)
                    $("#search-commodity-dropdown").slideDown("fast");
                var input, filter, ul, li, a, i;
                input = document.getElementById("search");
                filter = $.trim(input.value.toUpperCase());
                div = document.getElementById("search-commodity-dropdown");
                a = div.getElementsByTagName("span");
                for (i = 0; i < a.length; i++) {
                    txtValue = a[i].textContent || a[i].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        a[i].style.display = "block";
                        $(a[i]).addClass('visible-commodity');
                    } else {
                        a[i].style.display = "none";

                    }
                }
            }

            var term = $search.val();
            if (term.length > 2) {
                $btnClose.show();
                $rscSearchIcon.hide();
                oRsc.searchDropdown = true;
            } else {
                if (($search.val().length == 0 && oRsc.isSearchMarkersActivated == false )) {
                    oRsc.searchonfocus();
                    $btnClose.css('display', 'none');
                    $rscSearchIcon.css('display', 'block');
                    //oRsc.isSearchMarkersActivated = false;
                }
                else if( (oRsc.searchKey == "commodities" && $search.val().length == 0) ) {
                    $btnClose.css('display', 'none');
                    $rscSearchIcon.css('display', 'block');
                    oRsc.isSearchMarkersActivated = false;
                    CustomVariables.isCommoditySelected = false;
                }
                $('.rsc-search-loading').hide();

            }
        });

        $btnClose.click(function () {
            oRsc.searchWorldjson = [];
            oRsc.searchLookup = [];
            oRsc.searchKey = '';
            oRsc.isSearchMarkersActivated = false;
            $('.rsc-search-loading').hide();
            var $sidebarGroup = $('.sidebar-group');
            //$sidebarGroup.find('label .expander').removeClass('collapsed').addClass('expanded');
            oRsc.searchDropdown = false;
            $search.val('');
            $('.search-category').hide();
            $('.ui-autocomplete').css('display', 'none');
            $btnClose.css('display', 'none');
            $rscSearchIcon.css('display', 'block');
            $('#all-reports').removeClass('date-filter-background').addClass('date-filters');
            $('.search-commodity-dropdown-content, .search-commodity-dropdown-content div').hide();
            setmapZoom(true);
            if (oRsc.selectedFilters != '')
                oRsc.runDefaultFilters(oRsc.selectedFilters);
            else
                oRsc.setDefaultDate();
        });
        // Click other than Search Container
        $(document).click(function (e) {
            if ((!$(e.target).is('input#search')) && ($('#reportbox_popup').is(':visible') == false) && (!$(e.target).parent().is('div#search-dropdown.search-dropdown-content')) && $btnClose.is(':visible') == false) {
                oRsc.searchKey = '';
                $('#search').val('');
                $('.search-category').hide();
                $('.search-commodity-dropdown-content, .search-commodity-dropdown-content div').slideUp('slow');
            }
            // setTimeout(function () {
            //     var model = $('.modal').not('#pdf-modal').is(':visible');
            //     if (model == true || oRsc.searchKey == 'commodities') {
            //         $('.ui-autocomplete').css('display', 'none');
            //         oRsc.searchDropdownonShowMap = false;
            //         oRsc.searchDropdown = false;
            //     }
            // }, 1000);

        });
        $(document).mouseup(function (e) {
            if (oRsc.searchDropdownonShowMap == true) {
                $('.ui-autocomplete').css('display', 'none');
                oRsc.searchDropdownonShowMap = false;
                oRsc.searchDropdown = false;
            } else if (oRsc.searchDropdown == true && oRsc.searchKey != "commodities") {
                $('.ui-autocomplete').css('display', 'block');
                $btnClose.css('display', 'block');
                $rscSearchIcon.css('display', 'none');

                $("#search").trigger("focusout");

            } else if (($(e.target).is('input#search')) || ($(e.target).is('input.chk-auto-complete')) || ($(e.target).parent().is('div#search-dropdown.search-dropdown-content'))) {
                if ($('#search').val().length > 2 && oRsc.search_drop_open == true && oRsc.searchKey != "commodities") {

                    $('.ui-autocomplete').css('display', 'block');
                }

            } else {
                $('.ui-autocomplete').css('display', 'none');
            }

            if (that.searchCheckedValues().length <= 0 || that.searchEnabled == false) {
                var container = $("#search");
                var autocompleteDiv = $(".ui-autocomplete");
                var loggedPopup = $("div#logout_popup");
                var avatar = $("button.dropdown-toggle");

                var target = $(e.target);

                /*hide logout popup which open when click on logged avatar*/
                if (!avatar.is(target) || !loggedPopup.is(target))
                    $("div#logout_popup").css("display", "none");

                if (!container.is(target) && !autocompleteDiv.is(target)
                    && container.has(target).length === 0 && autocompleteDiv.has(target).length === 0)  // ... nor a descendant of the container
                {
                    // $search.val('');
                    //$btnClose.css('display', 'none');
                    //$rscSearchIcon.css('display', 'block');
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
        this.setCenterToWorld(-42.1875,28.92163128242129,2);
    },

    // transactionReports: function(){
    //     $("#project-stage-group").show(500);
    //     $("#transaction-type-group").show(500);
    //     $("#resources-type-group").hide(500);
    //     $("#report-type-group").hide(500);
    //     $("#report-code-group").hide(500);
    //     $("#reserves-type-group").hide(500);

    //     this.transactionSuccess();
    // },

    toggleNavBar: function (code) {
        var that = this, sone = [];
        $("." + code).change(function () {
            if (!$('input.' + code + '[type=checkbox]:not(:checked)').length)
                $('#' + code).prop('checked', true);
            else
                $('#' + code).prop('checked', false);
            that.toggleAllNavBar();
            //oRsc.customReporting();
        });
    },

    toggleSubNavBar: function (code) {
        var that = this;
        $("#" + code).change(function () {
            if ($(this).prop('checked') == true) {
                $("." + code).each(function () {
                    $(this).prop('checked', true);
                });
            } else {
                $("." + code).each(function () {
                    $(this).prop('checked', false);
                });
                $('#show-all').prop('checked', false);
            }
            that.runFilter();
            //oRsc.customReporting();
        });
    },

    toggleAllNavBar: function () {
        if (!$('input.rsc-select-all[type=checkbox]:not(:checked)').length)
            $('#show-all').prop('checked', true);
        else
            $('#show-all').prop('checked', false);
    },

    featureAdd: function (feature, layer) {
        oRsc.curr_feature++;
        if (oRsc.curr_feature == oRsc.geojsonLength) {
            $('#loading-spin-markers').delay(500).hide(0);
        }

        var marker = layer;

        if (!feature) {
            return;
        }

        var popupContent = '<div class="leaflet-popup-content" style="height:470px !important;">';
        popupContent += '<h2 id="yui_3_17_2_2_1431404870956_1958">Getting Report Details</h2>';
        popupContent += '<div id="loading-spin" style="margin:6em auto 0;"></div></div>';

        // marker.setIcon(L.mapbox.marker.icon({
        //     'marker-color': feature.properties["cls"],
        //     'marker-size': feature.properties["marker-size"],
        //     'marker-symbol': feature.properties["marker-symbol"]
        // }));

        marker.setIcon(L.divIcon(
            {
                className: 'intel-icon ' + 'icon-' + feature.properties["cls"] + ' marker-id-' + feature.id,
                html: feature.properties["sym"],
                iconSize: null
            }
        ));
        /***bind event on marker click**/
        marker.on('click', function () {

            //Add Google Analytics Events
                       ga('send', {
                                hitType: 'event',
                                eventCategory: 'Intel',
                                eventAction: 'MarkerClick',
                                eventLabel: feature.id
                        });

            if (oPdf.nonGoldmarker == true) {
                if (oRsc.that.isMobileDevice == false)
                    oRsc.map.setView(L.latLng(marker._latlng.lat, marker._latlng.lng), 5);
                oPdf.nonGoldmarker = false;
            }
            $('.text-above-popup').remove();
            if (oRsc.that.isMobileDevice == false) {
                $('#report_box').before('<div class="text-above-popup"><span><a style="color: #42444E;"><span>Selected report:</span></a></span><span><a id="close_reportbox-desktop" onclick="oRsc.closeReportbox();"> &larr;<span class="return-to-filters">Return to filters</span> </a></span></div>');
                $('.sidebar-form-below-div2').css('height', '100%');
                setMarkercolor();
                $("#reportbox_popup").remove();
                $('#report_box').append('<div id="reportbox_popup"></div>');
            } else {
                setMarkercolor();
            }

            function setMarkercolor() {
                var highlightedMarker = $('.highlightMarker');
                if (oRsc.markerClass != '') {
                    highlightedMarker.removeClass('highlightMarker').addClass(oRsc.markerClass);
                    marker.bindPopup(popupContent, {
                        closeButton: true,
                        minWidth: 320,
                        autoPanPaddingTopLeft: [0, 60]
                    });
                }
                oRsc.markerClass = 'intel-icon ' + 'icon-' + feature.properties["cls"];
                marker.setIcon(L.divIcon(
                    {
                        className: 'intel-icon ' + 'highlightMarker',
                        html: feature.properties["sym"],
                        iconSize: null
                    }
                ));
            }

            var sone = [];
            sone['action'] = 'Marker clicked';
            sone['action_log'] = 'view report box';
            sone['report-id'] = feature.id;
            sone['mode'] = $('.region-button-on').text();
            oRsc.activity_log(sone);
            oRsc.reportById(feature.id);
        });

        marker.bindPopup(popupContent, {
            // closeButton: true,
            minWidth: 320,
        });
    },

    displayFeaturePopup: function (feature) {
        var bcolour = 'grey-bg';
        if (feature.status == 'Updated') {
            bcolour = "blue-bg";
        }
        if (feature.status == 'Maiden') {
            bcolour = "orange-bg";
        }
        if (feature.status == 'Upgraded') {
            bcolour = "green-bg";
        }

        var hasOther = false;
        var icons = '';
        var history = '';
        var types = feature.commodities.toLowerCase().split("-");
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
                case 'rare earth':
                    icons += '<div class="commodity-icon-and-desc cf" style="width: 55px;">\
          <div class="commodity-icon-ree"></div>\
          <p class="commodity-desc">Rare earth</p>\
          </div>';
                    break;
                case 'ree':
                    icons += '<div class="commodity-icon-and-desc cf" style="width: 55px;">\
          <div class="commodity-icon-ree"></div>\
          <p class="commodity-desc">Rare earth</p>\
          </div>';
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

                case 'tantalum':
                    icons += '<div class="commodity-icon-and-desc cf" style="width: 60px;">\
          <div class="commodity-icon-other"></div>\
          <p class="commodity-desc">Tantalum</p>\
          </div>';
                    break;

                case 'cobalt':
                    icons += '<div class="commodity-icon-and-desc cf">\
          <div class="commodity-icon-other"></div>\
          <p class="commodity-desc">Cobalt</p>\
          </div>';
                    break;

                case 'graphite':
                    icons += '<div class="commodity-icon-and-desc cf" style="width: 50px;">\
          <div class="commodity-icon-other"></div>\
          <p class="commodity-desc">Graphite</p>\
          </div>';
                    break;

                case 'tungsten':
                    icons += '<div class="commodity-icon-and-desc cf">\
          <div class="commodity-icon-other"></div>\
          <p class="commodity-desc">Tungsten</p>\
          </div>';
                    break;

                case 'pge':
                    icons += '<div class="commodity-icon-and-desc cf">\
          <div class="commodity-icon-other"></div>\
          <p class="commodity-desc">PGE</p>\
          </div>';
                    break;

                case 'zircon':
                    icons += '<div class="commodity-icon-and-desc cf">\
          <div class="commodity-icon-other"></div>\
          <p class="commodity-desc">Zircon</p>\
          </div>';
                    break;

                case 'platinum':
                    icons += '<div class="commodity-icon-and-desc cf">\
          <div class="commodity-icon-other"></div>\
          <p class="commodity-desc">Platinum</p>\
          </div>';
                    break;

                case 'ilmenite':
                    icons += '<div class="commodity-icon-and-desc cf" style="width: 50px;">\
          <div class="commodity-icon-other"></div>\
          <p class="commodity-desc">Ilmenite</p>\
          </div>';
                    break;

                case 'palladium':
                    icons += '<div class="commodity-icon-and-desc cf" style="width: 60px;">\
          <div class="commodity-icon-other"></div>\
          <p class="commodity-desc">Palladium</p>\
          </div>';
                    break;

                case 'lithium':
                    icons += '<div class="commodity-icon-and-desc cf" style="width: 50px;">\
          <div class="commodity-icon-other"></div>\
          <p class="commodity-desc">Lithium</p>\
          </div>';
                    break;

                case 'niobium':
                    icons += '<div class="commodity-icon-and-desc cf">\
          <div class="commodity-icon-other"></div>\
          <p class="commodity-desc">Niobium</p>\
          </div>';
                    break;

                case 'potash':
                    icons += '<div class="commodity-icon-and-desc cf">\
          <div class="commodity-icon-other"></div>\
          <p class="commodity-desc">Potash</p>\
          </div>';
                    break;

                case 'molybdenum':
                    icons += '<div class="commodity-icon-and-desc cf" style="width: 60px;">\
          <div class="commodity-icon-other"></div>\
          <p class="commodity-desc">Molybdenum</p>\
          </div>';
                    break;

                case 'vanadium':
                    icons += '<div class="commodity-icon-and-desc cf" style="width: 60px;">\
          <div class="commodity-icon-other"></div>\
          <p class="commodity-desc">Vanadium</p>\
          </div>';
                    break;


                case 'pgm':
                    icons += '<div class="commodity-icon-and-desc cf" style="width: 60px;">\
          <div class="commodity-icon-other"></div>\
          <p class="commodity-desc">PGM</p>\
          </div>';
                    break;


                case 'titanium':
                    icons += '<div class="commodity-icon-and-desc cf" style="width: 60px;">\
          <div class="commodity-icon-other"></div>\
          <p class="commodity-desc">Titanium</p>\
          </div>';
                    break;

                case 'aluminium':
                    icons += '<div class="commodity-icon-and-desc cf" style="width: 60px;">\
          <div class="commodity-icon-other"></div>\
          <p class="commodity-desc">Aluminium</p>\
          </div>';
                    break;

                default: {
                    if (!hasOther) {
                        icons += '<div class="commodity-icon-and-desc cf">\
              <div class="commodity-icon-other"></div>\
              <p class="commodity-desc">' + thisType.toUpperCase() + '</p>\
              </div>';
                    }
                    hasOther = true;
                    break;
                }
                    break;
            }
        }

        var review;
        if (feature.review_submitted) {
            var review_id = feature.review_submitted;
            review = '<p>You have reviewed <br />this report.</p>';
            review += '<a href="#" report="' + feature.id + '" class="btn-rsc" onclick="javascript:oReview.editReview(' + review_id + ');"  id="' + feature.id + '-review-btn">Edit Your Review</a>';
        } else {
            review = '<a href="#" report="' + feature.id + '" class="btn-rsc" onclick="javascript:oRsc.reviewReport(this);"  id="' + feature.id + '-review-btn">Review This Report</a>';
        }

        var totalNumberOfReview = 0,
            totalReview = parseInt(feature.total);
        if (typeof totalReview != 'undefined')
            totalNumberOfReview = totalReview;

        //var overallRating;
        var overallRating = '<a id="' + feature.id + '" onclick="javascript:oRsc.viewSummary();">Find out more</a>';


        var date = feature.date;
        date = date.substring(8, 10) + '/' + date.substring(5, 7) + '/' + date.substring(0, 4);
        if (oRsc.trans_call == true) {

            oRsc.currentReport = feature;
            var popupContent = '<div  class="leaflet-popup-content">';
            popupContent = '<div class="text-inside-popup"><span>Selected report:</span><span><a id="close_reportbox" onclick="oRsc.closeReportbox();">close</a></span></div>';
            popupContent += '<div id="comp-name"><h2 id="yui_3_17_2_2_1431404870956_1958">' + feature.company + '</h2>';
            popupContent += '<h2 id="ticker">' + feature.ticker + '</h2>';
            popupContent += '<ul id="tabs" class="nav nav-tabs" data-tabs="tabs" style="border-bottom:0px;">';
            popupContent += '<li class="active"><a href="#project" onclick="oRsc.removetabheight()" data-toggle="tab">LATEST REPORT</a></li>';
            popupContent += '<li><a href="#history" onclick="oRsc.changetabheight()"  data-toggle="tab">PREVIOUS REPORTS<span id="count-history"></span></a></li>';

            popupContent += '</ul><hr id="fixed-line"></div>';
            popupContent += '<div id="my-tab-content" class="tab-content" style="max-height: 600px;top:130px;">';
            popupContent += '<div class="tab-pane active" id="project" style="max-height: 600px;">';
            popupContent += '<table id="yui_3_17_2_2_1431404870956_1977">';
            popupContent += '<tbody id="yui_3_17_2_2_1431404870956_1976"><tr>';
            popupContent += '<td><b>    PROJECT/TENEMENT:</b></td><td>' + feature.project + '</td>';
            popupContent += '</tr>';
            popupContent += '<tr>';
            popupContent += '<td><b>          LOCATION ACCURACY:</b></td><td>' + feature.accuracy + '</td>';
            popupContent += '</tr>';
            popupContent += '<tr id="yui_3_17_2_2_1431404870956_1975">';
            popupContent += '<td><b>Date:</b></td><td id="yui_3_17_2_2_1431404870956_1974">' + feature.date + '</td>';
            popupContent += '</tr>';
            popupContent += '<tr id="yui_3_17_2_2_1431404870956_1991">';
            popupContent += '<td><b>    TRANSACTION TYPE:</b></td><td id="yui_3_17_2_2_1431404870956_1990">' + feature.type + '</td>';
            popupContent += '</tr>';
            popupContent += '<tr>';


            popupContent += '<td><b>     VALUE RANGE (US$):</b></td><td>' + feature.value_range + '</td>';
            popupContent += '</tr>';
            popupContent += '<tr>';
            popupContent += '<td><b>Download</b></td>';
            /*popupContent += '<td><a href="report/' +  feature.url_name + '" target="_blank"><i class="fa fa-arrow-circle-o-down"></i> View this Report.</a></td>';*/
            popupContent += '<td style="cursor: pointer;"><a onclick="javascript:oPdf.confirmDownload(' + feature.id + ');"><i class="fa fa-arrow-circle-o-down"></i> Download this Report.</a></td>';
            popupContent += '</tr>';
            popupContent += '<tr>';
            popupContent += '<td><b>Commodities:</b></td><td>' + icons + '</td>';
            popupContent += '</tr>';
            popupContent += '<tr>';
            popupContent += '<td><b>RESOURCES/RESERVES:</b></td><td>' + feature.resources_reserves + '</td>';
            popupContent += '</tr>';
            popupContent += '<tr>';
            var resources = (feature.resources) ? feature.resources : 'not specified';
            popupContent += '<td><b>HIGHEST CLASSIFICATION:</b></td><td>' + feature.class_level + '</td>';
            popupContent += '</tr>';
            popupContent += '<tr id="cp-qp">';
            popupContent += '<td><b>SUMMARY:</b></td><td>' + feature.transaction_summary + '</td>';
            popupContent += '</tr>';
            popupContent += '<tr id="author">';
            popupContent += '<td><b>AUTHOR:</b></td><td>' + feature.author_aff + '</td>';
            popupContent += '</tr>';
            if (oRsc.that.isMobileDevice == false) {
                popupContent += '<tr id="report-compliance-issue">';
                popupContent += '<td><b>COMPLIANCE:</b>';
                popupContent += '</td>';
                popupContent += '<td id="com_second_td"><div id="comp_chckbox"><input id="checked" type="checkbox" /></div><span><div id="comp_trans_text">I would like to  report a compliance or data error issue with this report.</span></span></div>';
                popupContent += '</td>';
                popupContent += '</tr>';
                popupContent += '<tr>';
                popupContent += '<td>';
                popupContent += '<img id="tooltip-compliance" src= "' + BASE_URL + '/wp-content/themes/fount/intel/images/info.png">';
                var date1 = "'" + feature.date + "'";
                var company = "'" + feature.company + "'";
                var project = "'" + feature.project + "'";
                var code = "'" + feature.code + "'";
                var type = "'" + feature.type + "'";
                var cpqp = "'" + feature.cpqp + "'";

                popupContent += '<input id="comp-submit-btn" type="button" value="Submit" disabled onclick="javascript:oRsc.complianceIssue(' + feature.id + ',' + date1 + ',' + company + ',' + project + ',' + code + ',' + type + ',' + cpqp + ');" />';
                popupContent += '</td>';
                popupContent += '<td><textarea onKeyup="javascript:oRsc.checkmessage(this);" id="compliance-comments" style="width:146px;" rows="2" cols="27"></textarea></td>';
                popupContent += '</td>';
                popupContent += '</tr>';
            }
            popupContent += '</tbody></table>';
            popupContent += '<div id="tr-rating">';
            popupContent += '<div id="rating-container"><b class="ol-rating">OVERALL RATING: </b><div class="star-rating rating-xs rating-disabled"><div title="Clear" class="clear-rating "><i class="glyphicon glyphicon-minus-sign"></i></div><div class="rating-container rating-gly-star" data-content=""><div class="rating-stars" data-content="" style="width: 0%;"></div><input class="reviews-rating form-control hide" value="0" data-stars="5" data-step="5" data-size="xs" disable="disabled"></div><div class="caption"><span class="label label-default">Not Rated</span></div></div></div>';
            popupContent += '<div id="more-link">' + overallRating + '</div></div>';
            popupContent += '</div>';
            popupContent += '<div class="tab-pane" id="history" style=" overflow-y: auto; max-height: 316px;">';
            popupContent += '<table id="yui_3_17_2_2_1431404870956_1977">';
            popupContent += '<tbody id="yui_3_17_2_2_1431404870956_1976">';
            popupContent += '<tr>';
            popupContent += '<td><b>History:</b></td><td>(click on a report to see details)</td>';
            popupContent += '</tr>';
            popupContent += '</tbody></table>';
            //popupContent += '<div style="text-align: center; padding: 6px; "> '+ review +' </div>';
            popupContent += '<div id="history_conatiner">';
            popupContent += '<div class="spinner medium" id="loading" style="margin-top: 37px;"></div>';
            popupContent += '</div>';
            popupContent += '<div id="history_data">';
            popupContent += '<div class="spinner medium" id="text_loading" style="margin-top: 37px;"></div>';
            popupContent += '</div>';
            popupContent += '</div>'; //history_conatiner

            popupContent += '<div class="tab-pane" id="rating">';
        } else {
            var popupContent = '<div  class="leaflet-popup-content">';
            var latestTab;
            var previousTab;
            // if(oRsc.isSearchOnly==false) {
            latestTab = ' active';
            previousTab = ' de-active';
            // }
            //else {
            // previousTab = ' active';
            // latestTab = ' de-active';
            // }
            popupContent = '<div class="text-inside-popup"><span>Selected report:</span><span><a id="close_reportbox" onclick="oRsc.closeReportbox();">close</a></span></div>';
            popupContent += '<div id="comp-name"><h2 id="yui_3_17_2_2_1431404870956_1958">' + feature.company + '</h2>';
            if (feature.ticker == undefined)
                feature.ticker = '';
            popupContent += '<h2 id="ticker">' + feature.ticker + '</h2>';
            popupContent += '<ul id="tabs" class="nav nav-tabs" data-tabs="tabs" style="border-bottom:0px">';
            popupContent += '<li class=' + latestTab + '><a href="#project" onclick="oRsc.removetabheightTechReport()" data-toggle="tab">LATEST REPORT</a></li>';
            popupContent += '<li class=' + previousTab + '><a href="#history" onclick="oRsc.changetabheightTechMode()" data-toggle="tab">PREVIOUS REPORTS<span id="count-history"></span></a></li>';
            /*Todo: RSC-MI taking parts down*/
            popupContent += '</ul><hr id="fixed-line"></div>';
            popupContent += '<div id="my-tab-content" class="tab-content" style="max-height: 600px;">';
            popupContent += '<div class="tab-pane' + latestTab + '" id="project" style="max-height: 600px;">';
            popupContent += '<table id="yui_3_17_2_2_1431404870956_1977">';
            popupContent += '<tbody id="yui_3_17_2_2_1431404870956_1976"><tr>';
            popupContent += '<td><b>Project:</b></td><td>' + feature.project + '</td>';
            popupContent += '</tr>';
            popupContent += '<tr>';
            popupContent += '<td><b>Deposit:</b></td><td>' + feature.deposit + '</td>';
            popupContent += '</tr>';
            popupContent += '<tr id="yui_3_17_2_2_1431404870956_1975">';
            popupContent += '<td><b>Date:</b></td><td id="yui_3_17_2_2_1431404870956_1974">' + feature.date + '</td>';
            popupContent += '</tr>';
            popupContent += '<tr id="yui_3_17_2_2_1431404870956_1991">';
            popupContent += '<td><b>Report Code:</b></td><td id="yui_3_17_2_2_1431404870956_1990">' + feature.code + '</td>';
            popupContent += '</tr>';
            popupContent += '<tr>';
            popupContent += '<td><b>Report Type:</b></td><td>' + feature.type + '</td>';
            popupContent += '</tr>';
            popupContent += '<tr>';
            popupContent += '<td><b>Download:</b></td>';
            var pdf_url = localStorage.getItem("pdf_temporary_Url");
            if (pdf_url == feature.url_name) {
                popupContent += '<td style="cursor: pointer;"><a onclick="javascript:oPdf.blockAcesstoReport();"><i class="fa fa-arrow-circle-o-down"></i> View this Report.</a></td>';
            }
            /*popupContent += '<td><a href="report/' +  feature.url_name + '" target="_blank"><i class="fa fa-arrow-circle-o-down"></i> View this Report.</a></td>';*/
            else
                popupContent += '<td style="cursor: pointer;"><a  class="view-report" onclick="javascript:oPdf.init();"><i class="fa fa-arrow-circle-o-down"></i> View this Report.</a></td>';
            popupContent += '</tr>';
            popupContent += '<tr>';
            popupContent += '<td class="commodities-table-data"><b>Commodities:</b></td><td>' + icons + '</td>';
            popupContent += '</tr>';
            popupContent += '<tr>';
            popupContent += '<td><b>Report Details:</b></td><td>' + feature.detail + '</td>';
            popupContent += '</tr>';
            popupContent += '<tr>';
            var resources = (feature.resources) ? feature.resources : 'not specified';
            popupContent += '<td class="resources-table-data"><b>Resources:</b></td><td>' + feature.status + ' - ' + resources + '</td>';
            popupContent += '</tr>';
            popupContent += '<tr id="cp-qp">';
            popupContent += '<td><b>CP/QP:</b></td><td>' + feature.cpqp + '</td>';
            popupContent += '</tr>';
            if (oRsc.that.isMobileDevice == false) {
                popupContent += '<tr id="report-compliance-issue">';
                popupContent += '<td><b>COMPLIANCE:</b>';
                popupContent += '</td>';
                popupContent += '<td id="com_second_td"><div id="comp_chckbox"><input id="checked" type="checkbox" /></div>';
                popupContent += '<div id="comp_text"><span>' + oRsc.comp_text + '</span></div>';
                popupContent += '</td>';
                popupContent += '</tr>';
                popupContent += '<tr>';
                popupContent += '<td>';
                popupContent += '<img id="tooltip-compliance" src= "' + BASE_URL + '/wp-content/themes/fount/intel/images/info.png">';
                var date1 = "'" + feature.date + "'";
                var company = "'" + feature.company + "'";
                var project = "'" + feature.project + "'";
                var code = "'" + feature.code + "'";
                var type = "'" + feature.type + "'";
                var cpqp = "'" + feature.cpqp + "'";
                popupContent += '<input id="comp-submit-btn" type="button" value="Submit" disabled onclick="javascript:oRsc.complianceIssue(' + feature.id + ',' + date1 + ',' + company + ',' + project + ',' + code + ',' + type + ',' + cpqp + ');" />';
                popupContent += '</td>';
                popupContent += '<td><textarea onKeyup="javascript:oRsc.checkmessage(this);" id="compliance-comments" rows="2" cols="27"></textarea></td>';
                popupContent += '</td>';
                popupContent += '</tr>';
            }
            popupContent += '</tbody></table>';
            popupContent += '<div id="tr-rating">';
            popupContent += '<div id="rating-container"><b class="ol-rating">OVERALL RATING: </b><div class="star-rating rating-xs rating-disabled"><div title="Clear" class="clear-rating "><i class="glyphicon glyphicon-minus-sign"></i></div><div class="rating-container rating-gly-star" data-content=""><div class="rating-stars" data-content="" style="width: 0%;"></div><input class="reviews-rating form-control hide" value="0" data-stars="5" data-step="5" data-size="xs" disable="disabled"></div><div class="caption"><span class="label label-default">Not Rated</span></div></div></div>';
            popupContent += '<div id="more-link">' + overallRating + '</div></div>';
            popupContent += '</div>';
            popupContent += '<div class="tab-pane' + previousTab + '" id="history" style="max-height: 316px;">';
            popupContent += '<table id="yui_3_17_2_2_1431404870956_1977">';
            popupContent += '<tbody id="yui_3_17_2_2_1431404870956_1976">';
            popupContent += '<tr>';
            popupContent += '<td><b>Project:</b></td><td>' + feature.project + '</td></tr>';
            popupContent += '<tr>';
            popupContent += '<td><b>Deposit:</b></td><td>' + feature.deposit + '</td>';
            popupContent += '</tr>';
            popupContent += '<tr>';
            popupContent += '<td><b>Commodities:</b></td><td>' + icons + '</td>';
            popupContent += '</tr>';
            popupContent += '<tr><td><b>History:</b></td><td>(click on a report to see details)</td>';
            popupContent += '</tr>';
            popupContent += '</tbody></table>';
            //popupContent += '<div style="text-align: center; padding: 6px; "> '+ review +' </div>';
            popupContent += '<div id="history_conatiner">';
            popupContent += '<div class="spinner medium" id="loading" style="margin-top: 37px;"></div>';
            popupContent += '</div>';
            popupContent += '<div id="history_data">';
            popupContent += '<div class="spinner medium" id="text_loading" style="margin-top: 37px;"></div>';
            popupContent += '</div>';
            popupContent += '</div>'; //history_conatiner

            popupContent += '<div class="tab-pane" id="rating">';
        }

        var rev, level;
        level = $.cookie('level');
        if (totalNumberOfReview > 0) {
            if (totalNumberOfReview >= 3 || level == 'Reviewer' || level == 'Senior Reviewer' || level == 'Admin')
                rev = '<a id="' + feature.id + '" class="report-review-count" onclick="javascript:oRsc.viewReportSummary(this);">' + totalNumberOfReview + ' expert reviews</a>';
            else
                rev = '<lable style="font-size:14px; font-weight:bold;" id="' + feature.id + '">' + totalNumberOfReview + ' expert reviews</span>';

            popupContent += '<p>This report has been reviewed by members of an <a href="expert-panel.php" target="_blank">expert panel</a>. The displayed scores are the average score for each feature based on ' + rev + '.</p>';
        } else {
            popupContent += '<p>This report has not been reviewed yet.</p>';
        }

        popupContent += '<table class="rating_summary"><div class="spinner medium" style="margin-top: 37px;"></div></table>';
        //if(totalNumberOfReview > 3){
        //    popupContent += '<table class="rating_summary"><div class="spinner medium" style="margin-top: 37px;"></div></table>';
        //}else{
        //    popupContent += '<p class="insufficient-rating"> (&lt;3 reviews)</p>';
        //}

        popupContent += '<div id="pop_footer">';
        popupContent += '<div style="float:left; " id="tr-rating-review">' + review + '</div>';
        //popupContent += '<div style="float:right; padding:4px 3em 0;">' + rev +'</div>';
        popupContent += '</div>'; //pop_footer
        //overall_rating_note
        if (totalNumberOfReview > 0)
            popupContent += '<div id="overall_rating_note">An overall negative rating does not necessarily mean the Report is not compliant. It means that in the view of our Reviewers, as a minimum, there are certain issues noted that could be improved on. It also does not mean that a positive overall rating means that the report is compliant.</div>'; //overall rating note

        popupContent += '</div>'; //rating
        popupContent += '</div>';
        popupContent += '</div>';

        var $leafletPopup = $('.leaflet-popup-content');
        $leafletPopup.html('');
        //$leafletPopup.css('height', '450px');
        $leafletPopup.html(popupContent);
        //display popup in sidebar
        if (this.isMobileDevice == false) {
            $('#filters').css('display', 'none');
            $(".leaflet-popup-content").appendTo('#reportbox_popup');
            $('.sidebar-group p').css('display', 'none');
        }
    },

    viewSummary: function () {

        $('#my-tab-content div').removeClass("active");
        $('.leaflet-popup-content ul#tabs li').removeClass('active');

        $('#my-tab-content div#rating').addClass("active");
        $('.leaflet-popup-content ul#tabs li:nth-child(3)').addClass("active");
    },

    getHistory: function (feature) {

        var nonGoldreport = false;
        fields = {"latitude": feature.latitude, "longitude": feature.longitude, "report_id": feature.id};
        var pdf_url = localStorage.getItem("pdf_temporary_Url");
        if (pdf_url == feature.url_name) {
            nonGoldreport = true;
        }
        var url = SCRIPT_PATH + "?action=getHistory";
        $.post(url, fields, function (response) {
            if (response.success) {
                if (response.history) {
                    oRsc.previous_reports = response.history;
                    $('#count-history').text('(' + response.history.length + ')');
                    oRsc.handleHistoryResponse(response.history, 'history_conatiner', nonGoldreport);
                    //$('.history-reviews-rating').rating({disabled: true});

                }
            } else {
                $('#count-history').text('(0)');
                //Todo: Display some error
                document.getElementById('history_conatiner').innerHTML = '<p>no history found.</p>';
            }
        }, 'json');
        setTimeout(function () {
            $("#loading").hide();
            $("#text_loading").hide();
        }, 1000);
    },

    getTransHistory: function (feature) {

        fields = {"latitude": feature.latitude, "longitude": feature.longitude, "report_id": feature.id};

        var url = SCRIPT_PATH + "?action=getTransHistory";
        $.post(url, fields, function (response) {
            // oRsc.showRatingDetail(feature.id);
            if (response.success) {
                if (response.history) {
                    $('#count-history').text('(' + response.history.length + ')');
                    oRsc.handleTransHistoryResponse(response.history, 'history_conatiner');
                    //$('.history-reviews-rating').rating({disabled: true});

                }
            } else {
                $('#count-history').text('(0)');
                //Todo: Display some error
                document.getElementById('history_conatiner').innerHTML = '<p>no history found.</p>';
            }
        }, 'json');
        setTimeout(function () {
            $("#loading").hide();
            $("#text_loading").hide();
        }, 1000);
    },

    handleHistoryResponse: function (history, container, nonGoldreport) {
        container = document.getElementById(container);
        containerText = document.getElementById('history_data');
        var row, that = this, level = $.cookie('level');
        //var dara=history.reverse();
        $.each(history.reverse(), function (j, res) {
            row = document.createElement('div');
            if ($.inArray(res.id, oRsc._checkedValues().map(Number)) !== -1) {
                row.className = 'history_type_cont relevant-reports';
            } else {
                row.className = 'history_type_cont';
            }

            row.id = 'row_' + j;

            var date = document.createElement('div');
            date.className = 'data';
            date_time = res.date;
            date.innerHTML = date_time.substring(8, 10) + '/' + date_time.substring(5, 7) + '/' + date_time.substring(0, 4);
            var text = document.createElement('div');
            text.className = 'data history_cont types';
            text.innerHTML = res.type;
            var stars = document.createElement('div');
            stars.className = 'star';

            //var rating = 0;
            //if(parseInt(res.total) > 0){
            //     rating = parseInt(res.total_score)/parseInt(res.total);
            //}


            var reviewStr = "<input class='history-reviews-rating' 'data-stars'= '5' value=" + parseFloat(res.total_score) + " 'data-stars' = '5','data-step'= '5','data-size'= 'xxs',disable  />";
            var starContainer = document.createElement('fieldset');
            starContainer.className = 'rating';
            starContainer.innerHTML = reviewStr;

            var reviewLink = document.createElement('a');
            reviewLink.href = '#';
            reviewLink.id = res.report_id;
            reviewLink.innerHTML = res.total + ' reviews';

            var review = document.createElement('div');
            review.className = 'data history_cont';

            row.appendChild(date);
            row.appendChild(text);
            /*Todo: RSC-MI taking parts down*/
            //stars.appendChild(starContainer);
            //row.appendChild(stars);
            //review.appendChild(reviewLink);
            //row.appendChild(review);
            /*Todo: End*/
            container.appendChild(row);


            $(reviewLink).on('click', function () {
                if (parseInt(res.total) >= 3 || level == 'Reviewer' || level == 'Senior Reviewer' || level == 'Admin')
                    oRsc.viewReportSummary(this);
            });

            $(row).on('click', function () {
                oRsc.showRelatedContent(this);

            });

            /*table data*/
            var table = document.createElement('table');
            table.id = 'tab_' + j;
            table.className = 'tab_';
            //table.style.display = 'none';
            var tBody = document.createElement('tbody');

            var trDownload = document.createElement('tr');
            var tdDownloadHeading = document.createElement('td');
            tdDownloadHeading.innerHTML = '<b>Download</b>';
            var tdDownloadText = document.createElement('td');
            if (nonGoldreport == true) {
                tdDownloadText.innerHTML = '<a url_name="' + res.url_name + '" pdf_link="' + res.pdf_link + '" company="' + res.company + '" onclick="javascript:oPdf.blockAcesstoReport(this);"><i class="fa fa-arrow-circle-o-down"></i> View this Report.</a>';
            }
            //tdDownloadText.innerHTML = '<a href="report/' +  res.url_name + '" target="_blank"><i class="fa fa-arrow-circle-o-down"></i> View this Report.</a>';
            else
                tdDownloadText.innerHTML = '<a url_name="' + res.url_name + '" pdf_link="' + res.pdf_link + '" company="' + res.company + '" onclick="javascript:oPdf.viewHistoryReportPDF(this);"><i class="fa fa-arrow-circle-o-down"></i> View this Report.</a>';
            trDownload.appendChild(tdDownloadHeading);
            trDownload.appendChild(tdDownloadText);

            var trReportCode = document.createElement('tr');
            var tdReportcodeHeading = document.createElement('td');
            tdReportcodeHeading.innerHTML = '<b>Report Code:</b>';
            var tdReportCodeText = document.createElement('td');
            tdReportCodeText.innerHTML = res.code;
            trReportCode.appendChild(tdReportcodeHeading);
            trReportCode.appendChild(tdReportCodeText);

            var trDetail = document.createElement('tr');
            var tdDetailHeading = document.createElement('td');
            tdDetailHeading.innerHTML = '<b>Report Details:</b>';
            var tdDetailText = document.createElement('td');
            tdDetailText.innerHTML = res.detail;
            trDetail.appendChild(tdDetailHeading);
            trDetail.appendChild(tdDetailText);

            var trResources = document.createElement('tr');
            var tdResourcesHeading = document.createElement('td');
            tdResourcesHeading.innerHTML = '<b>Resources:</b>';
            var tdResourcesText = document.createElement('td');
            tdResourcesText.innerHTML = res.resources;
            trResources.appendChild(tdResourcesHeading);
            trResources.appendChild(tdResourcesText);

            var trCPQP = document.createElement('tr');
            var tdCPQPHeading = document.createElement('td');
            tdCPQPHeading.innerHTML = '<b>CP/QP:</b>';
            var tdCPQPText = document.createElement('td');
            tdCPQPText.innerHTML = res.cpqp;
            trCPQP.appendChild(tdCPQPHeading);
            trCPQP.appendChild(tdCPQPText);

            var reviewLink;

            if (res.review_submitted) {
                $('#review-report-id').val(res.id);
                $('#history-review').val('True');
                var review_id = res.review_submitted;
                reviewLink = '<p>You have reviewed this report.</p>';
                reviewLink += '<a style="cursor: pointer;" href="#" report="' + res.id + '" class="btn-rsc" ';
                reviewLink += 'onclick="javascript:oReview.editReview(' + review_id + ');"  id="' + review_id + '-history-review">Edit Your Review</a>';
            } else {
                $('#review-report-id').val(res.id);
                reviewLink = '<a style="cursor: pointer;" href="#" report="' + res.id + '" class="btn-rsc" ';
                reviewLink += 'onclick="javascript:oRsc.reviewHistoryReport(this);"  id="' + res.id + '-history-review">Review This Report</a>';
            }

            var reviewLinkContainer = document.createElement('div');
            reviewLinkContainer.id = 'reviewLinkContainer_' + j;
            reviewLinkContainer.className = 'reviewLinkContainer_';
            reviewLinkContainer.style.textAlign = 'center';
            reviewLinkContainer.style.padding = '9px 5px';

            reviewLinkContainer.innerHTML = reviewLink;

            tBody.appendChild(trDownload);
            tBody.appendChild(trReportCode);
            tBody.appendChild(trDetail);
            tBody.appendChild(trResources);
            tBody.appendChild(trCPQP);
            table.appendChild(tBody);
            containerText.appendChild(table);
            /*Todo: RSC-MI taking parts down*/
            /*containerText.appendChild(reviewLinkContainer);*/

        });

        $(".tab_").css("display", "none");
        $(".reviewLinkContainer_").css("display", "none");
    },

    handleTransHistoryResponse: function (history, container) {
        container = document.getElementById(container);
        containerText = document.getElementById('history_data');
        var row, that = this, level = $.cookie('level');

        $.each(history.reverse(), function (j, res) {

            row = document.createElement('div');
            row.className = 'history_type_cont';
            row.id = 'row_' + j;

            var date = document.createElement('div');
            date.className = 'data';
            date_time = res.announcement_date;
            date.innerHTML = date_time.substring(8, 10) + '/' + date_time.substring(5, 7) + '/' + date_time.substring(0, 4);

            var text = document.createElement('div');
            text.className = 'data history_cont types';
            text.innerHTML = res.type;

            var stars = document.createElement('div');
            stars.className = 'star';

            //var rating = 0;
            //if(parseInt(res.total) > 0){
            //     rating = parseInt(res.total_score)/parseInt(res.total);
            //}


            var reviewStr = "<input class='history-reviews-rating' 'data-stars'= '5' value=" + parseFloat(res.total_score) + " 'data-stars' = '5','data-step'= '5','data-size'= 'xxs',disable  />";
            var starContainer = document.createElement('fieldset');
            starContainer.className = 'rating';
            starContainer.innerHTML = reviewStr;

            var reviewLink = document.createElement('a');
            reviewLink.href = '#';
            reviewLink.id = res.report_id;
            reviewLink.innerHTML = res.total + ' reviews';

            var review = document.createElement('div');
            review.className = 'data history_cont';

            row.appendChild(date);
            row.appendChild(text);
            /*Todo: RSC-MI taking parts down*/
            //stars.appendChild(starContainer);
            //row.appendChild(stars);
            //review.appendChild(reviewLink);
            //row.appendChild(review);
            /*Todo: End*/
            container.appendChild(row);


            $(reviewLink).on('click', function () {
                if (parseInt(res.total) >= 3 || level == 'Reviewer' || level == 'Senior Reviewer' || level == 'Admin')
                    oRsc.viewReportSummary(this);
            });

            $(row).on('click', function () {
                oRsc.selectedReport = res;
                oRsc.showRelatedContent(this);

            });

            /*table data*/
            var table = document.createElement('table');
            table.id = 'tab_' + j;
            table.className = 'tab_';
            //table.style.display = 'none';
            var tBody = document.createElement('tbody');

            var trDownload = document.createElement('tr');
            var tdDownloadHeading = document.createElement('td');
            tdDownloadHeading.innerHTML = '<b>Download</b>';
            var tdDownloadText = document.createElement('td');
            //tdDownloadText.innerHTML = '<a href="report/' +  res.url_name + '" target="_blank"><i class="fa fa-arrow-circle-o-down"></i> View this Report.</a>';
            tdDownloadText.innerHTML = '<a url_name="' + res.url_name + '" pdf_link="' + res.pdf_link + '" company="' + res.company + '" onclick="javascript:oPdf.confirmDownload(' + res.id + ');"><i class="fa fa-arrow-circle-o-down"></i> Download Report.</a>';
            trDownload.appendChild(tdDownloadHeading);
            trDownload.appendChild(tdDownloadText);

            var trDetail = document.createElement('tr');
            var tdDetailHeading = document.createElement('td');
            tdDetailHeading.innerHTML = '<b>VALUE RANGE:</b>';
            var tdDetailText = document.createElement('td');
            tdDetailText.innerHTML = res.value_range;
            trDetail.appendChild(tdDetailHeading);
            trDetail.appendChild(tdDetailText);

            var trResources = document.createElement('tr');
            var tdResourcesHeading = document.createElement('td');
            tdResourcesHeading.innerHTML = '<b>HIGHEST CLASSIFICATION:</b>';
            var tdResourcesText = document.createElement('td');
            tdResourcesText.innerHTML = res.class_level;
            trResources.appendChild(tdResourcesHeading);
            trResources.appendChild(tdResourcesText);

            var trCPQP = document.createElement('tr');
            var tdCPQPHeading = document.createElement('td');
            tdCPQPHeading.innerHTML = '<b>SUMMARY:</b>';
            var tdCPQPText = document.createElement('td');
            tdCPQPText.innerHTML = res.transaction_summary;
            trCPQP.appendChild(tdCPQPHeading);
            trCPQP.appendChild(tdCPQPText);

            var trAuthor = document.createElement('tr');
            var trAuthorHeading = document.createElement('td');
            trAuthorHeading.innerHTML = '<b>AUTHOR:</b>';
            var tdAuthorText = document.createElement('td');
            tdAuthorText.innerHTML = res.author_aff;
            trAuthor.appendChild(trAuthorHeading);
            trAuthor.appendChild(tdAuthorText);


            var reviewLink;

            if (res.review_submitted) {
                $('#review-report-id').val(res.id);
                $('#history-review').val('True');
                var review_id = res.review_submitted;
                reviewLink = '<p>You have reviewed this report.</p>';
                reviewLink += '<a style="cursor: pointer;" href="#" report="' + res.id + '" class="btn-rsc" ';
                reviewLink += 'onclick="javascript:oReview.editReview(' + review_id + ');"  id="' + review_id + '-history-review">Edit Your Review</a>';
            } else {
                $('#review-report-id').val(res.id);
                reviewLink = '<a style="cursor: pointer;" href="#" report="' + res.id + '" class="btn-rsc" ';
                reviewLink += 'onclick="javascript:oRsc.reviewHistoryReport(this);"  id="' + res.id + '-history-review">Review This Report</a>';
            }

            var reviewLinkContainer = document.createElement('div');
            reviewLinkContainer.id = 'reviewLinkContainer_' + j;
            reviewLinkContainer.className = 'reviewLinkContainer_';
            reviewLinkContainer.style.textAlign = 'center';
            reviewLinkContainer.style.padding = '9px 5px';

            reviewLinkContainer.innerHTML = reviewLink;

            tBody.appendChild(trDownload);
            tBody.appendChild(trDetail);
            tBody.appendChild(trResources);
            tBody.appendChild(trCPQP);
            tBody.appendChild(trAuthor);
            table.appendChild(tBody);

            containerText.appendChild(table);
            /*Todo: RSC-MI taking parts down*/
            /*containerText.appendChild(reviewLinkContainer);*/

        });

        $(".tab_").css("display", "none");
        $(".reviewLinkContainer_").css("display", "none");

    },

    showRelatedContent: function (e) {

        str = e.id;
        var id = str.replace("row_", "tab_");
        var linkId = str.replace("row_", "reviewLinkContainer_");

        $(".history_type_cont").removeClass('bg_color');
        $("#" + str).addClass('bg_color');

        $(".tab_").css("display", "none");
        $("#" + id).css("display", "block");
        $(".reviewLinkContainer_").css("display", "none");
        $("#" + linkId).css("display", "block");

    },

    markerColor: function (f) {
        f.properties["marker-color"] = "#505050";
        if (f.properties["status"] == 'Updated') {
            f.properties["marker-color"] = "#1F51A4";
        }
        if (f.properties["status"] == 'Maiden') {
            f.properties["marker-color"] = "#F76200";
        }
        if (f.properties["status"] == 'Upgraded') {
            f.properties["marker-color"] = "#009273";
        }
        if (f.properties["status"] == 'Not Defined') {
            f.properties["marker-color"] = "#808080";
        }
        return true;
    },

    padLeft: function (nr, n, str) {
        return Array(n - String(nr).length + 1).join(str || '0') + nr;
    },

    selectRegion: function (sender) {
        var regs = ['world', 'seabed-resources', 'reviewed-reports', 'trans-reports', 'new-resource', 'exploration', 'reserve'];
        for (var i = 0; i < regs.length; i++) {
            var reg = regs[i];
            if ('region-button-' + reg != sender.attr('id')) {
                $('#region-button-' + reg).removeClass().addClass('region-button region-button-off');
            } else {
                $('#region-button-' + reg).removeClass().addClass('region-button region-button-on');
            }
        }

        if (sender.attr('id') == 'region-button-seabed-resources') {
            $('#show-all').prop('checked', false);
            $("#project-stage-group").hide(100);
            $("#report-location-accuracy").hide(100);
            $("#transaction-type-group").hide(100);
            $("#resources-type-group").show(100);
            $("#report-type-group").show(100);
            $("#report-code-group").show(100);
            $("#reserves-type-group").show(100);
            $("#region-button-custom-reporting").show(100);
            $("#type-exploration-update").prop('checked', true);
            $("#type-Scoping-Study-and-pea").prop('checked', true);
            $("#type-pre-feasibility").prop('checked', true);
            $("#type-feasibility").prop('checked', true);
            $('#report-type-format').show(100);
            $("#type-eia-esia").prop('checked', true);
            $("#type-optimisation-study").prop('checked', true);
            $("#type-supporting-acquisition").prop('checked', true);
            $("#type-resource-estimation").prop('checked', true);

            $("#uncheck-all-types").prop('checked', true);
            $("#uncheck-all-resources").prop('checked', true);

            $("#resource-maiden").prop('checked', true);
            $("#resource-upgraded").prop('checked', true);
            $("#resource-updated-resources").prop('checked', true);
            $("#resource-unchanged").prop('checked', true);
            $("#resource-not-defined").prop('checked', true);

            $("#uncheck-all-reserves").prop('checked', true);
            $("#reserves-maiden").prop('checked', true);
            $("#reserves-upgraded").prop('checked', true);
            $("#reserves-updated").prop('checked', true);
            $("#reserves-unchanged").prop('checked', true);
            $("#reserves-not-defined").prop('checked', true);
            $('#report-value_range').css('display', 'none');
            $('.topfilters').css('display', 'block');
            $('#reserve-all-div').hide();
            $('#reserves-type-group label .expander').removeClass('expanded').addClass('collapsed');
            geoJson = [];
            this.runFilter();
        }

        if (sender.attr('id') == 'region-button-new-resource') {
            $('#show-all').prop('checked', false);
            $("#project-stage-group").hide(100);
            $("#report-location-accuracy").hide(100);
            $("#region-button-custom-reporting").show(100);
            $("#transaction-type-group").hide(100);
            $("#resources-type-group").show(100);
            $("#report-type-group").show(100);
            $('#report-type-format').show(100);
            $("#report-code-group").show(100);
            $("#reserves-type-group").show(100);
            $("#uncheck-all-types").prop('checked', true);
            $("#type-exploration-update").prop('checked', true);
            $("#type-resource-estimation").prop('checked', true);
            $("#type-Scoping-Study-and-pea").prop('checked', true);
            $("#type-pre-feasibility").prop('checked', true);
            $("#type-feasibility").prop('checked', true);
            $("#type-eia-esia").prop('checked', true);
            $("#type-optimisation-study").prop('checked', true);
            $("#type-supporting-acquisition").prop('checked', true);

            $("#uncheck-all-resources").prop('checked', false);
            $("#resource-maiden").prop('checked', true);
            $("#resource-upgraded").prop('checked', true);
            $("#resource-updated-resources").prop('checked', true);
            $("#resource-unchanged").prop('checked', false);
            $("#resource-not-defined").prop('checked', false);

            $("#uncheck-all-reserves").prop('checked', true);
            $("#reserves-maiden").prop('checked', true);
            $("#reserves-upgraded").prop('checked', true);
            $("#reserves-updated").prop('checked', true);
            $("#reserves-unchanged").prop('checked', true);
            $("#reserves-not-defined").prop('checked', true);
            $('#report-value_range').css('display', 'none');
            $('.topfilters').css('display', 'block');

            $('#reserve-all-div').show();
            $('#reserves-type-group label .expander').removeClass('expanded').addClass('collapsed');
            geoJson = [];
            this.runFilter();
        }

        if (sender.attr('id') == 'region-button-exploration') {
            $('#show-all').prop('checked', false);
            $("#project-stage-group").hide(100);
            $("#report-location-accuracy").hide(100);
            $("#transaction-type-group").hide(100);
            $("#resources-type-group").show(100);
            $("#report-type-group").show(100);
            $("#report-code-group").show(100);
            $('#report-type-format').show(100);
            $("#reserves-type-group").show(100);
            $("#region-button-custom-reporting").show(100);
            $("#uncheck-all-resources").prop('checked', true);
            $("#resource-maiden").prop('checked', true);
            $("#resource-upgraded").prop('checked', true);
            $("#resource-updated-resources").prop('checked', true);
            $("#resource-unchanged").prop('checked', true);
            $("#resource-not-defined").prop('checked', true);

            $("#uncheck-all-types").prop('checked', false);
            $("#type-exploration-update").prop('checked', true);
            $("#type-resource-estimation").prop('checked', false);
            $("#type-Scoping-Study-and-pea").prop('checked', false);
            $("#type-pre-feasibility").prop('checked', false);
            $("#type-feasibility").prop('checked', false);
            $("#type-eia-esia").prop('checked', false);
            $("#type-optimisation-study").prop('checked', false);
            $("#type-supporting-acquisition").prop('checked', false);

            $("#uncheck-all-reserves").prop('checked', true);
            $("#reserves-maiden").prop('checked', true);
            $("#reserves-upgraded").prop('checked', true);
            $("#reserves-updated").prop('checked', true);
            $("#reserves-unchanged").prop('checked', true);
            $("#reserves-not-defined").prop('checked', true);
            $('#report-value_range').css('display', 'none');
            $('.topfilters').css('display', 'block');


            $('#reserve-all-div').show();
            $('#report-type-group label .expander').removeClass('collapsed').addClass('expanded');
            geoJson = [];
            this.runFilter();
        }

        if (sender.attr('id') == 'region-button-reserve') {
            $('#show-all').prop('checked', false);
            $("#report-location-accuracy").hide(100);
            $("#project-stage-group").hide(100);
            $('#report-type-format').show(100);
            $("#transaction-type-group").hide(100);
            $("#resources-type-group").show(100);
            $("#report-type-group").show(100);
            $("#report-code-group").show(100);
            $("#reserves-type-group").show(100);
            $("#region-button-custom-reporting").show(100);
            $("#uncheck-all-resources").prop('checked', true);
            $("#resource-maiden").prop('checked', true);
            $("#resource-upgraded").prop('checked', true);
            $("#resource-updated-resources").prop('checked', true);
            $("#resource-unchanged").prop('checked', true);
            $("#resource-not-defined").prop('checked', true);

            $("#uncheck-all-types").prop('checked', true);
            $("#type-exploration-update").prop('checked', true);
            $("#type-resource-estimation").prop('checked', true);
            $("#type-Scoping-Study-and-pea").prop('checked', true);
            $("#type-pre-feasibility").prop('checked', true);
            $("#type-feasibility").prop('checked', true);
            $("#type-eia-esia").prop('checked', true);
            $("#type-optimisation-study").prop('checked', true);
            $("#type-supporting-acquisition").prop('checked', true);

            $("#uncheck-all-reserves").prop('checked', false);
            $("#reserves-maiden").prop('checked', true);
            $("#reserves-upgraded").prop('checked', true);
            $("#reserves-updated").prop('checked', true);
            $("#reserves-unchanged").prop('checked', false);
            $("#reserves-not-defined").prop('checked', false);
            $('#report-value_range').css('display', 'none');

            $('.topfilters').css('display', 'block');
            $('#reserve-all-div').show();
            //$('#reserves-type-group label .expander').removeClass('collapsed').addClass('expanded');
            geoJson = [];
            this.runFilter();
        }

        if (sender.attr('id') == 'region-button-trans-reports') {
            //if user is logged in then run trans mode otherwise load message to register first
            if (jQuery('body').hasClass('logged-in')) {
                //if user is logged in and plan is 2 or 3 then run trans mode otherwise load message to upgrade plan
                if (oRsc.userPlan == 'Plan2' || oRsc.userPlan == 'Plan3') {
                    oRsc.runTransfilters();
                } else if (oRsc.userPlan == 'Plan1') {
                    oRsc.loadUpgradeplan('plan1');
                } else {
                    oRsc.loadUpgradeplan('null');
                }
            }
            //Load message to register first
            else {
                $.cookie("isTrans", "true");
                $('#region-button-trans-reports').removeClass().addClass('region-button region-button-off');
                // if($('.Tooltip-header').is(':visible')){
                //     $('.Tooltip-trans-header').hide();
                //     return
                // }
                $('.trans-box-image').empty();
                // $('.trans-box-image').append('<img id="trans-screenshot" src="/wp-content/themes/fount/intel/images/trans-reports.png" alt="Not found"/>');
                $('#trans-modal').modal('show');

                return
            }
        }

        if (sender.attr('id') == 'region-button-world' || sender.attr('id') == 'region-button-world-sidebar') {

            oRsc.clearFilters = false;
            //$('#clear_filters').css('display', 'none');
            $('.sidebar-form-below-div2').css('height', 'unset');
            $('#region-button-world').removeClass().addClass('region-button region-button-on');
            $('#region-button-world-sidebar').removeClass().addClass('region-button region-button-on');
            $('#transaction-main-div').css('top', '228px');
            $("#project-stage-group").hide();
            $("#proj_status").show();
            $("#report-location-accuracy").hide();
            $("#region-button-custom-reporting").show();
            $("#transaction-type-group").hide();
            $('#stock-exchange').show();
            $("#resources-type-group").show();
            $('#report-type-format').show();
            $("#report-type-group").show();
            $("#report-code-group").show();
            $("#reserves-type-group").show();
            $('#bottom-share-links').css('display', 'block');
            $('#report-value_range').css('display', 'none');
            $('#legend-content-report').css('display', 'none');
            $('#legend-content-tech').css('display', 'block');
            $('.toggle-layer-pdfdownloads').css('display', 'none');
            $('#selectMe').find('option:eq(5)').hide();
            $('#selectMe').find('option:eq(4)').show();
            $('#reserve-all-div').hide();
            //$('.content').css('display', 'none');
            //$('#reserves-type-group label .expander').removeClass('expanded').addClass('collapsed');
            //var $sidebarGroup = $('.sidebar-group');
            //$sidebarGroup.find('label:first-child .expander').removeClass('expanded').addClass('collapsed');
            // $('.topfilters').css('display', 'block');

            //remove report box from sidebar
            $("#reportbox_popup").remove();
            $('#filters').css('display', 'block');
            $('#report_box').css('border', '');
            $('.sidebar-group p').css('display', 'block');

            if (!jQuery('body').hasClass('logged-in') || oRsc.userPlan == 'Plan1') {
                $('span#commodity-g').addClass('filter-background');
            }

            geoJson = [];
            oRsc._exitSearch();
            oRsc.searchDropdown = false;
            oRsc.initSearch();
        }
    },
    setCenterToWorld: function (lat,lon,zoom) {
        this.map.setView(L.latLng(lat, lon), zoom);
        //-42.1875
        //28.92163128242129
        // this.map.setView(L.latLng(16.13026201203477,-42.1875),2);
    },

    searchCheckedValues: function () {
        return $('.chk-auto-complete:checked').map(function () {
            return this.value;
        }).get();
    },

    decimalFromSexagesimal: function (input) {
        var d1 = input.split("°");
        var degs = Number(d1[0].trim());
        var d2 = d1[1].split("'");
        var d3 = d2[1].split('"');
        var secs = Number(d3[0]) / 60;
        var mins = (Number(d2[0]) + secs) / 60;
        var val = mins + degs;
        if (d3[1] == 'S' || d3[1] == 'W') {
            val = val * -1;
        }
        return val;
    },

    getUrlParameter: function (sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    },
    runTransfilters: function () {
        $('#region-button-trans-reports').removeClass().addClass('region-button region-button-on');
        this.isTrans = true;
        oRsc.turnTransOn();
        var url = BASE_URL + '/signup';
        geoJson = [];
        oRsc._exitSearch();
        oRsc.initSearch();
        oRsc.searchDropdown = false;
        oRsc.clearFilters = false;
    },
    loadUpgradeplan: function (param) {
        $('#region-button-trans-reports').removeClass().addClass('region-button region-button-off');
        if (param == 'null') {
            setTimeout(function () {
                if (oRsc.userPlan == 'Plan1') {
                    $('#region-button-trans-reports').removeClass().addClass('region-button region-button-off');
                    $('#message-model p').text('Your current plan is restricted to Technical reports. Go to Manage profile to upgrade your plan and unlock Transaction reports.');
                    $('#message-model').modal('show');
                    return
                } else {
                    oRsc.runTransfilters();
                }
            }, 5000);
        } else {
            $('#region-button-trans-reports').removeClass().addClass('region-button region-button-off');
            $('#message-model p').text('Your current plan is restricted to Technical reports. Go to Manage profile to upgrade your plan and unlock Transaction reports.');
            $('#message-model').modal('show');
            return
        }
    },
    searchtoggleIcons: function (id) {

        var project;
        var deposit;

        $('#' + id).toggle(function () {
            var parent = $(this).parent().parent();
            parent = $(parent).attr('class');
            $('tr.' + parent).not(':first').hide();
            //$(this).text("+");
            $(this).removeClass('glyphicon glyphicon-minus-sign').addClass('glyphicon glyphicon-plus-sign');
            project = $('#multi-autocomplete tbody tr.' + parent).first().find("td:eq(3)").html();
            deposit = $('#multi-autocomplete tbody tr.' + parent).first().find("td:eq(4)").text();

            var prj_length = 0;
            // $('#multi-autocomplete tbody tr.' + parent).first().find("td:eq(3)").text('Multiple');
            $('#multi-autocomplete tbody tr.' + parent).find("td:eq(3) span").each(function () {
                num = parseInt($(this).text());
                prj_length += num;
            });
            $('#multi-autocomplete tbody tr.' + parent).first().find("td:eq(3)").text('Multiple(' + prj_length + ')');

        }, function () {

            var parent = $(this).parent().parent();
            //$(this).text("-");
            $(this).removeClass('glyphicon glyphicon-plus-sign').addClass('glyphicon glyphicon-minus-sign');
            parent = $(parent).attr('class');
            $('tr.' + parent).show();

            $('#multi-autocomplete tbody tr.' + parent).first().find("td:eq(3)").html(project);
            $('#multi-autocomplete tbody tr.' + parent).first().find("td:eq(4)").text(deposit);
        });
    },
    sortTable: function () {
        var table, rows, switching, i, x, y, shouldSwitch;
        table = document.getElementById("multi-autocomplete");
        rows = table.rows;
        for (i = 2; i < (rows.length - 1); i++) {
            x = rows[i].getElementsByTagName("TD")[1];
            addClasses(rows[i]);
            for (j = i + 1; j <= (rows.length - 1); j++) {
                y = rows[j].getElementsByTagName("TD")[1];
                addClasses(rows[j]);
                if ($(x).find('span').text() == $(y).find('span').text()) {
                    switchRows(rows[i], rows[j]);
                    i = i + 1;
                }
            }
        }


        function switchRows(row, row2) {
            $(row2).insertAfter(row);
        }

        function addClasses(row) {
            var element = row;
            var company = '';
            company = $(element).find('td:eq(1)').text();
            company = company.replace(/ /g, '');
            company = company.replace('&', 'and');
            company = company.replace(/[(),]/g,'-');
            company = company.split('.').join("");
            $(element).addClass(company);
            $(element).find('td:eq(1)').addClass(company);
        }
    },
};

function setmapZoom(zoom) {

    zoom = zoom || false;

    if(oRsc.isPreferencesActive == true && zoom == false)
        return;
    var width = document.documentElement.clientWidth;
    var map = $('#map').is(':visible');
    if (map == true) {
        if (width > 2500) {
            // set the zoom level to 3
            oRsc.mapforzoom.setZoom(3);
        } else {
            // set the zoom level to 2
            oRsc.mapforzoom.setZoom(2);
        }
    }
    if (width > 1300) {
        $('#user-name-header').css('display', 'block');
    }
}


$(document).on('closed', '.remodal', function (e) {
    // "confirmation", or "cancellation", or undefined

    if (e.reason == undefined) {
        //window.location.href = "http://www.rscmme.com/map-disclaimer";
    } else {
        $('[data-remodal-id=modal]').remove();
        $.cookie("splash", "false");
        //oRsc.overlayReports();
    }
});


$(document).ready(function () {
    $('#prk_menu_left_trigger').click(function () {
        $('.menu_at_top #prk_responsive_menu #menu_section .sf-menu>li:last-child').css('border-bottom', 'unset');
        $('#user-name-header').css('display', 'none');
    });
    $("#menu_section.unpad_right .sf-menu>li:nth-child(2)").click(function () {
        $('.menu_at_top #prk_responsive_menu #menu_section .sf-menu .sub-menu').css('display', 'none');
    });
    $("#menu_section.unpad_right .sf-menu>li:nth-child(3)").click(function () {
        $('.menu_at_top #prk_responsive_menu #menu_section .sf-menu .sub-menu').css('display', 'none');
    });
    // $("#legend-button").click(function(){
    //
    //     $("#toggle-layer-legend").toggleClass("legend-above-map-satellite");
    // });
    // $("#legend-neg-btn").click(function() {
    //     $("#toggle-layer-legend").toggleClass("legend-above-map-satellite");
    // });
});

// $(document).ready(function () {
//     $("#mail-to").click(function () {
//         $('#feedback-modal').modal('show');
//     });
//
//     //......................................terms of services link in Disclamier message
//     $('#showTermUse').click(function () {
//         // $('[data-remodal-id=terms-services-popup]').remodal().open();
//         $('#terms-services-popup').modal('show');
//     });
//
//     $('#tou_privacy-pol').click(function () {
//         // $('[data-remodal-id=privacyPopup]').remodal().open();
//         $('#privacyPopup').modal('show');
//     });
//
// });



