<!-- Not Feature Found-->
<!-- <a class="region-button region-button-off" id="region-button-custom-reporting" data-toggle="modal" data-target="#custom-reporting-modal" href="#" onclick="javascript:oRsc.customReporting();">Custom Reporting</a> -->


<div class="modal fade bs-example-modal-sm" id="custom-reporting-modal" tabindex="-1" data-backdrop="static"
     data-keyboard="false" role="dialog"  style="top: 11%;">
    <div class="modal-dialog modal-lg" style="margin-left: 320px;bottom:27px;">
        <div class="modal-content" style="opacity: 0.9; ">
            <div class="modal-header" style="background-color: #1e51a4; color:white">
                <button type="button" id="close-subscribe-custombtn" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" >Custom Reporting</h4>
            </div>
            <ul class="nav nav-tabs" id="tabContent">
                <li id="default_tab" class="active"><a href="#details" data-toggle="tab">REPORT STATS</a></li>
                <li><a id="resource_consultant_tab" class="resource_consultant" href="#resource_consultant" data-toggle="tab">
                        COMPETENT PERSONS & AFFILIATION LISTS</a></li>
                <li><a id="networking_tab" href="#networking" data-toggle="tab">BEST DRILLING INTERCEPTS</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="details">
                    <div class="modal-body">
                        <div class="row">
                            <!-- <legend style="font-size: 30px; color:#1d50a3; ">Qualified Person list</legend> -->
                            <p class="custom-div" style="font-size: 11px; color:#1d50a3; margin-left: 15px;">Use the
                                filters in
                                the side bar to make a selection</p>
                            <!-- Selected Filter filter removed from custom reporting *Shahzaib -->
                            <!--                            <h1 class="custom-div"-->
                            <!--                                style="margin-top: 30px; font-size: 13px; margin-left: 15px; font-weight: bold">Selected-->
                            <!--                                Filters:</h1>-->
                            <div class="row custom-div " style="margin-left: -19px;">
                                <ul>
                                    <li class="custom-title col-md-3" id="custom-date-title">Reporting Period:</li>
                                    <li class="custom-report custom-menu col-md-8" id="custom-date"></li>
                                </ul>
                            </div>
                            <!-- Resources and reserves filter removed from custom reporting *Shahzaib -->
                            <!--                            <div class="row custom-div " style="margin-left: -19px;">-->
                            <!--                                <ul>-->
                            <!-- <div class="col-md-1">
                                <li class="custom-title ">Resources:</li>
                            </div>
                            <div class="col-md-10">
                                <li class="custom-report custom-menu " id="custom-resources"></li>
                            </div> -->
                            <!--                                </ul>-->
                            <!--                            </div>-->
                            <!--                            <div class=" row custom-div " style="margin-left: -19px;">-->
                            <!--                                <ul>-->
                            <!-- <li class="custom-title col-md-1">Reserves:</li>
                            <li class="custom-report custom-menu col-md-10" id="custom-reserves"></li> -->
                            <!--                                </ul>-->
                            <!--                            </div>-->
                            <div class="row custom-div " style="margin-left: -19px;">
                                <ul>
                                    <li class="custom-title  col-md-3">Selected Commodities:</li>
                                    <li class="custom-commodity custom-menu col-md-8" id="custom-commodities"
                                        style="line-height: 18px;padding-top: 0px;"></li>
                                </ul>
                            </div>
                            <!-- <div class="row custom-div " style="margin-left: -19px;">
                                <ul>
                                    <li class="custom-title  col-md-3">Search by Commodities:</li>
                                    <li class="custom-commodity custom-menu col-md-8" id=""
                                        style="line-height: 18px;padding-top: 0px;"><input type="checkbox" name="comm[]" class="comm-filters" value="Gold">Gold</li>
                                        <li class="custom-commodity custom-menu col-md-8" id=""
                                        style="line-height: 18px;padding-top: 0px;"><input type="checkbox" name="comm[]" class="comm-filters" value="Cobalt">Cobalt</li>
                                </ul>
                            </div> -->
                            <h1 class="custom-div" id="bar-chart-heading" style="font-size: 13px">Weekly Report
                                activity</h1>
                            <div id="container" style="height: 300px"></div>
                            <div class="col-md-12">
                                <div id="doughnutss" class="col-md-6" style="max-width: 400px;max-height: 230px;">
                                    <h1 class="custom-div" id="donut-chart-head">Report Code</h1>
                                    <canvas id="notChart" width="200" height="200"></canvas>
                                </div>
                                <h1 class="custom-div" id="pie-chart-head" style="font-size: 13px">Report Type</h1>
                                <div id="pieee" class="col-md-6">
                                    <canvas id="doChart" width="10" height="10"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="resource_consultant">
                    <!-- Second Tab -->
                    <div class="modal-body">
                        <div class="row">
                            <p class="custom-div" style="font-size: 11px; color:#1d50a3; margin-left: 15px;">Select a
                                commodity from the side bar filter</p>


                            <div class="row custom-div " style="margin-left: -19px;">
                                <ul id="comm_list">
                                    <li class="custom-title  col-md-3">Top Resource Consultants by:</li>
                                    <li class="custom-commodity custom-menu col-md-8" id="filter-commodities"
                                        style="line-height: 18px;padding-top: 0px;"></li>
                                </ul>
                            </div>
                            <div class="container">
                                <table id="resource_qp_table" class="table table-striped">
                                    <thead class="resource_head">
                                    <th>Resources</th>
                                    <th>Frequency</th>
                                    </thead>
                                    <tbody id="comm_lists">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="networking">
                    <!--                    Third Tab -->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-md" id="trans-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div style="height: 40px;">
                <p style="font-weight: bold;position: absolute;margin: 21px">Transaction Announcement Reports</p>
            </div>
