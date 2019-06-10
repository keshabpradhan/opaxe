<?php
//get_header();
$url_name =get_query_var('value');
require_once('lib/lib.php');
$reports = getMetaDetail($url_name);
$meta_desc = isset($reports['meta_desc']) ? $reports['meta_desc'] : '';
$meta_tags = isset($reports['meta_tags']) ? $reports['meta_tags'] : '';

$company = isset($reports['company']) ? $reports['company'] : '';
$project = isset($reports['project']) ? $reports['project'] : '';
$type = isset($reports['type']) ? $reports['type'] : '';
$date = isset($reports['date']) ? $reports['date'] : '';
?>
<?php // get_header(); ?>
    <meta charset="UTF-8">
    <meta name="description" content="<?= $meta_desc ?>"/>
    <meta name="keywords" content="<?= $meta_tags ?>">
    <title><?php echo "$company: $project $type $date"; ?></title>
    <link href="http://www.rscmme.com/favicon.ico" type="image/x-icon" rel="shortcut icon">

    <!-- Load JQUERY -->
    <script src="<?php bloginfo('template_url'); ?>/intel/js/jquery.min.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/intel/js/jquery-migrate-1.0.0.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <!-- Load Roboto Condensed for Map -->
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>

    <!--Load JQUERY user interface JS + CSS, used on date picker -->
    <script src="<?php bloginfo('template_url'); ?>/intel/js/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/intel/css/jquery-uimin.css"/>

    <script src="<?php bloginfo('template_url'); ?>/intel/js/app.js?101"></script>
    <script src="<?php bloginfo('template_url'); ?>/intel/js/app/report.js"></script>

    <script src="<?php bloginfo('template_url'); ?>/intel/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/intel/css/bootstrap.min.css?109"/>
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/intel/css/dashboard.css?110"/>


    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/intel/css/site.css?109">
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/intel/css/custom.css?114">


    <!--<script src="js/star-rating.js" type="text/javascript"></script>-->
    <script src="<?php bloginfo('template_url'); ?>/intel/js/tabber-minimized.js" type="text/javascript"></script>
    <!--<link rel="stylesheet" href="css/star-rating.css" media="all" rel="stylesheet" type="text/css"/>-->
    <link href="<?php bloginfo('template_url'); ?>/intel/css/example.css" media="all" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        /*@font-face {
            font-family: Raleway;
            src: url(
        <?php bloginfo('template_url'); ?>
        /intel/css/fonts/Raleway-Regular.ttf);
        }

                html, body {margin: 0; height: 100%; font-family: sans-serif;}
                .main-nav ul li a span, .main-nav ul li a:visited span {
                font-family: 'Raleway', sans-serif;
                font-size: 14px;
                font-weight: normal;
                letter-spacing: normal;
        }

        .title-nav-wrapper {
                padding: 10px 82px 15px;
            color: #111111 !important;
        }

        .main-nav ul li {
            margin: 6px 0 0 17px;
        }
         .main-nav ul li a span:hover,  .main-nav ul li a span:focus {
            color: #1e51a4 !important;
        }

        .main-nav ul li ul li a span:hover, .main-nav ul li ul li a span:focus{
            color: white !important;
        }
         .main-nav ul li ul li:hover,  .main-nav ul li ul li:focus {
            display: block;
            -webkit-animation: INDENT 1s ease 0s 1 normal forwards;
        }
        */
        /*@-webkit-keyframes INDENT{
          0%   { text-indent: 0; }
          25% { text-indent: 4px; }
          50% { text-indent: 4px; }
          75% { text-indent: 4px; }
          100% { text-indent: 4px; }
        }

        .main-nav ul li ul li a span {
            font-family: 'Raleway', sans-serif;
              text-transform: uppercase !important;
        }

        #desktopNav .folder .folder-child-wrapper, .secondary-nav .folder .folder-child-wrapper {
            left: 80%;
        }
        #desktopNav .folder .folder-child-wrapper ul.folder-child li, .secondary-nav .folder .folder-child-wrapper ul.folder-child li {
                text-align: left;
            text-transform: uppercase;


        }
        #desktopNav .folder .folder-child-wrapper ul.folder-child li a, .secondary-nav .folder .folder-child-wrapper ul.folder-child li a {
               padding: 10px 3px;

        }
        #desktopNav .folder .folder-child-wrapper ul.folder-child li a span, .secondary-nav .folder .folder-child-wrapper ul.folder-child li a span{
            font-size: 13px !important;
            font-weight: normal;
            color: black;
        }
        */

        /* BOTTOM TO TOP Underline */
        /*.uline{
            display: inline-block;
            position: relative;

        }
        .uline:after {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 0;
            height: 0px;
            width: 100%;
            background: transparent;
            -webkit-transition: all ease 0.5s;
            -moz-transition: all ease 0.5s;
            transition: all ease 0.5s;
        }
        .uline:hover:after {
            height: 3px;
            background: #1e51a4;
        }*/
        /* BOTTOM TO TOP Underline */
        div#wrap {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        div#prk_footer_wrapper {
            display: none;
        }

        section#content-wrapper {
            display: none;
        }

        div#fount_ajax_back {
            display: none;
        }
    </style>
    <style type="text/css">
        html, body {
            margin: 0;
            height: 100%;
            font-family: sans-serif;
        }

        body {
            background-color: #fff !important;
            color: #384047;
        }

        /*tab 3*/
        #heading-text {
            margin: 0 0 0.5em;
            padding: 1em;
            color: #fff;
            font-size: 2.5em;
            letter-spacing: 0.3px;
        }

        #heading-container {
            width: 100%;
            height: 8em;
            color: #000000;
            background-color: #FC2020;
        }

        #table {
            width: 100%;
            text-align: left;
            margin-top: 10%
        }

        #table tr th {
            /*color: #f45601;*/
            color: red;
        }

        #table tr th, td {
            padding: 3px;
            text-align: left;
        }

        .report-map {
            bottom: 1050px !important;
            min-height: 19% !important;
            min-width: 26% !important;
            width: 26% !important;
        }

        /*#table tr td:nth-child(1),td:nth-child(2),td:nth-child(3){width:10%; }*/
        /*#table tr td:nth-child(4),td:nth-child(5) {width:30%; }*/
        #table tr td:last-child() {
            width: 82px;
        }

        /*tab 1*/
        .color-class {
            /*color: #f45601;*/
            color: red;
            text-transform: uppercase;
            vertical-align: top;
        }

        #table-1 tr th {
            width: 10%;
        }

        #table-1 tr td:nth-child(2) {
            width: 35.5%;
        }

        #table-1 tr td:nth-child(3) {
            padding-right: 5em;
            vertical-align: top;
            width: 72%;
            float: right;
        }

        #table-1 {
            width: 100%;
            float: left;
        }

        #map {
            width: 100%;
            height: 275px;
            float: left;
            border: 2px solid black;
            top: 272px;
            right: 17%;
        }

        #report_summary {
            padding-right: 5em;
            text-align: justify;
        }

        #divLoading {
            display: none;
        }

        #divLoading.show {
            display: block;
            position: fixed;
            z-index: 100;
            background-image: url('<?php bloginfo('template_url'); ?>/intel/images/3.gif');
            background-color: #666;
            opacity: 0.4;
            background-repeat: no-repeat;
            background-position: center;
            left: 0;
            bottom: 0;
            right: 0;
            top: 0;
        }

        #loadinggif.show {
            left: 50%;
            top: 50%;
            position: absolute;
            z-index: 101;
            width: 32px;
            height: 32px;
            margin-left: -16px;
            margin-top: -16px;
        }

        #expert-panel-paragraph {
            float: left;
            width: 95%!important;
            margin-left: 0;
        }

        #tabberlive {
            float: left;
            width: inherit;
        }

        #tabbernav {
            float: left;
        }

        #heading-container {
            float: left;
        }

        #summary_container {
            float: left;
            width: 100%;
            height: auto;
            /*overflow: auto;*/
        }

        .table_container {
            padding-left: 50px;
            padding-top: 21px;
        }

        #content-wrapper {
            font-size: 13px;
        }

        .blank_row {
            height: 25px !important;
        }

        #map_container {
            margin-top: -31px;
        }

        #history_table {
            padding-left: 50px;
        }

        .tbl-history > p {
            padding-top: 10px;
        }

        #project-td > h1 {
            color: #384047;
            font-family: "Roboto Condensed", sans-serif !important;
            font-size: 13px;
            letter-spacing: 0;
            margin: 0;
            padding: 3px 3px 3px 0;
            text-align: left;
            text-transform: none;
        }

        #full-view-report {
            margin-left: 1.5em;
            text-decoration: underline !important;
        }
        .modal-backdrop.fade.in {
            opacity: 0;
        }
    </style>

 <!-- Load Google Analytics Universal Code -->
