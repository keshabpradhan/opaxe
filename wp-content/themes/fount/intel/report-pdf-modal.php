<div class="modal fade" id="report-pdf-modal" data-backdrop="static" data-keyboard="false" role="dialog"
     aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
<!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span-->
<!--                            aria-hidden="true">&times;</span></button>-->
                <a href="#" class="remodal-close close-custom-modal-remodal"></a>
                <h4 id="report-pdf-h4" class="modal-title">REPORT PDF</h4>
                <span class="pdf-presentation-mode" onclick="oPdf.presentationMode();"></span>
            </div>
            <div class="modal-body">
                <a href="#" class="previous-report desktop-version" onclick="oPdf.prevBulletin();">&laquo; Previous</a>
                <a href="#" class="next-report desktop-version" onclick="oPdf.nextBulletin();">Next &raquo;</a>
                <input type="text" id="report-pdf-url"/>
                <div id="pdf-iframe" class="container-fluid">
                </div>
                <!-- <div class="soical-link">
                    <div onclick="javascript:oPdf.copy();">
                        <span class="circle"><img src="<?php bloginfo('template_url'); ?>/intel/images/copy-link.png" alt="Copy Link" title="Copy link to clipboard." /></span>
                        <a id="copy-pdf-link">Copy Link</a>
                    </div>
                    <div onclick="javascript:oPdf.emailReportGA();">
                        <a id="sendPdfMail" href="">
                                <span class="circle"><img src="<?php bloginfo('template_url'); ?>/intel/images/mail.png" alt="Email Link" title="Send Mail." /></span>
                                Email Link
                        </a>
                    </div>
                </div> -->

                <div id="bottom-share-links">
                    <h5 style="display: inline; float: left;"><a class="previous-report mobile-version" href="#"
                                                                 onclick="oPdf.prevBulletin();">&laquo;Previous</a></h5>
                    <a class="linkedin-share-link" href="#" target="_blank">
                        <img src="https://simplesharebuttons.com/images/somacro/linkedin.png" alt="LinkedIn"/>
                    </a>
                    <a class="twitter-share-link" href="#" target="_blank">
                        <img src="https://simplesharebuttons.com/images/somacro/twitter.png" alt="Twitter"/>
                    </a>
                    <a href="#" onclick="javascript:oPdf.emailReportGA();" id="sendPdfMail">
                        <img src="https://simplesharebuttons.com/images/somacro/email.png" alt="Email"/>
                    </a>
                    <a onclick="javascript:oPdf.copy();" href="#">
                        <img src="<?php bloginfo('template_url'); ?>/intel/images/copy-link.png" alt="Copy Link"
                             title="Copy link to clipboard."/>
                    </a>
                    <h5 style="display: inline; float: right;"><a class="next-report mobile-version" href="#"
                                                                  onclick="oPdf.nextBulletin();">Next&raquo;</a></h5>
                </div>
</div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="link-pdf-modal" tabindex="-1" role="dialog" aria-labelledby="PDF link">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Clipboard</h4>
            </div>

            <div class="modal-body">
                <p>link copied to clipboard.</p>
            </div>
        </div>
    </div>
</div>

    <!--Email Sending Popup-->
    <div class="modal fade" id="email-pdf-modal" tabindex="-1" role="dialog" aria-labelledby="Email PDF link">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Email Link</h4>
                </div>

                <div class="modal-body">
                    <!-- Email -->
                    <div class="input-group input-group-lg">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input type="email" class="form-control required" required name="pdf-email" id="pdf-email"
                               placeholder="Email" aria-describedby="sizing-addon1">
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="processing" style="display: inline-block; width: 16px; margin-right: 4px;">
                        <img src="<?php bloginfo('template_url'); ?>/intel/images/loading_ani.gif"
                             style="margin: 0px ! important; display: none;">
                    </div>
                    <button onclick="javascript:oPdf.sendMail();" type="button" id="btn-email-pdf"
                            class="btn btn-primary">Send
                    </button>
                    <button onclick="javascript:oPdf.cancelMail();" type="button" class="btn btn-default">Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>