<!--            <a style="left: 575px!important;top: 5px" class="leaflet-popup-close-button" data-dismiss="modal"-->
<!--               href="#close"></a>-->
            <a href="#" class="remodal-close close-custom-modal-remodal"></a>

            <!--            <div class="trans-box-image"></div>-->
            <div class="modal-body">
                <p style="text-align: justify; margin-bottom:12px;">This feature of opaxe displays 7,000 global reports published since April 2017 relating to transactions of mineral exploration, resource development, and mining properties, including property acquisitions, company acquisitions and takeovers.
                    <br><br>
                    In order to access these reports you are required to have a current subscription.</p>
                <div style="margin-left: 418px;padding-top: 8px;">

                    <button onclick="oRsc.openSignupmodel()" class="btn btn-primary close-tooltips">Sign Up</button>

                    <a data-toggle="modal" data-target="#login-modal" onclick="oRsc.closeTrans()" onMouseOver="this.style.color='red'" onMouseOut="this.style.color='#111111'" class="close-tooltips header-login-link regular_anchor_menu" style="display: inline-block; cursor: pointer;color: #111111;bottom: 22px;">
                        <span class=".sf-menu span" style="text-transform: capitalize;">Login</span>
                    </a>

<!--                    <a  class="user-reg" style="color: #FE874B;" onclick="oRsc.openSignupmodel()">-->
<!--                        Register for free-->
<!--                    </a> or-->
<!--                    <a id="userLogoutt" class="user-reg" data-toggle="modal" data-target="#login-modal"-->
<!--                       style="color: #FE874B;" onclick="oRsc.closeTrans()">-->
<!--                        login-->
<!--                    </a>-->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Not Feature Found-->
<div class="modal fade bs-example-modal-sm" id="feature-not-found-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <p>This feature not available currently and will be launched soon.</p>
            </div>
        </div>
    </div>
</div>

<!-- Request for upgrade -->

<div class="modal fade bs-example-modal-md" id="request-forupgrade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <a style="left: 575px!important;top: 5px;z-index: 9999999" class="leaflet-popup-close-button"
           data-dismiss="modal" href="#close"></a>
        <div class="modal-content">
            <div class="modal-body">
                <span style="line-height: 3"><b>Request to increase your download limit.</b></span>
                <p style="margin: unset">If you would like to increase your download limit, please submit your best
                    contact phone
                    number below, and we will give you a call to discuss your needs and provide a free limit
                    increase.</p>
                <p></p>
                <div class="container-fluid">

                    <input type="hidden">

                    <div class="input-group input-group-lg" style="margin-bottom: 20px">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input style="font-size: 14px" type="text" id="request-user" class="form-control required"
                               required
                               placeholder="Name">
                    </div>


                    <div class="input-group input-group-lg" style="margin-bottom: 20px">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                        <input style="border-bottom-left-radius: 0; border-top-left-radius: 0;border: 1px solid #ccc; width:100%;font-size:14px;height: 47px;margin-bottom: -10px!important;"
                               type="tel" class="form-control required" required id="phone"
                               placeholder="Phone Number" >
                    </div>
                    <div class="form-group">
                        <label for="comment">Message:</label>
                        <textarea class="form-control" rows="5" name="message" id="pdfrequestMessage"></textarea>
                    </div>

                </div>
            </div>
            <div class="modal-footer" style="width:100%; margin-left:0px;">
                <button type="button" class="btn btn-primary" data-dismiss="modal"
                        style="position: absolute;margin-left: 11vw;background-color: #428bca!important">No thanks
                </button>
                <button id="requestForUpgrade" type="button" class="btn btn-primary"
                        style="margin-left:16vw; background-color: #428bca!important">Submit
                </button>
            </div>
            <br>
        </div>
    </div>
</div>

