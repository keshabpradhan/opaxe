<!-- Load Disclaimer modal -->
<div data-remodal-id="modal"
     data-remodal-options="closeOnAnyClick: false, 'closeOnEscape': false, 'closeOnConfirm': false" id="disc-id-close">
    <img src="/wp-content/themes/fount/intel/images/opaxe-logo-transparent.png" width="150" alt="Opaxe"
         style="margin-bottom: 20px">
    <p style="text-align: justify">We monitor public resource development announcements and reports, from drilling assay
        results through resource estimation and feasibility studies, to environmental approvals for mine development. We
        display these reports on an interactive global map. We also display global reports published since April 2017
        relating to transactions of mineral exploration, resource development and mining properties including property
        and company acquisitions and takeovers. You can customise the plotted data by using various filters including;
        commodity, stock exchange, date, report type, reporting code and resource status. Click on a map marker to see a
        summary of a project report, from where you are able to access the full original company report.</p>
    <p>Please note, your use of this site is subject to our <a href="#" id="terms-services">Terms of Use</a>.</p>

    <?php
    $display_message = false;
    $today = getdate();
    if (($today['mday'] > 22 && $today['mon'] == 12)
        || ($today['mday'] < 3 && $today['mon'] == 1))
        $display_message = true;
    ?>

    <?php if ($display_message) { ?>
        <p style="color:red">The RSC-MI map will not be updated over the Christmas/New Year period. Updates will resume
            in the New Year from January 7th.</p>
    <?php } ?>
    <br>
    <a class="remodal-confirm" href="#" onclick="oRsc.setCookieSession();">Accept &amp; continue</a>
</div>
<!-- shore more link in mobile header message -->
<div data-remodal-id="show-more-link-mob"
     data-remodal-options="closeOnAnyClick: false, 'closeOnEscape': false, 'closeOnConfirm': false">
    <img style="width:80%;" src="/wp-content/themes/fount/intel/images/show-link-img.png">
    <br>
    <p style="text-align: justify;margin-top: 20px;">Please access the website via a large screen device to get access
        to our full range of reports plus the ability to select the data you require using various filters. Sign up for
        a free account and you'll have access to even more reports.</p>
    <br>
    <a class="remodal-confirm" href="#">Got it.</a>
</div>

<!-- registered reviewers modal -->
<div data-remodal-id="registered-reviewers"
     data-remodal-options="closeOnAnyClick: false, 'closeOnEscape': false, 'closeOnConfirm': false">
    <h3>RSC RESOURCE REPORTING INTELLIGENCE</h3>
    <p>RSC advises to exercise caution when carrying out reviews. Reviewers are to make sure they do not have a conflict
        of interest, whether perceived or real and RSC notes that providing anonymous reviews should under no
        circumstance be misused as a mechanism to bring into disrepute people, groups or companies. RSC advises each
        reviewer to obtain legal advice, particularly in regard to any personal or professional liability that may arise
        from using this site and the need for indemnity insurance.</p>
    <br>

    <a id="btn-rsc-advises" class="remodal-confirm" href="#" onclick="javascript:oRsc.updateConditionStatus();">Understood
        &amp; continue</a>
</div>

<script>
    /* open modal on page load */
</script>