<script>
           (function (i, s, o, g, r, a, m) {
                   i['GoogleAnalyticsObject'] = r;
                   i[r] = i[r] || function () {
                               (i[r].q = i[r].q || []).push(arguments)
                           }, i[r].l = 1 * new Date();
                   a = s.createElement(o),
                          m = s.getElementsByTagName(o)[0];
                   a.async = 1;
                   a.src = g;
                   m.parentNode.insertBefore(a, m)
              })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

               ga('create', 'UA-23771865-1', 'auto');
            ga('require', 'displayfeatures');
            ga('send', 'pageview');

       </script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-140815734-1"></script>

<script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'UA-140815734-1'); </script>


    <div class="site-inner-wrapper">
        <?php // include 'header.php';?>
        <?php /*include 'modals.php';*/ ?>
        <section id="content-wrapper">
            <div id="review-panel-main">
                <div id="expert-panel-paragraph">
                    <div class="resource-reporting">
                        For thousands of other reports visit
                        <a onclick="javascript:window.location.replace('/intel');">Opaxe.com</a>
                        <!--<span> | </span>
                        <a onclick="javascript:self.close();">Close this report. X</a>-->
                    </div>

                    <div class="tabber">
                        <div id="heading-container">
                            <h1 id="heading-text"><?php echo "$company"; ?></h1>
                        </div>

                        <div id="summary_container" class="tabbertab">
                            <h2>Summary</h2>
                            <!--                        <img src="images/loadingAnimation.gif">-->
                            <div>
                                <div class="table_container">
                                    <table id="table-1">
                                        <tr>
                                            <th class="color-class">Project:</th>
                                            <td id="project-td" class="data-to-filled">
                                                <h1><?php echo "$project"; ?></h1></td>
                                            <td rowspan="10" class="data-to-filled">
                                                <div id="map" class="report-map"></div>
                                            </td>
                                        </tr>
                                        <tr id="deposit-tr">
                                            <th class="color-class">Deposit:</th>
                                            <td id="deposit-td" class="data-to-filled"></td>
                                        </tr>
