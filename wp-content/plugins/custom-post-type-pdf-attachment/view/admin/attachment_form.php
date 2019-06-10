<table width="100%" border="0">
  <tr>
    <td colspan="2"><strong><?php _e('Upload PDF', 'custom-post-type-pdf-attachment');?> - <?php echo $i;?></strong></td>
  </tr>
<tr>
<td><?php form_class::form_input('file','cpt_pdf_attachment'.$i,'cpt_pdf_attachment'.$i,'','','','','','','','','','',true);?></td>
<td align="right">
<?php
if(get_post_meta($post->ID, 'cpt_pdf_attachment'.$i, true)){
	$file_info = pathinfo(get_post_meta($post->ID, 'cpt_pdf_attachment'.$i, true));
	echo '<a href="'.get_post_meta($post->ID, 'cpt_pdf_attachment'.$i, true).'">' . $file_info['basename'] . '</a> ';
}
if(get_post_meta($post->ID, 'cpt_pdf_attachment'.$i, true)){
	echo '<br>';
	echo '<label>' . __('Check to remove','custom-post-type-pdf-attachment') . ' ' . form_class::form_checkbox('cpt_pdf_attachment_remove'.$i,'cpt_pdf_attachment_remove'.$i,$i,'','','','','','',false) . '</label>';
}
?>
</td>
</tr>
<tr>
<td colspan="2"><strong>Shortcode:</strong> [pdf_attachment file="<?php echo $i;?>" name="optional file name"]</td>
</tr>
</table>
<div style="width:100%; height:2px; background-color:#000; margin:20px 0px;">&nbsp;</div>