<div id="map-wrapper">
    <div style="display:none;" id="loading-spin-markers"></div>
    <!-- Open map wrapper -->
    <!-- MAP SIDE BAR
  ================================== -->
    <!-- Login popup form -->
    <!--    <a href="#x" class="login-overlay" id="login_form"></a>-->
    <!--    <div class="login-popup">-->
    <!--        <p>Please enter your login and password here</p>-->
    <!--        <form id="login-form" action="javascript:login();">-->
    <!--            <input type="hidden" id="reportId" value="" />-->
    <!--            <div>-->
    <!--                <label for="username">Username:</label>-->
    <!--                <input type="text" id="username" value="" />-->
    <!--            </div>-->
    <!--            <div>-->
    <!--                <label for="password">Password:</label>-->
    <!--                <input type="password" id="password" value="" />-->
    <!--            </div>-->
    <!--            <input id="btn-login" type="submit" value="Login" />-->
    <!---->
    <!--        </form>-->
    <!---->
    <!--        <a class="login-close" href="#close"></a>-->
    <!--        <div class="login-msg">-->
    <!--            <p class="login-error">Error Password not match.</p>-->
    <!--            <p class="login-success">Successfully login.</p>-->
    <!--        </div>-->
    <!--    </div>-->
    <!-- End Login -->
    <?php include 'reviewed-scale.php'; ?>
    <?php include 'transaction-view.php'; ?>
    <div class="tooltip-popup-report">
        <img class="callout" src="<?php bloginfo('template_url'); ?>/intel/images/arrow.png" alt="Not Found"/>
        <p>Environmental- (Social) Impact Assessment. NB these are not technical reports.</p>
    </div>

    <div class="tooltip-popup" id="logout_popup">
        <img class="callout" src="/wp-content/themes/fount/intel/images/arrow.png"/>
        <p></p>
    </div>


    <div class="rating-popup"></div>
    <div class="map-sidebar-container hide-below-768px" id="map-sidebar-container">
        <form id="sidebarForm">
            <input type="hidden" id="nav-filter" name="nav-filter" value="All"/>
            <div class="sidebar sidebar-report">
                <!-- SHOW ALL OR FILTER -->

                <!--Todo: RSC-MI taking parts down-->
                <!--            <div id="loggedin">
                <div style="display: block;" id="logged-in">
                    <a id="hrefLogOut" style="display: none" href="#" onclick="javascript:oRsc.logout()">Logout</a>
                    <a id="hrefLogIn" href="#" onclick="javascript:oRsc.showLoginPopup();">Login</a>
                    <a href="faq.php" target="_blank">FAQ</a>
                    <a href="signup.php" target="_blank">Register</a>
                    <a href="expert-panel.php" target="_blank">Panel</a>
                </div>
                <?php
                /*                $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
                                */ ?>
                <div id="loign_details">
                    <div id="login_name" style=""><p>Logged in as :<span><a href="#"></a></span></p></div>
                    <div class="dropdown" style="float: right;">
                        <button class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <img width="50" height="50" src="<?php bloginfo('template_url'); ?>/intel/images/upload/dummy.png" class="img-circle" alt="avatar">
                        </button>
                    </div>

                </div>


            </div>
            <div style="clear: both;"></div>-->
                <!--Todo: END-->

                <!--            <h2 style="margin: 0;color:red;">MINERAL INTELLIGENCE</h2>-->
                <div class="sidebar-group sidebar-form-below-div2">
                    <div id="report_box">
                        <div id="reportbox_popup">
                        </div>
                    </div>
                </div>
                <!-- DATE -->
                <div id="filters" style="margin-top: 1em;">
                    <div class="region-button-header">
                        <a class="region-button region-button-on" id="region-button-world-sidebar"
                           style="padding: 4px 14px 4px 14px;float: left;">Technical Reports</a>
                        <a class="region-button region-button-off" value="T" id="region-button-trans-reports"
                           href="#"><i class="fa fa-dollar" style="display: none;"></i> Transaction Reports</a>
                    </div>
                    <div id="search-container">
                        <img class="rsc-search-loading"
                             src="<?php bloginfo('template_url'); ?>/intel/images/loading_ani.gif" alt="Not found">
                        <img class="rsc-search-icon" src="<?php bloginfo('template_url'); ?>/intel/images/search.png"
                             alt="Not found">
                        <input class="close-icon clear-search-icon" value="X" type="button"/>
                        <div class="search-dropdown">
                            <p class="search-category">Company</p>
                            <input type="text" id="search" name="search" onfocus="oRsc.searchonfocus();"
                                   placeholder=""/>
                            <div id="search-dropdown" class="search-dropdown-content">
                                <span>Company</span>
                                <span>Ticker</span>
                                <span>Project</span>
                                <!--<span>Consultant</span>-->
                            </div>
                            <div id="search-commodity-dropdown" class="search-commodity-dropdown-content">
                                <span>Gold</span><span>Aluminium</span><span>Diamonds</span>
                                <span>Silver</span><span>Cobalt</span><span>Graphite</span>
                                <span>PGM</span><span>Iron</span><span>Phosphate</span>
                                <span>Lithium</span><span>Potash</span><span>Molybdenum</span>
                                <span>Zircon</span><span>Niobium</span><span>Rare earth</span>
                                <span>Copper</span><span>Tantalum</span><span>Coal</span>
                                <span>Lead</span><span>Tin</span><span>Nickel</span>
                                <span>Titanium</span><span>Zinc</span><span>Tungsten</span>
                                <span>Uranium</span><span>Vanadium</span><span>Quartz</span>
                                <span>Potassium</span><span>Halloysite</span><span>Kaolinite</span>
                                <span>Halite</span><span>Aggregate</span><span>Alumina</span>
                                <span>Barite</span><span>n/a</span><span>Boron</span>
                                <span>Magnesite</span><span>Limestone</span><span>Rutile</span>
                                <span>Ilmenite</span><span>Clay</span><span>Platnium</span>
                                <span>Palladium</span><span>Ruthenium</span><span>Rhodium</span>
                                <span>Osmium</span><span>Iridium</span><span>Corundum</span>
                                <span>Heavy Metals</span><span>Gypsum</span><span>Gallium</span>
                                <span>Germanium</span><span>Chromite</span><span>Frac Sand</span>
                                <span>Scandium</span><span>Chromium</span><span>Kieserite</span>
                                <span>Wollastonite</span><span>Sapphire</span><span>Sand</span>
                                <span>Magnesium</span><span>Silica</span><span>Caesium</span>
                                <span>Magnetite</span><span>Zeolite</span><span>Sylvite</span>
                                <span>Flurospar</span><span>Polyhalite</span><span>Cesium</span>
                                <span>Rubidium</span><span>Heavy Mineral</span><span>Kaolin</span>
                                <span>Rock Salt</span><span>Ruby</span><span>Phosphorite</span>
                                <span>Pozzolan</span><span>Perlite</span><span>Feldspar</span>
                                <span>Antimony</span><span>Emerald</span><span>Apatite</span>
                                <span>Vermiculite</span><span>Manganese</span><span>Bauxite</span>
                                <span>Flourite</span><span>Fluorspar</span><span>Potassium chloride</span>
                            </div>
                        </div>
                        <a onclick="javascript:oRsc.searchOnly();" id="search-results-only">show search results only</a>


                    </div>
                    <!--                 <div class="circle-text-numbers circle-text-number-2">2</div>-->
                    <div class="block clear_filters">
                        <a class="save-preferences-link" id="save-preferences-link">Save current filters</a>
                        <div class="switch" style="display: none;">
                            <input type="checkbox" name="show-all" value="Show/hide all markers" id="show-all" checked
                                   class="cmn-toggle cmn-toggle-round">
                            <label for="show-all"></label>
                        </div>
                        <a id="clear_filters">Reset all filters</a>
                        <!--                     <div class="circle-text-numbers circle-text-number-3">3</div>-->
                    </div>
                    <div class="side-bar-filters">
                        <div class="sidebar-group" id="date_filter">
                            <label for="date-range" class="expander" id="isNonregUser"><p class="date_filter expander">
                                    Date Range:</p> <a id="clear-date" class="date-header-text date_filter"></a><span
                                        class="expander"></span></label>
                            <div class="content">
                                <!-- Expander will NOT WORK without this containing what it expands! -->
                                <div class="block date_filter">
                                    <!--                        Show all time:-->
                                    <div class="switch">
                                        <input type="checkbox" name="show-all-time" value="show-all-time"
                                               id="show-all-time" checked
                                               class="rsc-select-all cmn-toggle cmn-toggle-round">
                                        <label for="show-all-time"></label>
                                    </div>
                                    <div class="block date-filter">
                                        <a href="#" id="show-last-week" class="date-filters">Last 7</a>
                                        <a href="#" id="show-last-month" class="date-filters"> 30</a>
                                        <a href="#" id="show-allll" class="date-filters"> 365 days</a>
                                        <a href="#" id="all-reports" class="date-filters" title="since Oct 2014">all</a>
                                        <a href="#" id="last-visit" class="date-filters" style="width:48%">since my last
                                            visit</a>
                                    </div>
                                </div>
                                <div class="block">
                                    <span class="min-width-50px">From:</span>
                                    <input type="text" name="from-date" id="from-date" class="rsc-text"/>
                                </div>
                                <div class="block">
                                    <span class="min-width-50px">To:</span>
                                    <input type="text" name="to-date" id="to-date" class="rsc-text"/><span
                                            class="select-custom-date">select</span>
                                </div>
                                <div id="date-range-error">
                                    <p>Please select valid date range.</p>
                                </div>
                            </div>
                        </div>
                        <!-- Project Status -->
                        <div class="sidebar-group" id="proj_status">
                            <label for="proj_status" class="expander"><p class="proj_status expander">Project
                                    Status: </p><a class="reset-filter-link proj_status">Reset filter</a><span
                                        class="expander"></span>
                            </label>
                            <div id="prjStatus-content" class="content">
                                <!--                    <div class="block">-->
                                <!--                        Select all:-->
                                <!--                        <div class="switch">-->
                                <!--                            <input  type="checkbox"  id="uncheck-all-pstatus" checked  class="rsc-select-all cmn-toggle cmn-toggle-round">-->
                                <!--                            <label for="uncheck-all-pstatus"></label>-->
                                <!--                        </div>-->
                                <!--                    </div>-->
                                <div class="block proj_status">
                                    <input type="checkbox" name="proj_status[]" value="Exploration"
                                           id="pstatus-exploration" class="uncheck-all uncheck-all-pstatus"
                                           checked/><span id="pstatus-exploration"
                                                          class="new_filters">Exploration Stage</span>
                                    <img class="resource-icon"
                                         src="/wp-content/themes/fount/intel/images/icons/rsc-resource-unchanged.png"
                                         alt="RSC unchanged resource icon"/>
                                </div>
                                <div class="block proj_status">
                                    <input type="checkbox" name="proj_status[]" value="resource definition"
                                           id="pstatus-Rdef" class="uncheck-all uncheck-all-pstatus" checked/><span
                                            id="pstatus-Rdef" class="new_filters">Resource Development</span>
                                    <img class="resource-icon"
                                         src="/wp-content/themes/fount/intel/images/icons/rsc-resource-updated.png"
                                         alt="RSC updated resource icon"/>
                                </div>
                                <div class="block proj_status">
                                    <input type="checkbox" name="proj_status[]" value="Mining" id="pstatus-minig"
                                           class="uncheck-all uncheck-all-pstatus" checked/> <span id="pstatus-minig"
                                                                                                   class="new_filters">Mining</span>
                                    <img class="resource-icon"
                                         src="/wp-content/themes/fount/intel/images/icons/rsc-resource-upgraded.png"
                                         alt="RSC upgraded resource icon"/>
                                </div>
                            </div>
                        </div>
                        <!-- COMMODITY -->
                        <!--                 <a class="reset-filter-link commodity-group">Reset filter</a>-->
                        <div class="sidebar-group" id="commodity-group">
                            <label for="commodity" class="expander" id="isNonreg"><p
                                        class="commodity-reset-filter expander">Commodity:</p> <a id="clear-commodities"
                                                                                                  class="reset-filter-link commodity-reset-filter">Reset filter</a><span class="expander"></span>
                            </label>
                            <div id="commodity-content" class="content">
                                <div id="commodity-select-all" class="block commodity-reset-filter">

                                    <div class="switch">
                                        <input type="checkbox" id="uncheck-all-commodities" checked
                                               class="rsc-select-all cmn-toggle cmn-toggle-round">
                                        <label for="uncheck-all-commodities"></label>
                                    </div>
                                </div>
                                <table class="sidebar-commodity-table">
                                    <tr>
                                        <td><span> Precious Metals </span></td>
                                        <td><span> Other Metals </span></td>
                                        <td><span> Industrial Minerals </span></td>
                                    </tr>

                                    <tr>
                                        <td class="Gold commodity-reset-filter"><input type="checkbox"
                                                                                       name="commodity[]" value="Gold"
                                                                                       id="commodity-g"
                                                                                       class="uncheck-all uncheck-all-commodities"
                                                                                       checked/><span id="commodity-g"
                                                                                                      class="new_filters commodity-filters">Gold</span>
                                        </td>
                                        <td class="Aluminium commodity-reset-filter"><input type="checkbox"
                                                                                            name="commodity[]"
                                                                                            value="Aluminium"
                                                                                            id="commodity-aluminium"
                                                                                            class="uncheck-all uncheck-all-commodities"
                                                                                            checked/> <span
                                                    id="commodity-aluminium" class="new_filters commodity-filters">Aluminium</span>
                                        </td>
                                        <td class="Diamonds commodity-reset-filter"><input type="checkbox"
                                                                                           name="commodity[]"
                                                                                           value="Diamonds"
                                                                                           id="commodity-diamonds"
                                                                                           class="uncheck-all uncheck-all-commodities"
                                                                                           checked/> <span
                                                    id="commodity-diamonds" class="new_filters commodity-filters">Diamonds</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="Silver commodity-reset-filter"><input type="checkbox"
                                                                                         name="commodity[]"
                                                                                         value="Silver"
                                                                                         id="commodity-silver"
                                                                                         class="uncheck-all uncheck-all-commodities"
                                                                                         checked/> <span
                                                    id="commodity-silver"
                                                    class="new_filters commodity-filters">Silver</span></td>
                                        <td class="Cobalt commodity-reset-filter"><input type="checkbox"
                                                                                         name="commodity[]"
                                                                                         value="Cobalt"
                                                                                         id="commodity-cobalt"
                                                                                         class="uncheck-all uncheck-all-commodities"
                                                                                         checked/> <span
                                                    id="commodity-cobalt"
                                                    class="new_filters commodity-filters">Cobalt</span></td>
                                        <td class="Graphite commodity-reset-filter"><input type="checkbox"
                                                                                           name="commodity[]"
                                                                                           value="Graphite"
                                                                                           id="commodity-graphite"
                                                                                           class="uncheck-all uncheck-all-commodities"
                                                                                           checked/> <span
                                                    id="commodity-graphite" class="new_filters commodity-filters">Graphite</span>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td class="PGM commodity-reset-filter"><input type="checkbox" name="commodity[]"
                                                                                      value="PGM" id="commodity-pgm"
                                                                                      class="uncheck-all uncheck-all-commodities"
                                                                                      checked/><span id="commodity-pgm"
                                                                                                     class="new_filters commodity-filters">PGM<div
                                                        class="tooltip" id="tooltip-pgm">(<span>i</span>)</div></span>
                                        </td>
                                        <td class="Iron commodity-reset-filter"><input type="checkbox"
                                                                                       name="commodity[]" value="Iron"
                                                                                       id="commodity-iron"
                                                                                       class="uncheck-all uncheck-all-commodities"
                                                                                       checked/> <span
                                                    id="commodity-iron"
                                                    class="new_filters commodity-filters">Iron</span></td>
                                        <td class="Phosphate commodity-reset-filter"><input type="checkbox"
                                                                                            name="commodity[]"
                                                                                            value="Phosphate"
                                                                                            id="commodity-phosphate"
                                                                                            class="uncheck-all uncheck-all-commodities"
                                                                                            checked/> <span
                                                    id="commodity-phosphate" class="new_filters commodity-filters">Phosphate</span>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td class="Lithium commodity-reset-filter"><input type="checkbox"
                                                                                          name="commodity[]"
                                                                                          value="Lithium"
                                                                                          id="commodity-lithium"
                                                                                          class="uncheck-all uncheck-all-commodities"
                                                                                          checked/> <span
                                                    id="commodity-lithium"
                                                    class="new_filters commodity-filters">Lithium</span></td>
                                        <td class="Potash commodity-reset-filter"><input type="checkbox"
                                                                                         name="commodity[]"
                                                                                         value="Potash"
                                                                                         id="commodity-potash"
                                                                                         class="uncheck-all uncheck-all-commodities"
                                                                                         checked/> <span
                                                    id="commodity-potash"
                                                    class="new_filters commodity-filters">Potash</span></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td class="Molybdenum commodity-reset-filter"><input type="checkbox"
                                                                                             name="commodity[]"
                                                                                             value="Molybdenum"
                                                                                             id="commodity-molybdenum"
                                                                                             class="uncheck-all uncheck-all-commodities"
                                                                                             checked/> <span
                                                    id="commodity-molybdenum" class="new_filters commodity-filters">Molybdenum</span>
                                        </td>
                                        <td class="Zircon commodity-reset-filter"><input type="checkbox"
                                                                                         name="commodity[]"
                                                                                         value="Zircon"
                                                                                         id="commodity-zircon"
                                                                                         class="uncheck-all uncheck-all-commodities"
                                                                                         checked/> <span
                                                    id="commodity-zircon"
                                                    class="new_filters commodity-filters">Zircon</span></td>

                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td class="Niobium commodity-reset-filter"><input type="checkbox"
                                                                                          name="commodity[]"
                                                                                          value="Niobium"
                                                                                          id="commodity-niobium"
                                                                                          class="uncheck-all uncheck-all-commodities"
                                                                                          checked/> <span
                                                    id="commodity-niobium"
                                                    class="new_filters commodity-filters">Niobium</span></td>

                                    </tr>
                                    <tr>
                                        <td><span> Base Metals </span></td>
                                        <td class="earth commodity-reset-filter"><input type="checkbox"
                                                                                        name="commodity[]"
                                                                                        value="Rare earth"
                                                                                        id="commodity-rare-earth"
                                                                                        class="uncheck-all uncheck-all-commodities"
                                                                                        checked/> <span
                                                    id="commodity-rare-earth" class="new_filters commodity-filters">Rare earth</span>
                                        </td>
                                        <td><span> Mineral fuels </span></td>
                                    </tr>
                                    <tr>
                                        <td class="Copper commodity-reset-filter"><input type="checkbox"
                                                                                         name="commodity[]"
                                                                                         value="Copper"
                                                                                         id="commodity-copper"
                                                                                         class="uncheck-all uncheck-all-commodities"
                                                                                         checked/> <span
                                                    id="commodity-copper"
                                                    class="new_filters commodity-filters">Copper</span></td>
                                        <td class="Tantalum commodity-reset-filter"><input type="checkbox"
                                                                                           name="commodity[]"
                                                                                           value="Tantalum"
                                                                                           id="commodity-tantalum"
                                                                                           class="uncheck-all uncheck-all-commodities"
                                                                                           checked/> <span
                                                    id="commodity-tantalum" class="new_filters commodity-filters">Tantalum</span>
                                        </td>
                                        <td class="Coal commodity-reset-filter"><input type="checkbox"
                                                                                       name="commodity[]" value="Coal"
                                                                                       id="commodity-coal"
                                                                                       class="uncheck-all uncheck-all-commodities"
                                                                                       checked/> <span
                                                    id="commodity-coal"
                                                    class="new_filters commodity-filters">Coal</span></td>
                                    </tr>
                                    <tr>
                                        <td class="Lead commodity-reset-filter"><input type="checkbox"
                                                                                       name="commodity[]" value="Lead"
                                                                                       id="commodity-lead"
                                                                                       class="uncheck-all uncheck-all-commodities"
                                                                                       checked/> <span
                                                    id="commodity-lead"
                                                    class="new_filters commodity-filters">Lead</span></td>
                                        <td class="Tin commodity-reset-filter"><input type="checkbox" name="commodity[]"
                                                                                      value="Tin" id="commodity-tin"
                                                                                      class="uncheck-all uncheck-all-commodities"
                                                                                      checked/> <span id="commodity-tin"
                                                                                                      class="new_filters commodity-filters">Tin</span>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="Nickel commodity-reset-filter"><input type="checkbox"
                                                                                         name="commodity[]"
                                                                                         value="Nickel"
                                                                                         id="commodity-nickel"
                                                                                         class="uncheck-all uncheck-all-commodities"
                                                                                         checked/> <span
                                                    id="commodity-nickel"
                                                    class="new_filters commodity-filters">Nickel</span></td>
                                        <td class="Titanium commodity-reset-filter"><input type="checkbox"
                                                                                           name="commodity[]"
                                                                                           value="Titanium"
                                                                                           id="commodity-titanium"
                                                                                           class="uncheck-all uncheck-all-commodities"
                                                                                           checked/> <span
                                                    id="commodity-titanium" class="new_filters commodity-filters">Titanium</span>
                                        </td>
                                        <td><span> Other </span></td>
                                    </tr>
                                    <tr>
                                        <td class="Zinc commodity-reset-filter"><input type="checkbox"
                                                                                       name="commodity[]" value="Zinc"
                                                                                       id="commodity-zinc"
                                                                                       class="uncheck-all uncheck-all-commodities"
                                                                                       checked/> <span
                                                    id="commodity-zinc"
                                                    class="new_filters commodity-filters">Zinc</span></td>
                                        <td class="Tungsten commodity-reset-filter"><input type="checkbox"
                                                                                           name="commodity[]"
                                                                                           value="Tungsten"
                                                                                           id="commodity-tungsten"
                                                                                           class="uncheck-all uncheck-all-commodities"
                                                                                           checked/> <span
                                                    id="commodity-tungsten" class="new_filters commodity-filters">Tungsten</span>
                                        </td>
                                        <td class="Other commodity-reset-filter"><input type="checkbox"
                                                                                        name="commodity[]" value="Other"
                                                                                        id="commodity-other"
                                                                                        class="uncheck-all uncheck-all-commodities"
                                                                                        checked/> <span
                                                    id="commodity-other"
                                                    class="new_filters commodity-filters">Other</span></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td class="Uranium commodity-reset-filter"><input type="checkbox"
                                                                                          name="commodity[]"
                                                                                          value="Uranium"
                                                                                          id="commodity-uranium"
                                                                                          class="uncheck-all uncheck-all-commodities"
                                                                                          checked/> <span
                                                    id="commodity-uranium"
                                                    class="new_filters commodity-filters">Uranium</span></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td class="Vanadium commodity-reset-filter"><input type="checkbox"
                                                                                           name="commodity[]"
                                                                                           value="Vanadium"
                                                                                           id="commodity-vanadium"
                                                                                           class="uncheck-all uncheck-all-commodities"
                                                                                           checked/> <span
                                                    id="commodity-vanadium" class="new_filters commodity-filters">Vanadium</span>
                                        </td>
                                        <td></td>
                                    </tr>
                                </table>
                                <p id="commodity-tip">*Tip: use the search bar for any commodity not listed.</p>
                            </div>
                        </div>

                        <!--    Stock Exchange -->
                        <div class="sidebar-group" id="stock-exchange">
                            <label for="stockExchange" class="expander"><p class="stock-exchange expander">Stock
                                    Exchange:</p> <a class="reset-filter-link stock-exchange">Reset filter</a><span
                                        class="expander"></span></label>
                            <div class="content" id="stockExchange-all-div">
                                <div class="block stock-exchange">
                                    <!--                                  Select all:-->
                                    <div class="switch">
                                        <input type="checkbox" id="uncheck-all-stockExchange" checked
                                               class="rsc-select-all cmn-toggle cmn-toggle-round">
                                        <label for="uncheck-all-stockExchange"></label>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>
                                <div class="block stock-exchange">
                                    <input type="checkbox" name="stock-exchange[]" value="TSX-V" id="TSX-V"
                                           class="uncheck-all uncheck-all-stockExchange" checked/> <span id="TSX-V"
                                                                                                         class="new_filters">TSX Venture Exchange</span>
                                </div>
                                <div class="block stock-exchange">
                                    <input type="checkbox" name="stock-exchange[]" value="TSX" id="stock-exchange-TSX"
                                           class="uncheck-all uncheck-all-stockExchange" checked/> <span
                                            id="stock-exchange-TSX" class="new_filters stock-exchange">Toronto Stock Exchange</span>
                                </div>
                                <div class="block stock-exchange">
                                    <input type="checkbox" name="stock-exchange[]" value="ASX" id="stock-exchange-ASX"
                                           class="uncheck-all uncheck-all-stockExchange" checked/> <span
                                            id="stock-exchange-ASX" class="new_filters stock-exchange">Australian Securities Exchange</span>
                                </div>
                                <div class="block stock-exchange">
                                    <input type="checkbox" name="stock-exchange[]" value="FWB" id="stock-exchange-FWB"
                                           class="uncheck-all uncheck-all-stockExchange" checked/> <span
                                            id="stock-exchange-FWB" class="new_filters stock-exchange">Frankfurt Stock Exchange</span>
                                </div>
                                <div class="block stock-exchange">
                                    <input type="checkbox" name="stock-exchange[]" value="LSE" id="stock-exchange-LSE"
                                           class="uncheck-all uncheck-all-stockExchange" checked/> <span
                                            id="stock-exchange-LSE" class="new_filters stock-exchange">London Stock Exchange</span>
                                </div>
                                <div class="block stock-exchange">
                                    <input type="checkbox" name="stock-exchange[]" value="CSE" id="stock-exchange-CSE"
                                           class="uncheck-all uncheck-all-stockExchange" checked/><span
                                            id="stock-exchange-CSE" class="new_filters stock-exchange"> Canadian Securities Exchange</span>
                                </div>
                                <div class="block stock-exchange">
                                    <input type="checkbox" name="stock-exchange[]" value="OTCQB"
                                           id="stock-exchange-OTC-Markets" class="uncheck-all uncheck-all-stockExchange"
                                           checked/> <span id="stock-exchange-OTC-Markets"
                                                           class="new_filters stock-exchange">OTC Markets</span>
                                </div>
                                <div class="block stock-exchange">
                                    <input type="checkbox" name="stock-exchange[]" value="NYSE" id="stock-exchange-NYSE"
                                           class="uncheck-all uncheck-all-stockExchange" checked/> <span
                                            id="stock-exchange-NYSE" class="new_filters stock-exchange">New York Stock Exchange</span>
                                </div>
                                <div class="block stock-exchange">
                                    <input type="checkbox" name="stock-exchange[]" value="JSE" id="stock-exchange-JSE"
                                           class="uncheck-all uncheck-all-stockExchange" checked/> <span
                                            id="stock-exchange-JSE"
                                            class="new_filters stock-exchange">JSE Limited</span>
                                </div>
                                <div class="block stock-exchange">
                                    <input type="checkbox" name="stock-exchange[]" value="otherStockExchange"
                                           id="stock-exchange-others" class="uncheck-all uncheck-all-stockExchange"
                                           checked/> <span id="stock-exchange-others"
                                                           class="new_filters stock-exchange">All other Stock Exchanges</span>
                                </div>
                                <div class="block stock-exchange">
                                    <input type="checkbox" name="stock-exchange[]" value="Private"
                                           id="stock-exchange-Private" class="uncheck-all uncheck-all-stockExchange"
                                           checked/> <span id="stock-exchange-Private"
                                                           class="new_filters stock-exchange">Private</span>
                                </div>
                            </div>
                        </div>
                        <!-- REPORT CODE -->
                        <div class="sidebar-group" id="report-code-group">
                            <label for="report-code" class="expander"><p class="report-code-group expander">Report
                                    Code:</p> <a class="reset-filter-link report-code-group">Reset filter</a><span
                                        class="expander"></span>
                            </label>
                            <div class="content">
                                <div class="block report-code-group">
                                    <!--                        Select all:-->
                                    <div class="switch">
                                        <input type="checkbox" id="uncheck-all-codes" checked
                                               class="rsc-select-all cmn-toggle cmn-toggle-round">
                                        <label for="uncheck-all-codes"></label>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>
                                <div class="block report-code-group">
                                    <input type="checkbox" name="codes[]" value="JORC" id="code-jorc"
                                           class="uncheck-all uncheck-all-codes" checked/> <span id="code-jorc"
                                                                                                 class="new_filters">JORC</span>
                                    <div class="report-code-icon">J</div>
                                </div>
                                <div class="block report-code-group">
                                    <input type="checkbox" name="codes[]" value="NI43-101" id="code-ni-43-101"
                                           class="uncheck-all uncheck-all-codes" checked/> <span id="code-ni-43-101"
                                                                                                 class="new_filters">NI 43-101</span>
                                    <div class="report-code-icon">N</div>
                                </div>
                                <div class="block report-code-group">
                                    <input type="checkbox" name="codes[]" value="(Enviro)" id="code-environmental"
                                           class="uncheck-all uncheck-all-codes" checked/> <span id="code-environmental"
                                                                                                 class="new_filters">(Environmental report)</span>
                                    <div class="report-code-icon">E</div>
                                </div>
                                <div class="block report-code-group">
                                    <input type="checkbox" name="codes[]" value="other" id="code-other"
                                           class="uncheck-all uncheck-all-codes" checked/> <span id="code-other"
                                                                                                 class="new_filters">(Other code)</span>
                                    <div class="report-code-icon">O</div>
                                </div>
                            </div>
                        </div>
                        <!-- REPORT TYPE -->
                        <div class="sidebar-group" id="report-type-group">
                            <label for="report-type" class="expander"><p class="report-type-group expander">Report
                                    Type:</p> <a class="reset-filter-link report-type-group">Reset filter </a><span
                                        class="expander"></span>
                            </label>
                            <div class="content">
                                <div class="block report-type-group">
                                    <!--                        Select all:-->
                                    <div class="switch">
                                        <input type="checkbox" id="uncheck-all-types" checked
                                               class="rsc-select-all cmn-toggle cmn-toggle-round">
                                        <label for="uncheck-all-types"></label>
                                    </div>
                                </div>
                                <div class="block report-type-group">
                                    <input type="checkbox" name="report-type[]" value="Exploration/Drilling Update"
                                           id="type-exploration-update" class="uncheck-all uncheck-all-types" checked/>
                                    <span id="type-exploration-update" class="new_filters">Exploration Update</span>
                                </div>
                                <div class="block report-type-group">
                                    <input type="checkbox" name="report-type[]" value="Resource Estimation"
                                           id="type-resource-estimation" class="uncheck-all uncheck-all-types" checked/>
                                    <span id="type-resource-estimation" class="new_filters">Resource Estimate</span>
                                </div>
                                <div class="block report-type-group">
                                    <input type="checkbox" name="report-type[]" value="PEA"
                                           id="type-Scoping-Study-and-pea" class="uncheck-all uncheck-all-types"
                                           checked/> <span id="type-Scoping-Study-and-pea" class="new_filters">Scoping Study / PEA<div
                                                class="tooltip"
                                                id="tooltip-Scoping-Study-and-pea">(<span> i </span>)</div></span>

                                </div>
                                <div class="block report-type-group">
                                    <input type="checkbox" name="report-type[]" value="Pre-Feasibility Study"
                                           id="type-pre-feasibility" class="uncheck-all uncheck-all-types" checked/>
                                    <span id="type-pre-feasibility" class="new_filters">Pre-Feasibility</span>
                                </div>
                                <div class="block report-type-group">
                                    <input type="checkbox" name="report-type[]" value="Feasibility Study"
                                           id="type-feasibility" class="uncheck-all uncheck-all-types" checked/> <span
                                            id="type-feasibility" class="new_filters">Feasibility</span>
                                </div>
                                <div class="block report-type-group">
                                    <input type="checkbox" name="report-type[]" value="EIA/ESIA" id="type-eia-esia"
                                           class="uncheck-all uncheck-all-types" checked/> <span id="type-eia-esia"
                                                                                                 class="new_filters">EIA/ESIA<div
                                                class="tooltip" id="tooltip-eia-esia">(<span> i </span>)</div></span>

                                </div>
                                <div class="block report-type-group">
                                    <input type="checkbox" name="report-type[]" value="Optimisation Study"
                                           id="type-optimisation-study" class="uncheck-all uncheck-all-types" checked/>
                                    <span id="type-optimisation-study" class="new_filters">Optimisation Study<div
                                                class="tooltip" id="tooltip-optimisation-study">(<span> i </span>)</div></span>

                                </div>
                                <div class="block report-type-group">
                                    <input type="checkbox" name="report-type[]" value="Supporting Acquisition"
                                           id="type-supporting-acquisition" class="uncheck-all uncheck-all-types"
                                           checked/> <span id="type-supporting-acquisition" class="new_filters">Supporting Acquisition</span>
                                </div>
                                <!--<p class="small-text">* Environmental Impact Assessments are not technical reports.</p>-->
                            </div>
                        </div>

                        <!-- Report Format -->
                        <div class="sidebar-group" id="report-type-format">
                            <label for="report-type-format" class="expander"><p class="report-type-format expander">Report Format:</p> <a class="reset-filter-link report-type-format">Reset filter</a><span class="expander"></span>
                            </label>
                            <div class="content">
                                <div class="block report-type-format">
                                    <!--                        Select all:-->
                                    <div class="switch">
                                        <input type="checkbox" id="uncheck-all-format" checked
                                               class="rsc-select-all cmn-toggle cmn-toggle-round">
                                        <label for="uncheck-all-format"></label>
                                    </div>
                                </div>
                                <div class="block report-type-format">
                                    <input type="checkbox" name="report-format[]" value="Market Announcement"
                                           id="format-market-announcement" class="uncheck-all uncheck-all-format"
                                           checked/> <span id="format-market-announcement" class="new_filters">Market Announcement</span>
                                </div>
                                <div class="block report-type-format">
                                    <input type="checkbox" name="report-format[]" value="Full Technical Report"
                                           id="format-full-technical" class="uncheck-all uncheck-all-format" checked/>
                                    <span id="format-full-technical" class="new_filters">Full Technical Report</span>
                                </div>
                            </div>
                        </div>

                        <!-- Value Range -->
                        <div class="sidebar-group" id="report-value_range">
                            <label for="report-value_range" class="expander"><p class="report-value_range expander">Value Range:</p> <a class="reset-filter-link report-value_range">Reset filter</a><span class="expander"></span>
                            </label>
                            <div class="content">
                                <div class="block report-value_range">
                                    <!--                                  Select all:-->
                                    <div class="switch">
                                        <input type="checkbox" id="uncheck-all-range" checked
                                               class="rsc-select-all cmn-toggle cmn-toggle-round">
                                        <label for="uncheck-all-range"></label>
                                    </div>
                                </div>
                                <div class="block report-value_range">
                                    <input type="checkbox" name="value_range[]" value="$100''000 or less"
                                           id="ten-thousand-orless" class="uncheck-all uncheck-all-range" checked/>
                                    <span id="ten-thousand-orless" class="new_filters">$100,000 or less</span>
                                </div>
                                <div class="block report-value_range">
                                    <input type="checkbox" name="value_range[]" value="$100''000 - $1''000''000"
                                           id="ten-to-lac" class="uncheck-all uncheck-all-range" checked/> <span
                                            id="ten-to-lac" class="new_filters">$100,000 - $1,000,000</span>
                                </div>
                                <div class="block report-value_range">
                                    <input type="checkbox" name="value_range[]" value="over $1''000''000" id="over-ten"
                                           class="uncheck-all uncheck-all-range" checked/> <span id="over-ten"
                                                                                                 class="new_filters">over $1,000,000</span>
                                </div>
                                <div class="block report-value_range">
                                    <input type="checkbox" name="value_range[]" value="not stated" id="not-stated"
                                           class="uncheck-all uncheck-all-range" checked/> <span id="not-stated"
                                                                                                 class="new_filters">not stated</span>
                                </div>
                                <div class="block report-value_range">
                                    <input type="checkbox" name="value_range[]" value="n/a" id="n/a"
                                           class="uncheck-all uncheck-all-range" checked/> <span id="n/a"
                                                                                                 class="new_filters">n/a</span>
                                </div>
                            </div>
                        </div>

                        <!--             PROJECT STAGE-->
                        <div class="sidebar-group" id="project-stage-group" style="display: none;">
                            <label for="report-type" class="expander"><p class="project-stage-group expander">Project
                                    Stage:</p> <a class="reset-filter-link project-stage-group">Reset filter</a><span
                                        class="expander"></span>
                            </label>
                            <div class="content">
                                <div class="block project-stage-group">
                                    <!--                        Select all:-->
                                    <div class="switch">
                                        <input type="checkbox" id="uncheck-all-stages" checked
                                               class="rsc-select-all cmn-toggle cmn-toggle-round">
                                        <label for="uncheck-all-stages"></label>
                                    </div>
                                </div>
                                <div class="block project-stage-group">
                                    <input type="checkbox" name="project-stage[]" value="exploration"
                                           id="project-exploration" class="uncheck-all uncheck-all-stages" checked/>
                                    <span id="project-exploration" class="new_filters">Exploration</span>
                                    <!-- <div class="project-stage-icon">E</div>-->
                                    <img class="resource-icon" src="/wp-content/themes/fount/intel/images/icons/rsc-resource-unchanged.png" alt="RSC unchanged resource icon">
                                </div>
                                <div class="block project-stage-group">
                                    <input type="checkbox" name="project-stage[]" value="resource development"
                                           id="project-resource-development" class="uncheck-all uncheck-all-stages"
                                           checked/> <span id="project-resource-development" class="new_filters">Resource Development</span>
                                    <!--  <div class="project-stage-icon">R</div>-->
                                    <img class="resource-icon" src="/wp-content/themes/fount/intel/images/icons/rsc-resource-updated.png" alt="RSC updated resource icon">

                                </div>
                                <div class="block project-stage-group">
                                    <input type="checkbox" name="project-stage[]" value="mining" id="project-mining"
                                           class="uncheck-all uncheck-all-stages" checked/> <span id="project-mining"
                                                                                                  class="new_filters">Mining</span>
                                    <!-- <div class="project-stage-icon">M</div>-->
                                    <img class="resource-icon" src="/wp-content/themes/fount/intel/images/icons/rsc-resource-upgraded.png" alt="RSC upgraded resource icon">

                                </div>
                                <div class="block project-stage-group">
                                    <input type="checkbox" name="project-stage[]" value="care and maintenance"
                                           id="project-care" class="uncheck-all uncheck-all-stages" checked/> <span
                                            id="project-care" class="new_filters">Care and Maintenance</span>

                                    <!-- <div class="project-stage-icon">C</div>-->

                                    <img class="resource-icon" src="/wp-content/themes/fount/intel/images/icons/rsc-resource-upgraded.png" alt="RSC upgraded resource icon">

                                </div>

                                <div class="block project-stage-group">
                                    <input type="checkbox" name="project-stage[]" value="n/a"
                                           id="project-not-applicable" class="uncheck-all uncheck-all-stages" checked/>
                                    <span id="project-not-applicable" class="new_filters">Others (not specified)</span>
                                    <!--  <div class="project-stage-icon">T</div> -->
                                    <img class="resource-icon" src="/wp-content/themes/fount/intel/images/icons/rsc-resource-upgraded.png" alt="RSC upgraded resource icon">
                                </div>
                            </div>
                        </div>
                        <!-- Transaction Type -->
                        <div class="sidebar-group" id="transaction-type-group" style="display: none;">
                            <label for="report-type" class="expander"><p class="transaction-type-group expander">Transaction Type:</p> <a class="reset-filter-link transaction-type-group">Reset filter</a><span class="expander"></span>
                            </label>
                            <div class="content" id="reserve-all-div">
                                <div class="block transaction-type-group">
                                    <!--                        Select all:-->
                                    <div class="switch">
                                        <input type="checkbox" id="uncheck-all-transactions" checked
                                               class="rsc-select-all cmn-toggle cmn-toggle-round">
                                        <label for="uncheck-all-transactions"></label>
                                    </div>
                                </div>
                                <div class="block transaction-type-group">
                                    <input type="checkbox" name="transaction-type[]" value="Project Acquisition"
                                           id="type-project-acquisition" class="uncheck-all uncheck-all-transactions"
                                           checked/><span id="type-project-acquisition" class="new_filters"> Project Acquisition</span>
                                </div>
                                <div class="block transaction-type-group">
                                    <input type="checkbox" name="transaction-type[]" value="Company Acquisition"
                                           id="type-company-acquisition" class="uncheck-all uncheck-all-transactions"
                                           checked/> <span id="type-company-acquisition" class="new_filters">Company Acquisition</span>
                                </div>
                                <div class="block transaction-type-group">
                                    <input type="checkbox" name="transaction-type[]" value="JV MOU Announcement"
                                           id="type-mou-announcement" class="uncheck-all uncheck-all-transactions"
                                           checked/> <span id="type-mou-announcement" class="new_filters">Partial Project Sale/JV</span>
                                </div>
                                <!--                    <div class="block">-->
                                <!--                        <input type="checkbox" name="transaction-type[]" value="Option agreement" id="type-option-agreement" class="uncheck-all uncheck-all-transactions" checked /> Option Agreement-->
                                <!--                    </div>-->
                                <div class="block transaction-type-group">
                                    <input type="checkbox" name="transaction-type[]" value="Royalty Agreement"
                                           id="type-royalty-agreement" class="uncheck-all uncheck-all-transactions"
                                           checked/> <span id="type-royalty-agreement" class="new_filters">Royalty Agreement</span>
                                </div>
                                <div class="block transaction-type-group">
                                    <input type="checkbox" name="transaction-type[]" value="Mining Leases and Claims"
                                           id="type-mining-leases" class="uncheck-all uncheck-all-transactions"
                                           checked/> <span id="type-mining-leases" class="new_filters">Mining Leases and Claims</span>
                                </div>
                                <div class="block transaction-type-group">
                                    <input type="checkbox" name="transaction-type[]"
                                           value="Milling & Profit Share Agreement" id="type-milling-profit"
                                           class="uncheck-all uncheck-all-transactions" checked/><span
                                            id="type-milling-profit"
                                            class="new_filters"> Material Sales Agreement</span>
                                </div>
                            </div>
                        </div>
                        <!-- RESOURCES -->
                        <div class="sidebar-group" id="resources-type-group">
                            <label for="resources" class="expander"><p class="resources-type-group expander">Resources:</p> <a class="reset-filter-link resources-type-group">Reset filter</a><span class="expander"></span>
                            </label>
                            <div class="content" id="reserve-all-div">
                                <div class="block resources-type-group">
                                    <!--                        Select all:-->
                                    <div class="switch">
                                        <input type="checkbox" id="uncheck-all-resources" checked
                                               class="rsc-select-all cmn-toggle cmn-toggle-round">
                                        <label for="uncheck-all-resources"></label>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>
                                <div class="block resources-type-group">
                                    <input type="checkbox" name="resources[]" value="Maiden" id="resource-maiden"
                                           class="uncheck-all uncheck-all-resources" checked/> <span
                                            id="resource-maiden" class="new_filters">Initial</span>
                                </div>
                                <div class="block resources-type-group">
                                    <input type="checkbox" name="resources[]" value="Upgraded" id="resource-upgraded"
                                           class="uncheck-all uncheck-all-resources" checked/> <span
                                            id="resource-upgraded" class="new_filters">Upgraded</span>
                                </div>
                                <div class="block resources-type-group">
                                    <input type="checkbox" name="resources[]" value="Updated"
                                           id="resource-updated-resources" class="uncheck-all uncheck-all-resources"
                                           checked/> <span id="resource-updated-resources"
                                                           class="new_filters">Updated</span>
                                </div>
                                <div class="block resources-type-group">
                                    <input type="checkbox" name="resources[]" value="Unchanged" id="resource-unchanged"
                                           class="uncheck-all uncheck-all-resources" checked/> <span
                                            id="resource-unchanged" class="new_filters">Unchanged</span>
                                </div>
                                <div class="block resources-type-group">
                                    <input type="checkbox" name="resources[]" value="Not Defined"
                                           id="resource-not-defined" class="uncheck-all uncheck-all-resources" checked/>
                                    <span id="resource-not-defined" class="new_filters">Not Defined</span>
                                </div>
                            </div>
                        </div>
                        <!--            RESERVES-->
                        <div class="sidebar-group" id="reserves-type-group">
                            <label for="reserves" class="expander"><p class="reserves-type-group expander">Reserves:</p>
                                <a class="reset-filter-link reserves-type-group">Reset filter</a><span
                                        class="expander"></span>
                            </label>
                            <div class="content" id="reserve-all-div">
                                <div class="block reserves-type-group">
                                    <!--                        Select all:-->
                                    <div class="switch">
                                        <input type="checkbox" id="uncheck-all-reserves" checked
                                               class="rsc-select-all cmn-toggle cmn-toggle-round">
                                        <label for="uncheck-all-reserves"></label>
                                    </div>
                                    <div style="clear:both"></div>
                                </div>
                                <div class="block reserves-type-group">
                                    <input type="checkbox" name="resources-reserves[]" value="Maiden"
                                           id="reserves-maiden" class="uncheck-all uncheck-all-reserves" checked/> <span
                                            id="reserves-maiden" class="new_filters">Initial</span>
                                </div>
                                <div class="block reserves-type-group">
                                    <input type="checkbox" name="resources-reserves[]" value="Upgraded"
                                           id="reserves-upgraded" class="uncheck-all uncheck-all-reserves" checked/>
                                    <span id="reserves-upgraded" class="new_filters">Upgraded</span>
                                </div>
                                <div class="block reserves-type-group ">
                                    <input type="checkbox" name="resources-reserves[]" value="Updated"
                                           id="reserves-updated" class="uncheck-all uncheck-all-reserves" checked/>
                                    <span id="reserves-updated" class="new_filters">Updated</span>
                                </div>
                                <div class="block reserves-type-group">
                                    <input type="checkbox" name="resources-reserves[]" value="Unchanged"
                                           id="reserves-unchanged" class="uncheck-all uncheck-all-reserves" checked/>
                                    <span id="reserves-unchanged" class="new_filters">Unchanged</span>
                                </div>
                                <div class="block reserves-type-group">
                                    <input type="checkbox" name="resources-reserves[]" value="Not Defined"
                                           id="reserves-not-defined" class="uncheck-all uncheck-all-reserves" checked/>
                                    <span id="reserves-not-defined" class="new_filters">Not Defined</span>
                                </div>
                            </div>
                        </div>
                        <!-- Location Accuracy -->
                        <div class="sidebar-group" id="report-location-accuracy">
                            <label for="report-location-accuracy" class="expander"><p
                                        class="report-location-accuracy expander">Location Accuracy:</p>
                                <a class="reset-filter-link report-location-accuracy">Reset filter</a><span
                                        class="expander"></span>
                            </label>
                            <div class="content">
                                <div class="block report-location-accuracy">
                                    <!--                                  Select all:-->
                                    <div class="switch">
                                        <input type="checkbox" id="uncheck-all-accuracy" checked
                                               class="rsc-select-all cmn-toggle cmn-toggle-round">
                                        <label for="uncheck-all-accuracy"></label>
                                    </div>
                                </div>
                                <div class="block report-location-accuracy">
                                    <input type="checkbox" name="accuracy[]" value="Exact" id="exact-accuracy"
                                           class="uncheck-all uncheck-all-accuracy" checked/> <span id="exact-accuracy"
                                                                                                    class="new_filters">Exact</span>
                                </div>
                                <div class="block report-location-accuracy">
                                    <input type="checkbox" name="accuracy[]" value="Approximate" id="approx-accuracy"
                                           class="uncheck-all uncheck-all-accuracy" checked/> <span id="approx-accuracy"
                                                                                                    class="new_filters">Approximate</span>
                                </div>
                                <div class="block report-location-accuracy">
                                    <input type="checkbox" name="accuracy[]" value="Head Office"
                                           id="head-office-accuracy" class="uncheck-all uncheck-all-accuracy" checked/>
                                    <span id="head-office-accuracy" class="new_filters">Head Office</span>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
                <!--                <div class="rsc_formerly_logo">-->
                <!--                    <p>Formerly</p>-->
                <!--                    <img src="/wp-content/themes/fount/intel/images/rsc_logo_grayscale.png" width="200" alt="RSC Logo"/>-->
                <!--                </div>-->
            </div>

        </form>


    </div>


    <!-- Enable expandable menus for sidebar -->

    <script>
        window.onload = function () {
            // Filter expander
            $('.expander').simpleexpand();
        };
    </script>
    <!-- MAP TOP BAR
