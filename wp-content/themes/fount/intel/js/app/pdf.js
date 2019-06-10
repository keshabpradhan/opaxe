var oPdf = {
    curr_bulletin_report: 0,
    weekly_bulletin_reports: '',
    pdf_url: '',
    pdf_temporary_url: '',
    nonGoldmarker: false,

    init: function () {
        $('#request-user').val($('#user-name').text());
        var report = oRsc.selectedReport;
        this.checkIsValid(report);
    },

    viewHistoryReportPDF: function (report) {
        var reportObJ = {
            url_name: $(report).attr('url_name'),
            pdf_link: $(report).attr('pdf_link'),
            company: $(report).attr('company')
        };

        //Display popup
        this.checkIsValid(reportObJ);

    },
    checkIsValid: function (report) {
        var self = this;
        var RegionButton = $('.region-button-on').text();
        var sone = [];
        sone['action'] = 'pdf download';
        sone['action_log'] = "report Downloaded";
        sone['report-id'] = $(report).attr('id');
        sone['mode'] = $('.region-button-on').text();
        oRsc.activity_log(sone);
        if (" Transaction Reports" == RegionButton) {

            $.ajax({
                url: "/wp-content/themes/fount/intel/lib/all.php?action=countMap",
                type: "post",
                dataType: "json",
                data: {
                    id: $(report).attr('url_name'),
                    reportId: $(report).attr('id')
                },
                success: function (response) {
                    oRsc.userMembershipLevels();
                    // this is the change
                    var success_msg = (response.success);
                    if (success_msg) {
                        var result = (response.reports);
                        if ((result.status) == "N") {
                            $("#region-button-trans-reports").hide();
                            location.reload();

                        }
                        else {
                            limit = response.reports.max_download_limit;
                            if (limit == "999999999999999999") {
                                limit = "unlimited"
                            }
                            $("#quota-details").html("User quota " + response.reports.currentPdfDownload + "/" + limit);

                            $("#region-button-trans-reports").show();
                        }
                        self.pdf(report);
                    } else {
                        self.pdf(report);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(textStatus, errorThrown);
                    self.pdf(report);
                }
            });
        } else {
            self.pdf(report);
        }
    },
    pdf: function (report) {
        var $reportPDF,
            url_name = report.url_name;
        //Add Google Analytics Events
        this.viewReportGA(url_name);

        var width = $(window).width();
        if (width < 768) {
          $('#prk_menu_els,.map-header-mobile.show-below-768px').hide();
            var height = window.innerHeight-50;
            var heightIframe = height - 10;
        }
        else {
            var height = window.innerHeight - 148;
            var heightIframe = height - 50;
            // $('#bottom-share-links').addClass('right-share-links');
        }
        $('#report-pdf-modal .modal-body').css({height: height + "px"});
        var url = BASE_URL + '/intel/' + url_name;

        var email_content = 'Hi%2c';
        email_content += ' I thought you might be interested in the following report: ';
        email_content += BASE_URL + '/intel/weekly-bulletin-' + report.url_name;

        var pdfText = "mailto:?subject=I thought you might be interested in a report on opaxe.com&body=" + email_content;
        $("#sendPdfMail").attr("href", pdfText);
        $reportPDF = $('#report-pdf-url');
        $reportPDF.val(url);
        $reportPDF.attr("url_name", url_name);
        if(($('.region-button-on').text().indexOf('Transaction') >= 0))
            $('#pdf-iframe').html("<iframe id='pdfViewerIframe' src ='/wp-content/themes/fount/intel/js/web/viewer.html?file=/" + report.pdf_link + "&url_name=" + url_name + "' style='width: 100%;height: -webkit-fill-available;' allowfullscreen ></iframe>");
        else
           $('#pdf-iframe').html("<iframe id='pdfViewerIframe' src ='/wp-content/themes/fount/intel/js/web/viewer.html?file=/" + report.pdf_link + "&url_name=" + url_name + "' style='width: 100%;' allowfullscreen ></iframe>");

        $('#report-pdf-h4').html(report.company);

        $('#report-pdf-modal').modal('show');
        $('#report-pdf-modal button.close').attr('onclick', 'oPdf.replaceUrl();');
        if(($('.region-button-on').text().indexOf('Transaction') == -1))
        $('#pdfViewerIframe').css('height', heightIframe);
        $('#report-pdf-modal').addClass('tec-trans-pdf');
        $('a.next-report, a.previous-report').css('display', 'none');
        $('meta[property="og:url"]').attr('content', url);
        var linkedin_href = "https://www.linkedin.com/shareArticle?mini=true&url="+ url + "&title=Opaxe%20Resource%20Reporting%20Intelligence&summary=My%20favorite%20opaxe%20Report&source=LinkedIn"
        var twitter_href = "https://twitter.com/share?url=" + url + "&amp;text=Opaxe%20Resource%20Reporting%20Intelligence&amp;hashtags=opaxe";
        $('.linkedin-share-link').attr('href', linkedin_href);
        $('.twitter-share-link').attr('href', twitter_href);
    },

    sendMail: function () {
        var fields = {
            url: $('#report-pdf-url').val(),
            email: $('#pdf-email').val()
        };
        var url = SCRIPT_PATH + '?action=sendPDFLink';
        var that = this;
        // Disable submit button
        $('#btn-email-pdf').prop('disabled', true);
        $(".processing img").show();
        $.post(url, fields, function (response) {
            if (response.success) {


                // Show Thanku popup
                var text = 'Thank you for subscribing to the opaxe Resource Reporting Intelligence. A confirmation is sent to your email.';
                $('#subscribe-thankyou-modal p').html(text);
                $('#subscribe-thankyou-modal').modal('show');
                setTimeout(function () {
                    $('#subscribe-thankyou-modal').modal('hide');
                }, 7000);
            } else {
                // Todo: Display error msg
            }
            that.cancelMail();
        }, 'json');

    },

    cancelMail: function () {
        $('#email-pdf-modal').modal('hide');
        // Disable submit button
        $('#btn-email-pdf').prop('disabled', false);
        $(".processing img").hide();
    },

    copy: function () {
        oPdf.copyReportGA();
        var copyText = document.querySelector('#report-pdf-url');
        copyText.select();
        try {
            var successful = document.execCommand('copy');
            var msg = successful ? 'successful' : 'unsuccessful';
            if (msg == 'successful') {
                //Add Google Analytics Events
                this.copyReportGA(oRsc.selectedReport.url_name);

                $('#link-pdf-modal').modal('show');
                setTimeout(function () {
                    $('#link-pdf-modal').modal('hide');
                }, 3000);
            } else {
                this.CopyToClipboard();
            }
            var report = oRsc.selectedReport;
            console.log('Copying text command was ' + msg);
            var sone = [];
            sone['action'] = 'Copy Link';
            sone['action_log'] = "Link Copied";
            sone['report-id'] = $(report).attr('id');
            sone['mode'] = $('.region-button-on').text();
            oRsc.activity_log(sone);
        } catch (err) {
            this.CopyToClipboard();
            console.log('Oops, unable to copy');
        }
    },

    CopyToClipboard: function () {
        var text = document.getElementById('report-pdf-url').value;
        window.prompt("Copy to clipboard: Ctrl+C, Enter", text);
    },

    viewReportGA: function (url_name) {
        ga('send', {
            hitType: 'event',
            eventCategory: 'Intel',
            eventAction: 'View Report',
            eventLabel: url_name
        });
    },

    copyReportGA: function (url_name) {
        ga('send', {
            hitType: 'event',
            eventCategory: 'Intel',
            eventAction: 'Copy Link',
            eventLabel: url_name
        });
    },

    emailReportGA: function () {
        var url_name = document.getElementById('report-pdf-url').value;
        url_name = $('#report-pdf-url').attr("url_name");
        ga('send', {
            hitType: 'event',
            eventCategory: 'Intel',
            eventAction: 'Email Link',
            eventLabel: url_name
        });
        var report = oRsc.selectedReport;
        // console.log('Copying text command was ' + msg);
        var sone = [];
        sone['action'] = 'Email Link';
        sone['action_log'] = "Mailing";
        sone['report-id'] = $(report).attr('id');
        sone['mode'] = $('.region-button-on').text();

        oRsc.activity_log(sone);
    },
    confirmDownload: function (id) {
        var invalid = false;
        $('#region-button-world').removeClass().addClass('region-button region-button-off');
        $(oRsc.reportIds).each(function () {
            if (this.reportId == id) {
                oPdf.init();
                invalid = true;
            }
        });
        if (invalid)
            return;
        var RegionButton = $('.region-button-on').text();
        if (" Transaction Reports" == RegionButton) {
            if ( oRsc.weeklyDownloads >= 10 || oRsc.dailyDownloads >= 3 && oRsc.CurrentUser.Email != 'r.sterk@rscmme.com' && oRsc.CurrentUser.Email !=  'nick@opaxe.com') {
                $('#pdf-limit-notifier').modal('show');
                return;
            }
            else {
                $('#download-confirmation').modal('show');
            }
        }
    },
    viewReportonLoad: function (pdf_name) {
        var rep = pdf_name.split('-');
        if (rep[0] == 'weekly' && rep[1] == 'bulletin') {
            var trim_url = pdf_name.replace('weekly-bulletin-', '');
            oPdf.weeklyBulletin(trim_url);
            localStorage.setItem("pdf_Url", '');
            return;
        }
        var url = SCRIPT_PATH + "?action=getReportByURLName";
        var fields = {url_name: pdf_name};
        $.post(url, fields, function (response) {
            var res = JSON.parse(response);
            if (res.success) {
                if (res.reports) {
                    var data = res.reports[0];
                    oPdf.showSidebarreport(data.id);
                    if ((!jQuery('body').hasClass('logged-in') || oRsc.userPlan == 'Plan1') && (data.commodities.indexOf("Gold") >= 0)) {
                        oPdf.pdf(data);
                    }
                    else if (oRsc.userPlan == 'Plan2') {
                        oPdf.pdf(data);
                    }
                    else {
                        var pdf_url = localStorage.getItem("pdf_Url");
                        localStorage.setItem("pdf_temporary_Url", pdf_url);
                    }
                    localStorage.setItem("pdf_Url", '');
                }
            }
            else {
                $('#message-model p').text('There is no report corresponding to this link');
                $('#message-model .btn').attr('onclick', 'oPdf.replaceUrl();');
                $('#message-model').modal('show');
                localStorage.setItem("pdf_Url", '');
                localStorage.setItem("pdf_temporary_Url", '');
            }
        });
    },
    showSidebarreport: function (id) {
        i = 0;
        var interval = setInterval(function () {
            if ($('.marker-id-' + id).is(':visible')) {
                oPdf.nonGoldmarker = true;
                $('.marker-id-' + id).trigger('click');
                $('#report-pdf-modal button.close').attr('onclick', 'oPdf.replaceUrl();');
                clearInterval(interval);
            }
            else {
                i += 1;
                if (i > 50) {
                    clearInterval(interval);
                }
            }
        }, 500);
    },
    replaceUrl: function (pdf_name) {
        var clean_uri = location.protocol + "//" + location.host;
        window.history.replaceState({}, document.title, clean_uri);
        if($(window).width() < 768)
        $('#prk_menu_els,.map-header-mobile.show-below-768px').show();
        else
        $('#prk_menu_els').show();
    },
    weeklyBulletin: function (pdf_name) {
        var url = SCRIPT_PATH + "?action=getWeeklyReports";
        $.post(url, function (response) {
            var res = JSON.parse(response);
            if (res.success) {
                oPdf.weekly_bulletin_reports = res.reports;
                if (pdf_name) {
                    var flag = false;
                    $.each(res.reports, function (index, val) {
                        if (val.url_name == pdf_name) {
                            oPdf.curr_bulletin_report = index;
                            flag = true;
                        }
                    });
                    if (flag) {
                        oPdf.showweeklyBulletin();
                    }
                    else {
                        $('#message-model p').text('There is no report corresponding to this link');
                        $('#message-model .btn').attr('onclick', 'oPdf.replaceUrl();');
                        $('#message-model').modal('show');
                    }
                }
                else {
                    oPdf.showweeklyBulletin();
                }
            }
        });
    },

    showweeklyBulletin: function () {
        report = oPdf.weekly_bulletin_reports[oPdf.curr_bulletin_report];
        var $reportPDF;
        var year = report.date.split('-');
        year = year[0];
        url_name = year + '/' + report.pdf_link;
        //Add Google Analytics Events
        oPdf.viewReportGA(url_name);
        var width = $(window).width();
        if (width < 768) {
          $('#prk_menu_els,.map-header-mobile.show-below-768px').hide();
            var height = window.innerHeight-50;
            var heightIframe = height-10;
        }
        else {
            var height = window.innerHeight - 110;
            var heightIframe = height - 80;
        }
        $('#report-pdf-modal .modal-body').css({height: height + "px"});
        var url = BASE_URL + '/intel/weekly-bulletin-' + report.url_name;
        var email_content = 'Hi%2c';
        email_content += ' I thought you might be interested in the following report: ';
        email_content += BASE_URL + '/intel/weekly-bulletin-' + report.url_name;
        var pdfText = "mailto:?subject=I thought you might be interested in a report on opaxe.com&body=" + email_content;
        $("#sendPdfMail").attr("href", pdfText);
        $reportPDF = $('#report-pdf-url');
        $reportPDF.val(url);
        $reportPDF.attr("url_name", url_name);
        $('#pdf-iframe').html('<iframe id="pdfViewerIframe" src ='+ BASE_URL +"/wp-content/plugins/pdf-viewer/stable/web/viewer.html?file=" + BASE_URL + "/wp-content/pdf/weekly/" + url_name + " style='width: 100%;' allowfullscreen ></iframe>");
        $('#report-pdf-h4').html('Weekly Bulletins');
        $('#report-pdf-modal').modal('show');
        $('#pdfViewerIframe').css('height', heightIframe);
        $('#report-pdf-modal').removeClass('tec-trans-pdf');
        $('#report-pdf-modal button.close').attr('onclick', 'oPdf.replaceUrl();');
        if (oPdf.curr_bulletin_report == 0) {
            oPdf.showrelatedButtons('previous-report', 'inline-block');
        }
        else {
            oPdf.showrelatedButtons('next-report', 'inline-block');
            oPdf.showrelatedButtons('previous-report', 'inline-block');
        }
        var linkedin_href = BASE_URL + "/intel/weekly-bulletin-"+report.url_name;
        linkedin_href = "https://www.linkedin.com/shareArticle?mini=true&url="+ linkedin_href + "&title=Opaxe%20Resource%20Reporting%20Intelligence&summary=My%20favorite%20opaxe%20Report&source=LinkedIn";
        var twitter_href = "https://twitter.com/share?url=" + BASE_URL + "/intel/weekly-bulletin-" + report.url_name + "&amp;text=Opaxe%20Resource%20Reporting%20Intelligence&amp;hashtags=opaxe";
        $('meta[property="og:url"]').attr('content', BASE_URL + "/intel/weekly-bulletin-" + report.url_name);
        $('.linkedin-share-link').attr('href', linkedin_href);
        $('.twitter-share-link').attr('href', twitter_href);
        $('#bottom-share-links').removeClass('right-share-links');
    },

    showrelatedButtons: function (cls, prop) {
        var width = $(window).width();
        if (width < 768) {
            $('a.' + cls + '.mobile-version').css('display', prop);
        }
        else {
            $('a.' + cls + '.desktop-version').css('display', prop);
        }
    },

    nextBulletin: function () {
        if (oPdf.curr_bulletin_report >= 1) {
            oPdf.curr_bulletin_report -= 1;
            oPdf.showweeklyBulletin();
            oPdf.showrelatedButtons('previous-report', 'inline-block');
            if (oPdf.curr_bulletin_report == 0)
                oPdf.showrelatedButtons('next-report', 'none');
        }
    },

    prevBulletin: function () {
        if (oPdf.curr_bulletin_report < (oPdf.weekly_bulletin_reports.length - 1)) {
            oPdf.curr_bulletin_report += 1;
            oPdf.showweeklyBulletin();
            oPdf.showrelatedButtons('next-report', 'inline-block');
        }
        else {
            oPdf.showrelatedButtons('previous-report', 'none');
            $('#message-model p').html('Please contact <a href="mailto:intel@rscmme.com?subject=Message against">intel@rscmme.com</a> if you are interested in any earlier weekly bulletins.');
            $('#message-model').modal('show');
        }
    },

    blockAcesstoReport: function () {
        if(($(window).width() < 768)){
            $('#report-pdf-links-warning-messages span').text('The report you are trying to access is available for registered users only. Please login or register for an account via a larger screen device.');
            $('.modal-footer.desktop-footer').hide();
            $('.modal-footer.mobile-footer').show();
        }
        else {
            $('.modal-footer.desktop-footer').show();
            $('.modal-footer.mobile-footer').hide();
        }
        $('#report-pdf-links-warning-messages').modal('show');
    },
    presentationMode: function () {
        var elem = document.getElementById('pdfViewerIframe');
            if (
                document.fullscreenEnabled ||
                document.webkitFullscreenEnabled ||
                document.mozFullScreenEnabled ||
                document.msFullscreenEnabled
            ) {
                if (
                    document.fullscreenElement ||
                    document.webkitFullscreenElement ||
                    document.mozFullScreenElement ||
                    document.msFullscreenElement
                ) {
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    } else if (document.webkitExitFullscreen) {
                        document.webkitExitFullscreen();
                    } else if (document.mozCancelFullScreen) {
                        document.mozCancelFullScreen();
                    } else if (document.msExitFullscreen) {
                        document.msExitFullscreen();
                    }
                } else {
                    if (elem.requestFullscreen) {
                        elem.requestFullscreen();
                    } else if (elem.webkitRequestFullscreen) {
                        elem.webkitRequestFullscreen();
                    } else if (elem.mozRequestFullScreen) {
                        elem.mozRequestFullScreen();
                    } else if (elem.msRequestFullscreen) {
                        elem.msRequestFullscreen();
                    }
                }
            } else {
                console.log('Fullscreen is not supported on your browser.');
            }
    },
    setDateperiod: function(from_date , to_date){

            $('#show-all-time').prop('checked', false);
            $('#from-date').datepicker('setDate', oPdf.getFormattedDate(new Date(from_date)));
            $('#to-date').datepicker('setDate', oPdf.getFormattedDate(new Date(to_date)));
            $('#show-all').prop('checked', false);
            $('#date_filter label p, #date_filter label span').addClass('expanded').removeClass('collapsed');
            $('#date_filter .content').show();
            oRsc.date_filter = true;
            $('#from-date').css('color', '');
            $('#to-date').css('color', '');

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
            oRsc.clearFilters = true;
                oRsc.runFilter();

 },
    getFormattedDate: function(date){
        date.setDate(date.getDate());
        var day = ("0" + date.getDate()).slice(-2);
        var month = ("0" + (date.getMonth() + 1)).slice(-2);
        var year = date.getFullYear()  + "-" + (month) + "-" + (day);
        var formatted_date = oRsc.getFormattedDate(year, 'M d, yy');
        return formatted_date;
    }
};
