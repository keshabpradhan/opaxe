<?php if (is_user_logged_in() && $user_login == "php-dev") {
    ?>
    <?php get_header(); ?>
    <style type="text/css">

        body{
            background: white!important;
        }

        .row {
            margin-right: 0px !important;
            margin-left: 0px !important;
        }

        .container {
            width: 100% !important;
        }

        table {
            width: 100%;
            position: relative!important;
        }

        tr:after {
            content: ' ';
            display: block;
            visibility: hidden;
            clear: both;
        }

        thead th {
            height: 30px;
            text-align: left;
        }

        tbody {
            height: 700px;
            overflow-y: auto;
            width: 100%;
        }

        thead {
            /* fallback */
        }

        .table > thead > tr > th {
            border-bottom: 0px !important;
        }
        #prk_footer_wrapper{
            display: none;
        }

    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="<?php bloginfo('template_url'); ?>/intel/js/jquery.min.js"></script>
<!--    <script src="--><?php //bloginfo('template_url'); ?><!--/intel/js/jquery-ui.min.js"></script>-->
    <script src="<?php bloginfo('template_url'); ?>/intel/js/jquery-migrate-1.0.0.js"></script>
    <script src="<?php bloginfo('template_url'); ?>/intel/js/app.js?101"></script>
<!--    <script src="--><?php //bloginfo('template_url'); ?><!--/intel/js/app/report.js"></script>-->
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/intel/js/app/activity-log.js"></script>
<!--    <link href='--><?php //bloginfo('template_url'); ?><!--/intel/css/mapbox.css' rel='stylesheet'/>-->
<!--    <script type="text/javascript" src="--><?php //bloginfo('template_url'); ?><!--/intel/js/mapbox.js"></script>-->
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/intel/css/custom.css"/>
    <body onload="javascript:oRsc.Activity_Log_Detail();">
    <div class="container">
        <h2>Panel Footer</h2>
        <div class="panel panel-primary filterable" style="width:100%">
            <div class="panel-heading">Users
                <button id="filter_btn" class="btn btn-default btn-xs btn-filter"><span
                            class="glyphicon glyphicon-filter"></span> Filter
            </div>

            </button>
            <div class="row">
                <table class="table table-hover">
                    <thead>
                    <tr class="filters">
                        <th><input type="text" class="form-control" placeholder="Sr.No" disabled></th>
                        <th><input type="text" class="form-control" id="date" placeholder="Date" disabled>
                        <th><input type="text" class="form-control" placeholder="Username" disabled></th>
                        <th><input type="text" class="form-control" placeholder="IP" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Location" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Action" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Action Log" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Mode" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Report id" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Company" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Commodities" disabled></th>
                        <th><input type="text" class="form-control" placeholder="QC/CP" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Report Highlight" disabled></th>
                        <th><input type="text" class="form-control" placeholder="lat" disabled></th>
                        <th><input type="text" class="form-control" placeholder="lon" disabled></th>
                            <div id="opt-date-range" style="display:none">
                                <div id="dates_list">
                                    <form id="date-rage-frm">
                                        <p id="clear_filter">Clear All</p>
                                        <p id="select"></p>
                                        <ul class="dates-list">
                                        </ul>
                                    </form>
                                </div>
                                <p id="sub_datess_tofilter"><u>Ok</u></p>
                                <p id="cancel_filter"><u>Cancel</u></p>
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody id="log-detail">
                    </tbody>
                </table>
            </div>
            <!-- <div class="panel-footer">Activity Log</div> -->
        </div>
    </div>
    </body>
<?php } else {
    ?>
    <script type="text/javascript">
        window.open("https://www.rscmme.com", "_self");
    </script>
    <?php
}
?>