=========================-->
    <div class="map-topbar-container hide-below-768px">
        <div class="center-me-on-small cf topfilters">
            <!--            <a class="region-button" disabled id="quick-filters"">Quick Filters:</a>-->
            <!--            <a class="region-button region-button-on"  id="region-button-world">All Technical Reports</a>-->
            <!--            <a class="region-button region-button-off"  id="region-button-exploration">Exploration Reports</a>-->
            <!--            <a class="region-button region-button-off"  id="region-button-new-resource">New Resources</a>-->
            <!--            <a class="region-button region-button-off"  id="region-button-reserve">New Reserves</a>-->
            <!--            <a class="region-button region-button-off" value="Seabed Resources" id="region-button-seabed-resources">Seabed Resources</a>-->

            <!--        <div class="region-button-header" style="display: none;">-->
            <!--            <a class="region-button region-button-on"   id="region-button-world-sidebar" style="padding: 4px 14px 4px 14px;float: left;">Technical Reports</a>-->
            <!--            <a class="region-button region-button-off" value="T"-->
            <!--               id="region-button-trans-reports" class="trans-btn dropbtn" data-toggle="modal"-->
            <!--               data-target="" href="#"><i  class="fa fa-dollar" style="display: none;"></i> Transaction Reports</a>-->
            <!--        </div>-->
            <div class="Tooltip-header Tooltip-header-sign-up Tooltip Tooltip--alignEnd Tooltip--tooltipBelow CoachingTooltip CoachingTooltip-signup"
                 onmouseleave="oRsc.onhoverSignupBtn()">
                <div class="Tooltip-body">
                    <div class="CoachingTooltip-contents">
                        <div class="CoachingTooltip-message">
                            <p class="CoachingTooltip-contents-text"
                               style="line-height: 20px;margin-top: 18px;margin-bottom: 20px;">
                                Opaxe has more than 20,000 individual reports published by listed companies on the
                                global stock exchanges since 2015. Sign up to access exploration announcements, drilling
                                results, production reports all available via the interactive map and customisable
                                filters.</p>
                        </div>
                        <a class="CoachingTooltip-dismissLink close-tooltips"><a href="/register?lid=1"
                                                                                 style="float:right;">Sign up
                                here</a></a>
                    </div>
                </div>
                <div class="Tooltip-caretPositioner">
                    <div class="Tooltip-caret"></div>
                </div>
            </div>
            <div>
            </div>
            <!--            <div class="circle-text-numbers circle-text-number-2" style="display: none;">2</div>-->
            <!-- <a class="region-button region-button-off" id="region-button-custom-reporting" data-toggle="modal" data-target="#custom-reporting-modal" href="#" onclick="javascript:oRsc.customReporting();">Custom Reporting</a> -->
        </div>
    </div>
    <!--                <div class="Tooltip-trans-header Tooltip Tooltip--alignEnd Tooltip--tooltipBelow CoachingTooltip">-->
    <!--                    <div class="Tooltip-body trans-tooltip-body">-->
    <!--                        <div class="CoachingTooltip-contents">-->
    <!--                            <div>-->
    <!--                                <div class="CoachingTooltip-message">-->
    <!--                                    <p class="CoachingTooltip-contents-text" style="line-height: 20px;margin-top: 20px;margin-bottom: 20px;">-->
    <!--                                        Opaxe has more than 6,500 reports published since 2017 relating to transactions of mineral exploration, resource development, and mining properties, including property acquisitions, company acquisitions and takeovers. Access to these reports is subject to user registration to an Opaxe subscription plan.-->
    <!--                                    </p>-->
    <!--                                </div>-->
    <!--                            </div>-->
    <!--                            <a class="CoachingTooltip-dismissLink trans-dismiss-link">Click here to <a href="#" onclick="oRsc.openSignupmodel()">sign up</a> or <a href="#" onclick="oRsc.openLoginmodel()">login</a></a>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                    <div class="trans-Tooltip-caretPositioner">-->
    <!--                        <div class="Tooltip-caret"></div>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!-- TOGGLE MAP LAYER BUTTON & SEND FEEDBACK BUTTON