<!-- Popup for non registered users for commodity checboxs -->
<div class="modal fade bs-example-modal-md" id="commodity_checkboxes_popup" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
<!--            <a style="left: 575px!important;top: 5px;z-index: 9999999" class="leaflet-popup-close-button"-->
<!--               data-dismiss="modal" href="#close"></a>-->
            <a href="#" class="remodal-close close-custom-modal-remodal"></a>
            <div class="modal-body">
                <span style="padding: 0px">For registered users only.</span>
                <p></p>
            </div>

            <div class="modal-footer" style="width:100%; margin-left:0px;">
                <a onclick="oRsc.registerforComm()" class="btn btn-primary commodity-checkboxes-register">Register</a>
                <a href="#" data-toggle="modal" data-dismiss="modal" data-target=".login-register-form" class="btn btn-primary commodity-checkboxes-register">Login</a>
                <a id="cancel_registered_users" class="btn btn-danger commodity-checkboxes-register" data-dismiss="modal" title="Back to filter">Cancel</a>
            </div>
            <br>
        </div>
    </div>
</div>

<!-- Popup for non registered users for report links -->
<div class="modal fade bs-example-modal-md" id="report-pdf-links-warning-messages" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
<!--            <a style="left: 575px!important;top: 5px;z-index: 9999999" class="leaflet-popup-close-button"-->
<!--               data-dismiss="modal" href="#close"></a>-->
            <a href="#" class="remodal-close close-custom-modal-remodal"></a>
            <div class="modal-body">
                <span style="padding: 0px">The report you are trying to access is available for registered users only. Please login or register for an account.</span>
                <p></p>
            </div>

            <div class="modal-footer desktop-footer" style="width:100%; margin-left:0px;">
                <a onclick="oRsc.registerforComm()" class="btn btn-primary">Register</a>
                <a href="#" data-toggle="modal" data-dismiss="modal" data-target=".login-register-form" class="btn btn-primary">Login</a>
                <a class="btn btn-danger grey-btn" data-dismiss="modal" title="Back to filter">Cancel</a>
            </div>
            <div class="modal-footer mobile-footer" style="width:100%; margin-left:0px;display: none">
                <a class="btn btn-primary" data-dismiss="modal" title="Back to filter">ok</a>
            </div>
            <br>
        </div>
    </div>
</div>

<!-- Popup for Under deveolpment dropdown list -->
<div class="modal fade bs-example-modal-md" id="under-deveolpment" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <a style="position:absolute; display:block;left: 575px!important;top: 5px;z-index: 9999999" class="leaflet-popup-close-button"
               data-dismiss="modal" href="#close"></a>
            <div class="modal-body">
                <span style="padding: 0px" id="custom-messages">Currently under developement.</span>
                <p></p>
            </div>

            <div class="modal-footer" style="width:100%; margin-left:0px;">
            </div>
            <br>
        </div>
    </div>
</div>

<!-- Saved preferences Model -->
<div class="modal fade bs-example-modal-md" id="saved-preferences-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <a style="left: 575px!important;top: 5px;z-index: 9999999" class="leaflet-popup-close-button"
               data-dismiss="modal" href="#close"></a>
            <div class="modal-body">
                <span style="padding: 0px">Currently no filters selected.</span>
                <p></p>
            </div>

            <div class="modal-footer" style="width:100%; margin-left:0px;">
                <a class="btn btn-primary saved-preferences-btn" data-dismiss="modal" style="background-color:#428bca;">Ok
                </a>
            </div>
            <br>
        </div>
    </div>
</div>


<!-- Compliance Issue Popup -->
<div class="modal fade bs-example-modal-md" id="compliane-issue-popup" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <span style="padding: 0px"><b>Thank you for your feedback .</b> Our RSC Intelligence team will try to attend to your feedback within one business day. If you left your email address then we will reply personally. Please don't hesitate to contact us at <a href='mailto:intel@rscmme.com?subject=Compliance Issue'>intel@rscmme.com.</a></span>
                <p></p>
            </div>
            <div class="modal-footer" style="width:100%; margin-left:0px;">
                <button type="button" class="btn btn-primary" data-dismiss="modal" style="margin-left:16vw;">Ok</button>
            </div>
            <br>
        </div>
    </div>
</div>
<!-- Pdf Limit Complete -->
<div class="modal fade bs-example-modal-md" id="pdf-limit-notifier" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <a style="left: 575px!important;top: 5px;z-index: 9999999" class="leaflet-popup-close-button"
           data-dismiss="modal" href="#close"></a>
        <div class="modal-content">
            <div class="modal-body">
                <span style="line-height: 3"><b>Whoops. You have reached your download limit quota.</b></span>
                <p style="margin: unset">To find out how you can increase your download limit, go to <a href="/user-profile?ihc_ap_menu=profile">Manage Profile.</a></p>
                <p></p>
            </div>
            <br>
        </div>
    </div>