<!--                                        <tr>-->
<!--                                            <th class="color-class">Country:</th>-->
<!--                                            <td id="country-td" class="data-to-filled"></td>-->
<!--                                        </tr>-->
                                        <tr id="location-tr">
                                            <th class="color-class">Location:</th>
                                            <td id="location-td" class="data-to-filled"></td>
                                        </tr>
                                        <tr>
                                            <th class="color-class">Commodities:</th>
                                            <td id="commodities-td" class="data-to-filled"></td>
                                        </tr>
                                        <tr class="blank_row">
                                            <th></th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th class="color-class">Date:</th>
                                            <td id="date-td" class="data-to-filled"></td>
                                        </tr>
                                        <tr id="report-code-tr">
                                            <th class="color-class">Report Code:</th>
                                            <td id="code1" class="data-to-filled"></td>
                                        </tr>
                                        <tr>
                                            <th class="color-class">Report Type:</th>
                                            <td id="report-type-td" class="data-to-filled"></td>
                                        </tr>
                                        <tr id="project-stage-tr">
                                            <th class="color-class">Project Stage:</th>
                                            <td id="project-stage-td" class="data-to-filled"></td>
                                        </tr>
                                        <tr class="blank_row">
                                            <th></th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th class="color-class">Report details:</th>
                                            <td id="report-details-td" class="data-to-filled"></td>
                                        </tr>
                                        <tr class="blank_row">
                                            <th></th>
                                            <td></td>
                                        </tr>
                                        <tr id="resource-tr">
                                            <th class="color-class">Resources:</th>
                                            <td id="resources-td" class="data-to-filled"></td>
                                        </tr>
                                        <tr class="blank_row">
                                            <th></th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th class="color-class">CP/QP:</th>
                                            <td id="cpqp1" class="data-to-filled"></td>
                                        </tr>
                                        <tr class="blank_row">
                                            <th></th>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th class="color-class">ABSTRACT:</th>
                                            <td colspan="2" id="report_summary" class="data-to-filled"></td>
                                        </tr>
                                        <tr class="blank_row">
                                            <th></th>
                                            <td></td>
                                        </tr>
                                    </table>
                                </div>

                            </div>
                        </div>

                        <div class="tabbertab" id="pdf_container">
                            <h2>Full Report</h2>
                            <div id="view-pdf2"></div>
                        </div>

                        <div class="tabbertab" id="history_container">
                            <h2>History</h2>

                            <div id="history_table">
                                <div class="blank_row"></div>
                                <table id="table" class="tbl-history">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th id="deposit-th">Deposit</th>
                                        <th id="project-th">Project</th>
