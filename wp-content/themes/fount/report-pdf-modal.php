<div class="modal fade" id="report-pdf-modal" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 id="report-pdf-h4" class="modal-title">REPORT PDF</h4>
            </div>
            <div class="modal-body">
                <input type="text" id="report-pdf-url" />
                <div id="pdf-iframe" class="container-fluid">
                </div>
                <div class="soical-link">
                    <div onclick="javascript:oPdf.copy();">
                        <span class="circle"><img src="images/copy-link.png" alt="Copy Link" title="Copy link to clipboard." /></span>
                        <a id="copy-pdf-link">Copy Link</a>
                    </div>
                    <div onclick="javascript:oPdf.emailReportGA();">
                        <a id="sendPdfMail" href="">
                                <span class="circle"><img src="images/mail.png" alt="Email Link" title="Send Mail." /></span>
                                Email Link
                        </a>
                    </div>
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
                    <input type="email" class="form-control required" required name="pdf-email" id="pdf-email" placeholder="Email" aria-describedby="sizing-addon1">
                </div>
            </div>

            <div class="modal-footer">
                <div class="processing" style="display: inline-block; width: 16px; margin-right: 4px;">
                    <img src="images/loading_ani.gif" style="margin: 0px ! important; display: none;">
                </div>
                <button onclick="javascript:oPdf.sendMail();" type="button" id="btn-email-pdf" class="btn btn-primary">Send</button>
                <button onclick="javascript:oPdf.cancelMail();" type="button" class="btn btn-default" >Cancel</button>
            </div>
        </div>
    </div>
</div>