</div>
<!-- Subscribe Thank you Popup -->
<div class="modal fade bs-example-modal-md" id="subscribe-thankyou-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <span class="span-text-message">Thank you for subscribing to the RSC Resource Reporting Intelligence. A
                    confirmation is sent to your
                    email.
                </span>
                <p></p>
            </div>

            <div class="modal-footer" style="width:100%; margin-left:0px;">
                <button type="button" class="btn btn-primary" data-dismiss="modal" style="margin-left:16vw;">Ok</button>
            </div>
            <br>
        </div>
    </div>
</div>
<!-- pdf request success modal -->
<div class="modal fade bs-example-modal-md" id="pdf-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <span id="thnkew-popup">Thank you for an upgrade request. We will contact you as soon as we can.</span>
                <p></p>
            </div>

            <div class="modal-footer" style="width:100%; margin-left:0px;">
                <button type="button" class="btn btn-primary" data-dismiss="modal"
                        style="margin-left:16vw;background-color:#FC2020;">Ok
                </button>
            </div>
            <br>
        </div>
    </div>
</div>

<!--Three plans model for signup button-->
<div class="modal fade bs-example-modal-lg" id="plansModel" role="dialog">
    <div class="modal-dialog plansmodel-dialog" style="margin-top: 0;">

        <!-- Modal content-->
        <div class="modal-content plans-content" style="opacity: 0.9;">
<!--            <button type="button" class="close" data-dismiss="modal" id="modal-close-button">×</button>-->
            <a href="#" class="remodal-close close-custom-modal-remodal" id="modal-close-button"></a>
            <div class="modal-body plans-model-body">
                <div class="row">
                    <div class="col-sm-offset-3 col-sm-3">
                        <div class="div-plans">
                            <h3 class="plan-headings">SILVER</h3>
                            <span class="plan1-span plans-span" style="padding:0;">Weekly newsletters</span>
                            <span style="visibility: hidden;">Weekly</span>
                            <span class="plan1-span plans-span">Free</span>
                            <a class="plans-button" href="register?lid=1">SELECT</a>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="div-plans">
                            <h3 class="plan-headings">GOLD</h3>
                            <span class="plans-span">Unlock commoditites</span>
                            <span class="plans-span">Transaction reports</span>
                            <span class="plan2-span plans-span" style="margin-bottom:0;">Free</span>
                            <a href="register?lid=2" class="plans-button" id="plan2-button">SELECT</a>
                            <span class="plans-span corner-style-text">LIMITED TIME OFFER *</span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="div-plans">
                            <h3 class="plan-headings">PLATINUM</h3>
                            <span class="plan3-span plans-span" style="padding:0;">Unlimited reports</span>
                            <span style="visibility: hidden;">Weekly</span>
                            <span class="plan3-span plans-span">$ -</span>
                            <a class="plans-button" href="#">COMING SOON</a>
                        </div>
                    </div>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th class="table-heading">Features offered:</th>
                        <th class="table-heading"></th>
                        <th class="table-heading"></th>
                        <th class="table-heading"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="headings-feature-below"><p class="features-span">Resource Reports Bulletin</p></td>
                        <td class="checkmark">&#10003;</td>
                        <td class="checkmark">&#10003;</td>
                        <td class="checkmark">&#10003;</td>
                    </tr>
                    <tr>
                        <td class="headings-feature-below"><p class="features-span">List of Reports published by week</p></td>
                        <td></td>
                        <td></td>
                        <td class="checkmark">&#10003;</td>
                    </tr>
                    <tr>
                        <td class="headings-feature-below"><p class="features-span">Technical Report Highlights</p></td>
                        <td class="table-data-text">Gold only</td>
                        <td class="checkmark">&#10003;</td>
                        <td class="checkmark">&#10003;</td>
                    </tr>
                    <tr>
                        <td class="headings-feature-below"><p class="features-span">Technical Report PDF Downloads</p></td>
                        <td class="table-data-text">Gold only</td>
                        <td class="checkmark">&#10003;</td>
                        <td class="checkmark">&#10003;</td>
                    </tr>
                    <tr>
                        <td class="headings-feature-below"><p class="features-span">Transaction Report Highlights</p></td>
                        <td></td>
                        <td class="checkmark">&#10003;</td>
                        <td class="checkmark">&#10003;</td>
                    </tr>
                    <tr>
                        <td class="headings-feature-below"><p class="features-span">Transaction Report PDF Downloads</p></td>
                        <td></td>
                        <td class="table-data-text">3 downloads per day, 10 per week</td>
                        <td class="checkmark">&#10003;</td>
                    </tr>
                    <tr>
                        <td class="headings-feature-below"><p class="features-span">Saved preferences</p></td>
                        <td></td>
                        <td class="checkmark">&#10003;</td>
                        <td class="checkmark">&#10003;</td>
                    </tr>
                    <!--                    <tr>-->
                    <!--                        <td class="headings-feature-below"><p class="features-span">User Generated Custom Reports</p></td>-->
                    <!--                        <td></td>-->
                    <!--                        <td></td>-->
                    <!--                        <td class="checkmark">&#10003;</td>-->
                    <!--                    </tr>-->
                    <tr>
                        <td class="headings-feature-below"><p class="features-span">Alerts</p></td>
                        <td></td>
                        <td></td>
                        <td class="checkmark">&#10003;</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!--Three Change plans model for signup button-->