<!--                                        <th>Country</th>-->
                                        <th>Report Type</th>
                                        <th>Report Highlights</th>
                                        <th style="width: 9%;">Open</th>
                                    </tr>
                                    </thead>
                                    <tbody id="history_data">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div id="divLoading"></div>

    </div>
    <link href='<?php bloginfo('template_url'); ?>/intel/css/mapbox.css' rel='stylesheet'/>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/intel/js/mapbox.js"></script>


    <script type="text/javascript">
    var report = {
      current_report:'',
      user_plan :''
    };
        $("div#divLoading").addClass('show');
        function viewReportGA() {
            var url_name = <?= '"' . $url_name . '"' ?>;
            ga('send', {
                hitType: 'event',
                eventCategory: 'Intel',
                eventAction: 'View Report',
                eventLabel: url_name
            });
        }

        function viewReportTab() {
          console.log(report);
          if((report.current_report.commodities.indexOf('Gold') == -1) && (report.user_plan == 'Plan1' || report.user_plan=="null")){
            usernotAllow();
            return;
          }
            //Add Google Analytics Events
            viewReportGA();

            $(window).scrollTop(0);
            $('div.tabberlive ul li:nth-child(2)').addClass('tabberactive');
            $('div.tabberlive ul li:nth-child(1)').removeClass('tabberactive');
            $('div.tabberlive ul li:nth-child(3)').removeClass('tabberactive');
            $('#pdf_container').removeClass('tabbertabhide');
            $('#summary_container').addClass('tabbertabhide');
            $('#history_container').addClass('tabbertabhide');
            $('#heading-container').hide();
            $('#pdfViewerIframe').css('height', window.innerHeight - 200);
        }

        function usernotAllow(){
          $('div.tabberlive ul li:nth-child(1)').addClass('tabberactive');
          $('div.tabberlive ul li:nth-child(2)').removeClass('tabberactive');
          $('div.tabberlive ul li:nth-child(2)').removeClass('tabberactive');
          $('#pdf_container').addClass('tabbertabhide');
          $('#summary_container').removeClass('tabbertabhide');
          $('#history_container').addClass('tabbertabhide');
          $('#heading-container').show();
          blockAcesstoReport();
        }

        function blockAcesstoReport() {
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
        }

        $(document).ready(function () {

            $('#content-wrapper').hide();

            $(document).on('click', 'ul.tabbernav li', function (e) {
                if ($('ul.tabbernav li:nth-child(2)').hasClass('tabberactive')) {
                  if(report.user_plan != 'Plan2' && report.user_plan != 'Plan3' && (report.current_report.commodities.indexOf("Gold") == -1)){
                      usernotAllow();
                 }
                  else{
                    //Add Google Analytics Events
                    viewReportGA();
                    // Set Iframe Height
                    $('#pdfViewerIframe').css('height', window.innerHeight - 200);
                    $('#heading-container').hide();
                  }
                }
               else if ($('ul.tabbernav li:nth-child(3)').hasClass('tabberactive')) {
                 if(report.user_plan != 'Plan2' && report.user_plan != 'Plan3' && (report.current_report.commodities.indexOf("Gold") == -1)){
                     usernotAllow();
                }
                $('#heading-container').show();
               }
                 else {
                    $('#heading-container').show();
                }
            });

            var url = SCRIPT_PATH + "?action=getReportByURLName";
            var fields = {url_name: <?= '"' . $url_name . '"' ?>};

            $.post(url, fields, function (response) {
                if (response.success) {
                    $("div#divLoading").removeClass('show');
                    $('#content-wrapper').fadeIn(200);


                    if (response.reports) {
                        var data = response.reports[0];
                        console.log(data);
                        report.current_report = data;
                        report.user_plan = response.user['sub_plan'];
//                    Summary tab:

                        if (response.TransReport) {
                            var long = data.longitude;
                            var lat = data.latitude;
                            $('#deposit-tr').hide();
                            $('#report-code-tr').hide();
                            $('#resource-tr').hide();
                            $('#project-stage-tr').show();
                            $('#location-tr').show();
                            $('#project-th').show();
                            $('#deposit-th').hide();
                        }
                        else {
                            var long = oRsc.decimalFromSexagesimal(data.longitude);
                            var lat = oRsc.decimalFromSexagesimal(data.latitude);
                            $('#deposit-tr').show();
                            $('#report-code-tr').show();
                            $('#resource-tr').show();
                            $('#project-stage-tr').hide();
                            $('#location-tr').hide();
                            $('#project-th').hide();
                            $('#deposit-th').show();
                        }
                        var cords = [lat, long];

                        L.mapbox.accessToken = 'pk.eyJ1IjoibXJjbGFya3NvbiIsImEiOiJuTmlPaTM0In0.hImtadsV4kMLI_iihZkILg';
                        var map = L.mapbox.map('map', 'mapbox.streets')
                            .setView(cords, 5);
                        L.marker(cords).addTo(map);
                        map.scrollWheelZoom.disable();
                        {
                            $('#deposit-td').text((data.deposit) ? data.deposit : 'not specified');
                            $('#project-stage-td').text((data.project_stage) ? data.project_stage : 'not specified');
                            $('#code1').text((data.code) ? data.code : 'not specified');

                            $('#resources-td').text((data.resources) ? data.resources : 'not specified');

                            //$('#country-td').text((data.location) ? data.location : 'not specified');
                            $('#location-td').text((data.status) ? data.status : 'not specified');
                            $('#date-td').text((data.date) ? data.date : 'not specified');
                            $('#report-type-td').html(data.type + ' ' + '<a href="javascript:;" id="full-view-report" onClick="viewReportTab()">View full report</a>');
                            $('#commodities-td').text((data.commodities) ? data.commodities : 'not specified');
                            $('#report-details-td').text((data.detail) ? data.detail : 'not specified');
                            $('#cpqp1').text((data.cpqp) ? data.cpqp : 'not specified');
                            $('#report_summary').text((data.report_sum) ? data.report_sum : 'not specified');
                        }

//                    Pdf tab:
                        if(report.user_plan == 'Plan2' || report.user_plan == 'Plan3' || data.commodities.indexOf("Gold") >= 0)
                        $('#view-pdf2').html("<iframe id='pdfViewerIframe' src ='/wp-content/themes/fount/intel/js/web/viewer.html?file=/" + data.pdf_link + "&url_name=" + data.url_name + "' style='width: 100%; height: 520px;' allowfullscreen ></iframe>");

//                    History tab:
                        if (response.TransReport) {
                            var new_url = SCRIPT_PATH + '?action=getTransHistory';

                        }
                        else {
                            var new_url = SCRIPT_PATH + '?action=getHistory';

                        }
                        var new_f = {
                            report_id: data.id,
                            latitude: data.latitude,
                            longitude: data.longitude,
                            current_report: true
                        };
                        $.post(new_url, new_f, function (res) {

                            res = JSON.parse(res);
                            if (res.success) {
                                var his_data = res.history;

                                var his_len = his_data.length;
                                for (var i = 0; i < his_len; i++) {
                                    var ins_data = '';
                                    ins_data = '<tr>';
                                    ins_data += '<td>' + his_data[i].date_format + '</td>';
                                    ins_data += '<td>' + his_data[i].deposit + '</td>';
                                    //ins_data += '<td>' + his_data[i].location + '</td>';
                                    ins_data += '<td>' + his_data[i].type + '</td>';
                                    ins_data += '<td>' + his_data[i].detail + '</td>';
                                    ins_data += '<td><a href="/report/' + his_data[i].url_name + '"  style="text-decoration: underline !important;">Details</a></td>';
                                    ins_data += '</tr>';
                                    $('#history_data').append(ins_data);
                                }
                            }
                            else {
                                $('.tbl-history').html('<p>No history found.</p>');
                            }
                        });

                    }
                } else {
                    $("div#divLoading").removeClass('show');
                    $('#content-wrapper').fadeIn(200);
                    window.location.replace(BASE_URL);
                }
            }, 'json');
        });
    </script>
<?php get_footer(); ?>