============================================================-->
    <div class='toggle-layer-menu hide-below-768px'>
        <!--      <div style="display: inline-block;margin-top: 5px">-->
        <!--          <a id="foo-faq" target="_blank" href="/faq" class="faq"><span>FAQ</span></a>-->
        <!--          <a target="_blank" id="legal-info"  href="/privacy-policy"><span>Legal Info</span></a>-->
        <!--          <a id="mail-to" data-toggle="modal" href="#">Report an issue</a>-->
        <!---->
        <!--      </div>-->


        <ul class='menu--main'>
            <!--            <li><a target="_blank" href="/faq">FAQ</a></li>-->
            <img id="menu_main_img" src="/wp-content/themes/fount/intel/images/RSC_Consulting_RGB-M_transparent-Grey-White.png" width="200" alt="RSC Logo">
            <li style="margin-left: -110px;"><a id="faq-to" href="#">FAQ</a></li>
            <li>Legal Info
                <ul class='sub-menu'>
                    <li id="showTermUse">
                        <a><span>Terms of Use</span></a>
                    </li>
                    <li id="privacy-pol" href="#">
                        <a><span>Privacy Policy</span></a>
                    </li>

                </ul>
            </li>
            <li><a id="mail-to">Report an issue</a></li>
        </ul>

        <a href="#" class="opaxe-copyright">Copyright Opaxe 2019</a>
    </div>
    <!--    <div class='toggle-layer-menu-footer hide-below-768px'>-->
    <!--            <div class="footer-links text-center py-3">-->
    <!--                <a href="#">Terms of Service</a>-->
    <!--                <a href="/privacy-policy">Privacy Policy</a>-->
    <!--            </div>-->
    <!--    </div>-->
    <!-- TOGGLE MAP LAYER LEGEND