<div class="modal fade bs-example-modal-lg" id="changePlanmodel" role="dialog">
    <div class="modal-dialog plansmodel-dialog" style="margin-top: 0;">

        <!-- Modal content-->
        <div class="modal-content plans-content">
            <a class="leaflet-popup-close-button change-plans-model-closeBtn" data-dismiss="modal"  href="#close" style="display: block; float: right;margin-right: 10px">×</a>
            <div class="modal-body plans-model-body">
                <div class="row">
                    <div class="col-sm-offset-3 col-sm-3">
                        <div class="div-plans">
                            <h3 class="plan-headings">SILVER</h3>
                            <span class="plan1-span plans-span" style="padding:0;">Weekly intel newsletters</span>
                            <span style="visibility: hidden;">Weekly intel newsletters</span>
                            <span class="plan1-span plans-span">Free</span>
                            <a class="plans-button changePlan1" href="#">SELECT</a>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="div-plans">
                            <h3 class="plan-headings">GOLD</h3>
                            <span class="plans-span">Unlock commoditites</span>
                            <span class="plans-span">Transaction reports</span>
                            <span class="plan2-span plans-span" style="margin-bottom:0;">Free *</span>
                            <a href="#" class="plans-button changePlan2" id="changeplan2-button">SELECT</a>
                            <span class="plans-span corner-style-text">LIMITED TIME OFFER</span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="div-plans">
                            <h3 class="plan-headings">PLATINUM</h3>
                            <span class="plan3-span plans-span" style="padding:0;">Unlimited reports</span>
                            <span style="visibility: hidden;">Weekly intel newsletters</span>
                            <span class="plan3-span plans-span">$ -</span>
                            <a class="plans-button" href="#">COMING SOON</a>
                        </div>
                    </div>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th class="table-heading">Features offered:</th>
                        <th class="table-heading"></th>
                        <th class="table-heading"></th>
                        <th class="table-heading"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <!--                    <tr>-->
                    <!--                        <td  class="headings-feature-below"><p class="features-span">RSC News</p></td>-->
                    <!--                        <td  class="checkmark">&#10003;</td>-->
                    <!--                        <td  class="checkmark">&#10003;</td>-->
                    <!--                        <td  class="checkmark">&#10003;</td>-->
                    <!--                    </tr>-->
                    <tr>
                        <td class="headings-feature-below"><p class="features-span">Resource Reports Bulletin</p></td>
                        <td class="checkmark">&#10003;</td>
                        <td class="checkmark">&#10003;</td>
                        <td class="checkmark">&#10003;</td>
                    </tr>
                    <tr>
                        <td class="headings-feature-below"><p class="features-span">List of Reports published by week</p></td>
                        <td class="checkmark">&#10003;</td>
                        <td class="checkmark">&#10003;</td>
                        <td class="checkmark">&#10003;</td>
                    </tr>
                    <tr>
                        <td class="headings-feature-below"><p class="features-span">Technical Report Highlights</p></td>
                        <td class="table-data-text">Gold only</td>
                        <td class="checkmark">&#10003;</td>
                        <td class="checkmark">&#10003;</td>
                    </tr>
                    <tr>
                        <td class="headings-feature-below"><p class="features-span">Technical Report PDF Downloads</p></td>
                        <td class="table-data-text">Gold only</td>
                        <td class="checkmark">&#10003;</td>
                        <td class="checkmark">&#10003;</td>
                    </tr>
                    <tr>
                        <td class="headings-feature-below"><p class="features-span">Transaction Report Highlights</p></td>
                        <td></td>
                        <td class="checkmark">&#10003;</td>
                        <td class="checkmark">&#10003;</td>
                    </tr>
                    <tr>
                        <td class="headings-feature-below"><p class="features-span">Transaction Report PDF Downloads</p></td>
                        <td></td>
                        <td class="table-data-text">3 downloads per day, 10 per week</td>
                        <td class="checkmark">&#10003;</td>
                    </tr>
                    <tr>
                        <td class="headings-feature-below"><p class="features-span">Saved preferences</p></td>
                        <td></td>
                        <td class="checkmark">&#10003;</td>
                        <td class="checkmark">&#10003;</td>
                    </tr>
                    <!--                    <tr>-->
                    <!--                        <td class="headings-feature-below"><p class="features-span">User Generated Custom Reports</p></td>-->
                    <!--                        <td></td>-->
                    <!--                        <td></td>-->
                    <!--                        <td class="checkmark">&#10003;</td>-->
                    <!--                    </tr>-->
                    <tr>
                        <td class="headings-feature-below"><p class="features-span">Alerts</p></td>
                        <td></td>
                        <td></td>
                        <td class="checkmark">&#10003;</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- New Subscribe Popup Linked to Mailchimp-->
