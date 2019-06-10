/*
 * jQuery UI Multi Column & Multi Value selection AutoComplete Widget Plugin 1.0
 * Copyright (c) 2015 Arslan Javaid
 *
 * Depends:
 *   - jQuery UI Autocomplete widget
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */
$.widget('custom.multiAutoComplete', $.ui.autocomplete, {
    _table: $('<table id="multi-autocomplete"></table>'),
    _selectedMarkersHighlight: [],
    _searchFlag: false,
    _errorNotFound: false,
    _searchFeatures: [],
    _create: function () {
        this._super();
        this.widget().menu("option", "items", "> :not(.ui-widget-header)");
    },
    _renderMenu: function (ul, items) {
        var self = this, thead, tbody, tr, trSelect, error;

        this._table.html('');
        if (this.options.showHeader) {
            thead = $('<thead class="ui-widget-header"></thead>');
            tr = $('<tr></tr>');
            // header Columns
            $.each(this.options.columns, function (index, item) {
                var headName = (item.name == 'ID') ? '' : item.name;
                tr.append('<th width="' + item.width + '">' + headName + '</th>');
            });
            thead.append(tr);
            this._table.append(thead);
        }
        // List items
        tbody = $('<tbody></tbody>');
        error = $('<p></p>');
        trSelect = self._selectAllItem();
        trSelect.click(function (event) {
            if (event.target.type !== 'checkbox') {
                $(':checkbox', this).trigger('click');
            }
        }).css('cursor', 'pointer');
        tbody.append(trSelect);
        // Reset Search geo Json
        this._searchFeatures = [];
        // List of search result
        $.each(items, function (index, item) {
            if (item.label == 'Error') {
                error.html(item.value);
                self._errorNotFound = true;
            } else {
                self._errorNotFound = false;
                ul.removeClass('error-not-found');
                tr = self._renderItem(ul, item);
                tr.click(function (event) {
                    if (event.target.type !== 'checkbox') {
                        $(':checkbox', this).trigger('click');
                    }
                }).css('cursor', 'pointer');
                tbody.append(tr);
            }
        });
        // Build GeoJson Layer
        this._searchFeatures = oRsc.getGeoJson();

        if (this._errorNotFound) {
            ul.html('');
            ul.addClass('error-not-found');
            ul.append(error);
        } else {
            this._table.append(tbody);
            ul.append(this._table);
            oRsc.search_first_column = false;

            //.............................................................................................sort the table column and groupcolumns according to the company and project
            if (oRsc.searchKey == 'company' || oRsc.searchKey == 'ticker' || oRsc.searchKey == 'project') {
                oRsc.sortTable();
                var prj = [];
                var prj_length;
                $.each($('#multi-autocomplete tbody tr'), function (index, column) {
                    if (index != 0) {
                        var company = $(this).find('td:eq(1)').attr('class');
                        $('tr.' + company).find('td:eq(1) span').not(':first').css('visibility', 'hidden');
                        var id = "plus-sign-search-dropdown" + company;
                        if ($('#' + id).length == 0) {
                            $('tr.' + company).first().find('td:eq(0)').append('<span href="#" class="show_hide-search-results glyphicon glyphicon-minus-sign" id=' + id + '></span>');
                            oRsc.searchtoggleIcons(id);
                        }
                        if ($.inArray($(this).find('td:eq(3)').text(), prj) >= 0) {
                                $(this).remove();
                                return;
                        }
                        var text = $(this).find('td:eq(3)').text();
                        var $prj_length = $('#multi-autocomplete tbody tr.' + company).filter(function () {
                            return $(this).find('td:eq(3)').text() == text;
                        });
                        prj.push($(this).find('td:eq(3)').text());
                        $(this).find('td:eq(3)').html(text + ' (<span class="prj_numbers">' + $prj_length.length + '</span>)');
                    }
                });
                switch (oRsc.searchKey) {
                    case 'company':
                        $('table#multi-autocomplete tbody tr td:nth-child(2)').css('font-weight','bold');
                        break;
                    case 'ticker':
                        $('table#multi-autocomplete tbody tr td:nth-child(3)').css('font-weight','bold');
                        break;
                    case 'project':
                        $('table#multi-autocomplete tbody tr td:nth-child(4)').css('font-weight','bold');
                        break;
                }
            }

        }

        var $search = $('#search'), $btnClose = $('.close-icon'), $rscSearchIcon = $('.rsc-search-icon');
        var ifFiltersActive = '<span class="if-Filters-Active">Search results are limited to gold reports.<a href="#" onclick="javascript:oRsc.searchentireDB();" class="search-entire-db" style="color: #2a6496;margin-left: 15px;">Search entire database</a></span>';
        var btnShow = $('<input type="button" id="btn-show-makers" name="btn-show-makers" value="Show on Map"   />');
        btnShow.click(function () {
            var checkedValues = oRsc._checkedValues();
            if (checkedValues.length == 0) {
                oRsc.searchDropdown = true;
                oRsc.featureLayer.removeLayer(oRsc.geoJsonLayer);
                error = 'Please select at least 1 report from the search results.';
                $('#pdf-modal span').html('');
                $('#pdf-modal p').html(error).css({'border': '1px solid #f00', padding: '5px'});
                $('#pdf-modal').modal('show');
                setTimeout(function () {
                    $('.ui-autocomplete').css('z-index', '1');
                    $('.ui-autocomplete').css('display', 'block');
                }, 1000);
                return false;
            } else {
                if (oRsc.searchKey == 'company') {
                    var text ;
                    if ($('.chk-auto-complete:checked').length == 1)
                        text = $('.chk-auto-complete:checked').parent().find('span').text();
                    else
                    var text = $('#multi-autocomplete tbody tr:nth-child(2)').find("td:eq(1)").text();
                    if (text.length > 24) {
                        text = text.substring(0, 24);
                        $('#search').val(text + '...');
                    } else {
                        $('#search').val(text);
                    }
                    oRsc.isSearchMarkersActivated = true;
                    $(':focus').blur();
                }
                if (oRsc.userPlan != 'Plan2' && oRsc.userPlan != 'Plan3') {
                    //$('.date-filter-background').addClass('date-filters').removeClass('date-filter-background');
                    //$('#all-reports').removeClass('date-filters').addClass('date-filter-background');
                    //$('a.date_filter').text('');
                    //$('#date_filter label').css('background', '#7B868C');
                }
                oRsc.searchDropdownonShowMap = true;
                oRsc.search_drop_open = true;
                $('.ui-autocomplete').css('display', 'none');
                var isDisplay = false;
                oRsc.c_reporting = false;
                self._showMarkers(isDisplay);
            }
        });
        var btnShow2 = $('<input type="button"  id="close-search-dropdown" class="close-search-dropdown" value="Cancel"   />');
        btnShow2.click(function () {
         // $(".uncheck-all").each(function() {
         //             $(this).prop('checked', true);
         //         });
         //         $(".rsc-select-all").each(function() {
         //             $(this).prop('checked', true);
         //         });
         //         $("input[type=text]").val('');

            if (oRsc.selectedFilters != '')
                oRsc.runDefaultFilters(oRsc.selectedFilters);
            else
                oRsc.setDefaultDate();

        // var isDisplay = true;
        // oRsc.c_reporting = false;
        //  self._showMarkers(isDisplay);
         oRsc.searchDropdown=false;
         $('.ui-autocomplete').css('display','none');
         $search.val('');
         $('#search').blur();
         $("#search-dropdown").hide();
         $btnClose.css('display', 'none');
         $rscSearchIcon.css('display', 'block');
        });

        if (!this._errorNotFound) {
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
            if (oRsc.userPlan != 'Plan2' && oRsc.userPlan != 'Plan3')
                ul.append(ifFiltersActive);
            ul.append(btnShow,btnShow2);
        }
    },
    _renderItem: function (ul, item) {
        // Build Search Popup
        var tr, td, unique, value, columnKey, self = this;
        tr = $('<tr></tr>');
        $.each(this.options.columns, function (index, column) {
            columnKey = oRsc._lookup[column.valueField];
            value = item[columnKey ? columnKey : index];
            if (index == 0 || column.valueField == 'id') {
                if (oRsc.searchKey == 'company' || oRsc.searchKey == 'ticker' || oRsc.searchKey == 'project') {
                    td = '<td width="' + column.width + '"></td>';
                } else {
                    unique = item[columnKey ? columnKey : 0];
                    td = '<td width="' + column.width + '"><input type="checkbox" class="chk-auto-complete" name="chk-auto-complete[]"  value="' + unique + '"></td>';
                }
            } else if (column.valueField == 'company' && (oRsc.searchKey == 'company' || oRsc.searchKey == 'ticker' || oRsc.searchKey == 'project')) {
                columnKey = oRsc._lookup['id'];
                unique = item[columnKey ? columnKey : 0];
                td = '<td width="' + column.width + '"  style="height: 44px;"><span>' + self._cleanString(value) + ' </span><input type="checkbox" class="chk-auto-complete company-chk-auto-complete"  name="chk-auto-complete[]" value="' + unique + '"></td>';
                oRsc.search_first_column = true;
            }
            // } else if (column.valueField == 'project' && (oRsc.searchKey == 'ticker' || oRsc.searchKey == 'project')) {
            //     columnKey = oRsc._lookup['id'];
            //     unique = item[columnKey ? columnKey : 0];
            //     td = '<td width="' + column.width + '"  style="font-weight: bold;height: 44px;">' + '<span>' + self._cleanString(value) + ' </span>' + '<input type="checkbox" class="chk-auto-complete company-chk-auto-complete"  name="chk-auto-complete[]" value="' + unique + '"></td>';
            //     oRsc.search_first_column = true;
            // } else {
            else {
                td = '<td width="' + column.width + '">' + self._cleanString(value) + '</td>';
            }
            tr.append(td);
        });

        var searchVal = $('#search').val();
        var ticker = $(tr).find('td:eq(2)').text();
        var company = $(tr).find('td:eq(1)').text().replace(/ /g, '');
        var project = $(tr).find('td:eq(3)').text().replace(/ /g, '');
        // searchVal = searchVal.split(":");
        // searchVal = searchVal[1];
        ticker = ticker.split(":");
        ticker = ticker[1];
        searchVal = searchVal.replace(/ /g, '');

        switch (oRsc.searchKey) {
            case 'ticker':
                ticker = ticker.replace(/ /g, '');
                if (ticker.toUpperCase() == searchVal.toUpperCase())
                    $(tr).find('input').attr('checked', true);
                break;
            case 'company':
                company = company.replace('.', '');
                if (company.toUpperCase() == searchVal.toUpperCase())
                    $(tr).find('input').attr('checked', true);
                break;
            case 'project':
                if (project.toUpperCase() == searchVal.toUpperCase())
                    $(tr).find('input').attr('checked', true);
                break;
            case 'Consultant':
                oRsc.searchKey = 'consultant';
                break;
        }
        return tr;
    },

    _cleanString: function (str) {
        if (str) {
            str = str.replace('[Resources]:', '');
            str = str.replace('[Overall Report]:', '');

            return str;
        }
        return "";
    },

    _selectAllItem: function () {
        var tr, td, self = this;
        tr = $('<tr></tr>');
        $.each(this.options.columns, function (index, column) {
            if (index == 0) {
                td = $('<td width="' + column.width + '"></td>')
                // td = $('<td width="' + column.width + '"><input type="checkbox" class="chk-select-all" id="chk-select-all"></td>');
                // td.click(function () {
                //     self._toggle();
                // });
            } else if (index == 1) {
                td = $('<td width="' + column.width + '"><span>Select All</span><input type="checkbox" class="chk-select-all" id="chk-select-all" style="float: right"></td>');
                td.click(function () {
                    self._toggle();
                });
                // td = '<td width="' + column.width + '">Select All<input type="checkbox" class="chk-select-all" id="chk-select-all"></td>';
                // $('#chk-select-all').click(function(){
                //     self._toggle();
                // });
            } else
                td = '<td width="' + column.width + '"></td>';
            tr.append(td);
        });
        return tr;
    },

    _toggle: function () {
        if (document.getElementById('chk-select-all').checked) {
            $('.chk-auto-complete').each(function () { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"
            });
        } else {
            $('.chk-auto-complete').each(function () { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"
            });
        }
    },

    _showMarkers: function (isDisplay) {
        // Remove Existing Feature
        oRsc.featureLayer.removeLayer(oRsc.geoJsonSearch);
        // Display Search Only
        $('#search-results-only').css('display', 'block');

        var self = this;
        this._selectedMarkersHighlight = [];

        if (!this._searchFlag) {
            this._searchFlag = true;
            oRsc.searchEnabled = true;

            var clearSearch = $('.close-icon');
            clearSearch.click(function () {
                oRsc._exitSearch();
            });
        }

        var checkedValues = oRsc._checkedValues();
        $.each(checkedValues, function (index, val) {
            self._addGeoJson(val);
        });

        // Add Selected\
        oRsc.geoSearchJson = this._selectedMarkersHighlight;
        if (isDisplay == true) {
            this.drawFeatures();
        } else {
            // Hide Search Only
            $('#search-results-only').css('display', 'none');
            oRsc.searchOnly();


        }

        //Hide
        $('.ui-autocomplete').hide();
    },

    _addGeoJson: function (val) {
        var self = this;
        $.each(this._searchFeatures, function (index, json) {
            if (json.id == val) {
                self._selectedMarkersHighlight.push(json);
            }
        });
    },

    // selectAllFilter: function () {
    //     $("#show-all").prop('checked', true);
    //     $(".uncheck-all").each(function () {
    //         $(this).prop('checked', true);
    //     });
    //     $(".rsc-select-all").each(function () {
    //         $(this).prop('checked', true);
    //     });
    //     $("input.rsc-text").val('');
    // },

    drawFeatures: function () {
        oRsc.geoJsonSearch = L.geoJson(oRsc.geoSearchJson, {
            pointToLayer: function (feature, latlng) {
                return L.circleMarker(latlng, {
                    radius: 12,
                    fillColor: "#ffff00",
                    color: "#ffff00",
                    weight: 1,
                    opacity: 1,
                    fillOpacity: 0.8
                });
            }
        });

        oRsc.featureLayer.addLayer(oRsc.geoJsonSearch);
        //oRsc.map.fitBounds(oRsc.geoJsonSearch.getBounds());

        if (oRsc.map.getZoom() > 9) oRsc.map.setZoom(9);

    }
});