============================================================-->
    <!--    <div class="circle-text-numbers circle-text-number-1">1</div>-->
    <div class='toggle-layer-pdfdownloads unset-cursor hide-below-768px'>
        <a id="pdf-button" class="collapsed-pdf"><span class="pdf-btn-text">PDF Downloads Credit</span><span
                    id="pdf-credit">0 /10</span><i class="fa fa-caret-down" id="pdf-credit-plus-sign"></i></a>
        <div id="pdf-body">
            <div class="title-head" id="pdf-downloads-head"><span class="pdf-btn-text">PDF Downloads Credit</span><i
                        class="fa fa-caret-left" aria-hidden="true" id="pdf-neg-btn"></i></div>

            <div id="pdf-content">

                <div id="pdf-content-tech">

                    <div class="">
                        <span class="pdf-credits">Today's reports downloads:</span><span
                                class="pdf-credits-number today-downloads"></span>
                    </div>
                    <div class="">
                        <span class="pdf-credits">This week's reports downloads:</span> <span
                                class="pdf-credits-number weekly-downloads"></span>
                    </div>
                    <div class="">
                        <span class="pdf-credits">Downloaded reports to date:</span> <span
                                class="pdf-credits-number total-downloads"></span>
                        <a class="show-downloaded-reports" onclick="oRsc.showDownloadedReports()">(show on map)</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='toggle-layer-legend unset-cursor hide-below-768px' id='toggle-layer-legend'>

        <div id="legend-body">
            <div class="title-head" id="legend-head">Legend

                <span id="legend-neg-btn">
                    <a href="#" class="remodal-close close-custom-modal-remodal"></a>