<form id="frm-subscribe-form" action="javascript:oInvitation.subscribe();">
    <div class="modal fade bs-example-modal-md" id="subscribe-modal" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" id="close-subscribe-btn" class="close" data-dismiss="modal"
                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >Become a member!</h4>
                </div>
                <div class="modal-body">
                    <p>Did you know that you could become a member of RSC Mineral Intelligence and automatically enrol
                        to our newsletter?</p>
                    <p>Besides receiving our weekly report, you will also have access to:</p>
                    <ul id="subs-list">
                        <li>Transaction Announcements Reports, a new feature that displays global reports since April
                            2017 that relate to transactions of mineral exploration properties, including property
                            acquisitions, company acquisitions and takeovers.
                        </li>
                        <li>Additional filters and search options</li>
                        <li>Custom reporting (currently being developed)</li>
                        <li>More</li>
                    </ul>
                </div>
                <div class="modal-footer" style="width:100%; margin-left:0px;">
                    <div class="processing" style="display: inline-block; width: 16px; margin-right: 4px;">
                        <img src="<?php bloginfo('template_url'); ?>/intel/images/loading_ani.gif"
                             style="margin: 0px ! important; display: none;" alt="Not found">
                    </div>
                    <a href="/register?lid=1" class="btn btn-primary">Register
                        to become a member</a>
                    <a href="https://rscmme.us5.list-manage.com/subscribe/post?u=2ccf06e2022ac43c8d1935fa5&id=7edabfb392"  class="btn btn-default">No thanks, I only want to subscribe</a>
                </div>
                <br>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</form>

<!--Signup free popup-->
<form id="frm-subscribe-popupform" action="javascript:oInvitation.subscribe();">
    <div class="modal fade bs-example-modal-md" id="signup-modal" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" id="close-sub-btn" class="close" data-dismiss="modal"
                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" >Become a member!</h4>
                </div>
                <div class="modal-body">
                    <p>Did you know that you could become a member of RSC Mineral Intelligence and automatically enrol
                        to our newsletter?</p>
                    <p>Besides receiving our weekly report, you will also have access to:</p>
                    <ul>
                        <li>Transaction Announcements Reports, a new feature that displays global reports since April
                            2017 that relate to transactions of mineral exploration properties, including property
                            acquisitions, company acquisitions and takeovers.
                        </li>
                        <li>Additional filters and search options</li>
                        <li>Custom reporting (currently being developed)</li>
                        <li>More</li>
                    </ul>
                </div>
                <div class="modal-footer" style="width:100%; margin-left:0px;">
                    <a href="/register?lid=1" id="subscribe-submit-btn"  class="btn
                    btn-primary">Register</a>
                </div>
                <br>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</form>


<!-- Subscribe Popup -->
<!--<form id="frm-subscribe-form" action="javascript:oInvitation.subscribe();">-->
<!--    <div class="modal fade" id="subscribe-modal" role="dialog" aria-labelledby="gridSystemModalLabel">-->
<!--        <div class="modal-dialog" role="document">-->
<!--            <div class="modal-content">-->
<!--                <div class="modal-header">-->
<!--                    <button type="button" id="close-subscribe-btn" class="close" data-dismiss="modal"-->
<!--                            aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
<!--                    <h4 class="modal-title" id="gridSystemModalLabel">Subscribe</h4>-->
<!--                </div>-->
<!--                <div class="modal-body">-->
<!--                    <div class="container-fluid">-->
<!-- tokken -->
<!--                        <input type="hidden" id="subscriber-token" name="subscriber-token"-->
<!--                               aria-describedby="sizing-addon1">-->
<!-- Name -->
<!--                        <div class="input-group input-group-lg">-->
<!--                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>-->
<!--                            <input type="text" class="form-control required" required id="subscriber-name"-->
<!--                                   name="subscriber-name"-->
<!--                                   placeholder="Name" aria-describedby="sizing-addon1">-->
<!--                        </div>-->

