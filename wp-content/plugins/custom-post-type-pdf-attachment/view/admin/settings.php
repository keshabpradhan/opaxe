<table width="100%" border="0" style="background-color:#FFFFFF; border:1px solid #CCCCCC; padding:0px 0px 0px 10px; margin:2px 0px;">
  <tr>
    <td><h3><?php _e('Custom Post Type Attachment ( PDF )');?></h3></td>
  </tr>
  
  <tr>
    <td>
    
      <div class="ap-tabs">
        <div class="ap-tab"><?php _e('Settings','login-sidebar-widget');?></div>
        <div class="ap-tab"><?php _e('Shortcode','login-sidebar-widget');?></div>
    </div>
    <div class="ap-tabs-content">
        <div class="ap-tab-content">
        <table width="100%">
        
          <tr>
            <td><strong><?php _e('Select Post Types Where You Want Custom PDF Attachments','custom-post-type-pdf-attachment');?></strong></td>
          </tr>
          <tr>
            <td><?php $this->post_types_selected($saved_types); ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><strong><?php _e('Select Number of Attachment Files','custom-post-type-pdf-attachment');?></strong></td>
          </tr>
          <tr>
            <td><?php form_class::form_select('no_of_pdf_attachment','',$this->get_no_of_pdf_files_selected($saved_no_of_pdf_attachment));?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><strong><?php _e('PDF Open in','custom-post-type-pdf-attachment');?></strong></td>
          </tr>
          <tr>
            <td><?php form_class::form_select('pdf_open_in','',$this->get_pdf_open_in_selected($pdf_open_in));?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><?php form_class::form_input('submit','submit','',__('Save','custom-post-type-pdf-attachment'),'button button-primary button-large button-ap-large');?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          </table>
        </div>
        <div class="ap-tab-content">
        <table width="100%">
           <tr>
            <td><?php $this->help_info($saved_no_of_pdf_attachment); ?></td>
          </tr> 
        </table>
        </div>
    </div>
    </td>
  </tr>
</table>