<!--                    <i class="fa fa-caret-left" aria-hidden="true"></i>-->
                </span>

            </div>

            <div id="legend-content">

                <div id="legend-content-tech">
                    <div class="title-head">Project Status</div>
                    <div class="">
                        <img class="resource-ico"
                             src="/wp-content/themes/fount/intel/images/icons/rsc-resource-unchanged.png"
                             alt="RSC unchanged resource icon"/>
                        Exploration Stage
                    </div>
                    <div class="">
                        <img class="resource-ico"
                             src="/wp-content/themes/fount/intel/images/icons/rsc-resource-updated.png"
                             alt="RSC updated resource icon"/>
                        Resource Development
                    </div>
                    <div class="">
                        <img class="resource-ico"
                             src="/wp-content/themes/fount/intel/images/icons/rsc-resource-upgraded.png"
                             alt="RSC upgraded resource icon"/>
                        Mining
                    </div>

                    <div class="title-head">Report Code</div>

                    <div class="">
                        <span class="report-code-ico">J</span> JORC
                    </div>
                    <div class="">
                        <span class="report-code-ico">N</span> NI 43-101
                    </div>
                    <div class="">
                        <span class="report-code-ico">E</span> (Environmental report)
                    </div>
                    <div class="">
                        <span class="report-code-ico">O</span> (Other code)
                    </div>

                </div>
            </div>
            <div id="legend-content-report">

                <div class="title-head">Project Status</div>
                <div class="">
                    <img class="resource-ico"
                         src="/wp-content/themes/fount/intel/images/icons/rsc-resource-unchanged.png"
                         alt="RSC unchanged resource icon"/>
                    Exploration
                </div>
                <div class="">
                    <img class="resource-ico"
                         src="/wp-content/themes/fount/intel/images/icons/rsc-resource-updated.png"
                         alt="RSC updated resource icon"/>
                    Resource Development
                </div>
                <div class="">
                    <img class="resource-ico"
                         src="/wp-content/themes/fount/intel/images/icons/rsc-resource-upgraded.png"
                         alt="RSC upgraded resource icon"/>
                    Mining
                </div>

                <div class="">
                    <img class="resource-ico"
                         src="/wp-content/themes/fount/intel/images/icons/rsc-resource-upgraded.png"
                         alt="RSC upgraded resource icon"/>
                    Care And Maintenance
                </div>

                <div class="">
                    <img class="resource-ico"
                         src="/wp-content/themes/fount/intel/images/icons/rsc-resource-upgraded.png"
                         alt="RSC upgraded resource icon"/>
                    Others (not specified)
                </div>
                <!--                <div class="">-->
                <!--                    <span class="report-code-ico">E</span> Exploration-->
                <!--                </div>-->
                <!--                <div class="">-->
                <!--                    <span class="report-code-ico">R</span> Resource Development-->
                <!--                </div>-->
                <!--                <div class="">-->
                <!--                    <span class="report-code-ico">M</span> Mining-->
                <!--                </div>-->
                <!--                <div class="">-->
                <!--                    <span class="report-code-ico">C</span> Care And Maintenance-->
                <!--                </div>-->
                <!--                <div class="">-->
                <!--                    <span class="report-code-ico">T</span> Others (not specified))-->
                <!--                </div>-->
            </div>

        </div>
        <a id="legend-button">Legend</a>
    </div>
    <div class='toggle-layer-satellite-map unset-cursor hide-below-768px' id='toggle-layer-satellite-map'>
        <a id="layer-toggle">Political map</a>
    </div>
    <script>

        $("#legend-neg-btn").click(function () {
            // $("#legend-button").show();
            $("#legend-body").css('display', 'none');

        });
        $("#legend-button").click(function () {

            if ($('#legend-body').css('display') == 'none') {
                $("#legend-body").css('display', 'block');
            } else {
                $("#legend-body").css('display', 'none');
            }

            // $("#legend-body").css('display','block');
            // $("#legend-button").hide();

        });
        $("#pdf-neg-btn").click(function () {
            $("#pdf-button").css('display', 'block');
            $("#pdf-body").css('display', 'none');

        });
        $("#pdf-button").click(function () {
            $("#pdf-body").css('display', 'block');
            $("#pdf-button").hide();

        });
    </script>

    <!-- THE ACTUAL MAP