<!-- Email -->
<!--                        <div class="input-group input-group-lg">-->
<!--                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>-->
<!--                            <input style="border-bottom-left-radius: 0; border-top-left-radius: 0;margin-bottom: 0em;border: 1px solid #ccc; width:100%"-->
<!--                                   type="email" id="mce-EMAIL" class="form-control required" required name="EMAIL"-->
<!--                                   placeholder="Email" aria-describedby="sizing-addon1">-->
<!--                        </div>-->
<!--                        <p><input type="checkbox" name="group" value="1" id="one" class="subGroup" checked/> Resource-->
<!--                            Intelligence weekly report (50 per year)</p>-->
<!--                        <p><input type="checkbox" name="group" value="1" id="two" class="subGroup" checked/> Special-->
<!--                            reports (about four times a year)</p>-->
<!--                        <p><input type="checkbox" name="group" value="1" id="three" class="subGroup" checked/> RSC News-->
<!--                            (about four times a year)</p>-->
<!--                        <p><input type="checkbox" name="group" value="1" id="four" class="subGroup" checked/> New-->
<!--                            resource industry report types (occasional)</p>-->
<!--                        <p><input type="checkbox" name="group" value="1" id="five" class="subGroup" checked/> Special-->
<!--                            offers and other communication from RSC (about four times a year)</p>-->
<!---->
<!--                        <div class="subscribe-notification">-->
<!--                            <input class="not-left-nav" type="checkbox" name="weekly-summary-report"/>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="modal-footer" style="width:100%; margin-left:0px;">-->
<!--                    <p style="text-align: left">or <a href="/register">register here</a> to become a member and-->
<!--                        automatically subscribe.</p>-->
<!--                    <div class="processing" style="display: inline-block; width: 16px; margin-right: 4px;">-->
<!--                        <img src="--><?php //bloginfo('template_url'); ?><!--/intel/images/loading_ani.gif"-->
<!--                             style="margin: 0px ! important; display: none;">-->
<!--                    </div>-->
<!--                    <button id="subscribe-submit-btn" type="submit" class="btn btn-primary">Subscribe</button>-->
<!--                    <button type="button" class="btn btn-default" onclick="oInvitation.unsubscribe()">UnSubscribe-->
<!--                    </button>-->
<!---->
<!--                </div>-->
<!--                <br>-->
<!--            </div>-->
<!-- /.modal-content -->
<!--        </div>-->
<!-- /.modal-dialog -->
<!--    </div>-->
<!-- /.modal -->
<!--</form>-->
<!-- Download confirmation message -->
<div class="modal fade bs-example-modal-md" id="download-confirmation" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <p>Please confirm that you want to download this report. Your daily/weekly credit will be used when
                    proceeded.</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" style="background-color: #7B868C !important;outline: #7B868C !important;border-color: #7B868B !important;">No, thanks</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="javascript:oPdf.init();">
                    Yes, proceed
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Cancel current plan -->
<div class="modal fade bs-example-modal-md" id="cancel-plan2" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <span class="span-text-message">
                    Are you sure you want to cancel your GOLD subscription? Your subscription will automatically be downgraded to SILVER.
                </span>
                <p></p>
            </div>

            <div class="modal-footer" style="width:100%; margin-left:0px;">
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="cancel-curr-plan2"
                        style="margin-right:-16vw;background-color:#FC2020;">Yes
                </button>
                <button type="button" class="btn btn-primary" data-dismiss="modal"
                        style="margin-left:16vw;background-color:#428bca;">No
                </button>
            </div>
            <br>
        </div>
    </div>
</div>

<!-- Cancel current plan -->
<div class="modal fade bs-example-modal-md" id="cancel-plan3" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <span class="span-text-message">Are you sure you want to cancel your PLATINUM subscription? Your subscription will automatically be downgraded to SILVER.</span>
                <p></p>
            </div>

            <div class="modal-footer" style="width:100%; margin-left:0px;">
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="cancel-curr-plan3"
                        style="margin-right:-16vw;background-color:#FC2020;">Yes
                </button>
                <button type="button" class="btn btn-primary" data-dismiss="modal"
                        style="margin-left:16vw;background-color:#428bca;">No
                </button>
            </div>
            <br>
        </div>
    </div>
</div>

<!-- Upgrade your plan2 -->
<div class="modal fade bs-example-modal-md" id="upgrade-plan2" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <span class="span-text-message">Are you sure you want to change your plan?</span>
                <p></p>
            </div>

            <div class="modal-footer" style="width:100%; margin-left:0px;">
                <button type="button" class="btn btn-primary" id="upgrade-your-plan2" data-dismiss="modal" style="margin-right:-16vw;background-color:#FC2020;">Yes</button>
                <button id="upgrd-2-grey" type="button" class="btn btn-primary" data-dismiss="modal" style="margin-left:16vw;background-color:#FC2020;">No</button>
            </div>
            <br>
        </div>
    </div>
</div>

<!--Upgrade your plan3-->
<div class="modal fade bs-example-modal-md" id="upgrade-plan3" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <span class="span-text-message">Are you sure you want to change your plan?</span>
                <p></p>
            </div>

            <div class="modal-footer" style="width:100%; margin-left:0px;">
                <button type="button" class="btn btn-primary" id="upgrade-your-plan3" data-dismiss="modal" style="margin-right:-16vw;background-color:#FC2020;">Yes</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" style="margin-left:16vw;background-color:#FC2020;">No</button>
            </div>
            <br>
        </div>
    </div>
</div>


<!-- delete account confirmation message -->
<div class="modal fade bs-example-modal-md" id="pdf-modall" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <span class="span-text-message">Are you sure you want to delete this account?</span>
                <p></p>
            </div>

            <div class="modal-footer" style="width:100%; margin-left:0px;">
                <button type="button" class="btn btn-primary" id="delete-account-cnfrm"
                        style="margin-right:-16vw;background-color:#FC2020;">Yes
                </button>
                <button type="button" class="btn btn-primary" data-dismiss="modal"
                        style="margin-left:16vw;background-color:#428bca;">Cancel
                </button>
            </div>
            <br>
        </div>
    </div>
</div>

<!-- unsubscribe user  -->
<div class="modal fade bs-example-modal-md" id="unsub-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <span id="unsub-message">Do you want to remain subscribed to our newsletter(s)</span>
                <p></p>
            </div>

            <div class="modal-footer" style="width:100%; margin-left:0px;">
                <button type="button" class="btn btn-primary" id="remain-sub"
                        style="margin-right:-16vw;background-color:#FC2020;">Yes
                </button>
                <button type="button" class="btn btn-primary" id="unsub-me"
                        style="margin-left:16vw;background-color:#FC2020;">No, please unsubscribe to all
                </button>
            </div>
            <br>
        </div>
    </div>
</div>

<!-- Login Errors message -->
<div class="modal fade bs-example-modal-md" id="login-erorr-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <p>Your password or email is incorrect, please try again.</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="oRsc.Loginerrors()">Ok</button>
            </div>
        </div>
    </div>
</div>
<!-- Un-Subscribe Popup -->
<div class="modal fade bs-example-modal-md" id="un-subscribe-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <p>You have been successfully unsubscribed from our mailing list. We're sorry to see you go.
                    Feel free to contact us if you have any questions.</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>

<!-- General message -->
<div class="modal fade bs-example-modal-md" id="message-model" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <p>Sorry! Try again.</p>
            </div>
            <div class="modal-footer" style="width:100%; margin-left:0px;">
                <button type="button" class="btn btn-primary" data-dismiss="modal"
                        style="margin-left:16vw;background-color:#FC2020;">ok
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Feedback Button Modal -->
<div id="feedback-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header feedback-modal">
<!--                <button type="button" id="close-feedbacksubscribe-btn" class="close" data-dismiss="modal"-->
<!--                        aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
                <a href="#" class="remodal-close close-custom-modal-remodal" id="close-feedbacksubscribe-btn"></a>
                <h4 class="modal-title" id="gridSystemModalLabel" style="color:white">Send Feedback</h4>
            </div>
            <div class="modal-body">
                <form class="feedback" name="feedback">
                    <p style="font-size: 14px;text-align: justify;font-style: italic">We are always looking for ways to
                        improve our product. Have you noticed a mistake in our data or would you like to share an idea?
                        We would love to get your feedback.</p>
                    <div class="input-group input-group-lg" style="margin-bottom: 20px">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input style="border-bottom-left-radius: 0; font-size: 14px; border-top-left-radius: 0;margin-bottom: 0em;border: 1px solid #ccc; width:100%" type="text" id="from" class="form-control required" required name="name" value=""  placeholder="Name" >
                    </div>
                    <div class="input-group input-group-lg" style="margin-bottom: 20px">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input style="border-bottom-left-radius: 0;font-size: 14px; border-top-left-radius: 0;margin-bottom: 0em;border: 1px solid #ccc; width:100%"
                               type="email" id="email" class="form-control required" value="" required name="email"
                               placeholder="Email (Optional)" >
                    </div>
                    <div class="form-group">
                        <label for="comment" style="font-size: 14px">Comment:</label>
                        <textarea class="form-control" rows="5" name="message" id="review"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" id="submit" onclick="javascript:oRsc.SendFeedback();">Send</button>
            </div>
        </div>
    </div>
</div>
<!-- End -->
<div class="modal fade bs-example-modal-lg" id="my-activity-log-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" style="margin-left:315px;">
        <div class="modal-content">
            <div class="modal-body" style="background-color: lightgrey;">
                <!-- <div class="container"> -->
                <div class="row">
                    <div class="panel panel-primary filterable" style="width: 100%">
                        <div class="panel-heading">
                            <h3 class="panel-title">Users</h3>
                            <div class="pull-right">
                                <button class="btn btn-default btn-xs btn-filter"><span
                                            class="glyphicon glyphicon-filter"></span> Filter
                                </button>
                            </div>
                        </div>
                        <table class="table">
                            <thead>
                            <tr class="filters">
                                <th><input type="text" class="form-control" placeholder="#" disabled></th>
                                <th><input type="text" class="form-control" placeholder="Username" disabled></th>
                                <th><input type="text" class="form-control" placeholder="Log" disabled></th>
                                <th><input type="text" class="form-control" placeholder="action" disabled></th>
                                <th><input type="text" class="form-control" placeholder="status" disabled></th>
                            </tr>
                            </thead>
                            <tbody id="log-detail">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- </div> -->
<div style="display:none;" id="loading-spin-markers"></div>
</div>