=================================-->
    <div class="map-header-mobile show-below-768px">
        <!--            <h2 style="color: red;">MINERAL INTELLIGENCE</h2>-->
        <p>
            Filtered to last 30 days, gold only. <a class="show-more-link-mob">Show more?</a>
        </p>
    </div>

    <div id="map">

    </div>

    <script>
        //        document.getElementById("region-button-trans-reports").onmouseover = function() {mouseOver()};
        //        document.getElementById("region-button-trans-reports").onmouseout = function() {mouseOut()};

        function mouseOver() {
            var left = 163;
            var top = $('#region-button-trans-reports').offset().top;
            top = top - 30;
            var elementStyle = document.getElementById("transaction-main-div").style;
            elementStyle.position = "absolute";
//            if(left>1200){
//                left=left-226;
//            }
            elementStyle.left = left + 'px';
            elementStyle.top = top + 'px';
            $('.main-transaction-div').show();
        }

        function mouseOut() {
            $('.main-transaction-div').hide();
        }

        document.body.insertBefore(document.querySelector("#map-wrapper"), document.body.firstChild);
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <!-- Insert the map as the first child of the <body>. This is crucial, otherwise the map cant fill the viewport as it will be constrained by the Squarespace '.inner-content' block -->
    <script>
        document.body.insertBefore(document.querySelector("#map-wrapper"), document.body.firstChild);
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</div>
<!-- Close map-wrapper -->
<!-- Initialise Mapbox and Parse
=================================-->
