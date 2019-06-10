<?php
if(!function_exists('custom_pdf_attachment_shortcode')){
	function custom_pdf_attachment_shortcode( $atts ) {
		 global $post;
		 extract( shortcode_atts( array(
			  'file' => '',
			  'name' => ''
		 ), $atts ) );
		 
		 if(!$file){
			return;
		 }
		 
		 if(!get_post_meta($post->ID, 'cpt_pdf_attachment'.$file, true)){
			return;
		 }
		 
		 $pdf_open_in = get_option('pdf_open_in');
		 $target = ( $pdf_open_in == '' ? '_self' : $pdf_open_in ); 
		 
		 if($name){
			$ret = '<img src="'.plugins_url( CPTA_PLUGIN_DIR . '/images/pdf.png', dirname(__FILE__) ).'"> <a href="'.get_post_meta($post->ID, 'cpt_pdf_attachment'.$file, true).'" target="'.$target.'">'.$name.'</a>';
		} else {
			$file_mime_data = wp_check_filetype( get_post_meta($post->ID, 'cpt_pdf_attachment'.$file, true));
			$file_info = pathinfo(get_post_meta($post->ID, 'cpt_pdf_attachment'.$file, true));
			$ret = '<img src="'.plugins_url( CPTA_PLUGIN_DIR . '/images/pdf.png', dirname(__FILE__) ).'"> <a href="'.get_post_meta($post->ID, 'cpt_pdf_attachment'.$file, true).'" target="'.$target.'">'.$file_info['basename'].'</a>';
		}
		 return $ret;
	}
}

if(!function_exists('pdf_attachment_file')){
	function pdf_attachment_file($file = '', $name = ''){
		if(!$file){
			return;
		}
		return do_shortcode('[pdf_attachment file="'.$file.'" name="'.$name.'"]');
	}
}

if(!function_exists('custom_pdf_all_attachments_shortcode')){
	function custom_pdf_all_attachments_shortcode() {
		 global $post;
		 $saved_no_of_pdf_attachment = get_option('saved_no_of_pdf_attachment');
		 $ret = '';
		 for($i=1; $i <= $saved_no_of_pdf_attachment; $i++ ){
			 $file_att = pdf_attachment_file($i);
			 if($file_att){
				$ret .= $file_att;
				$ret .= '<br>';
			 }
		 }
		 return $ret;
	}
}

if(!function_exists('pdf_all_attachment_files')){
	function pdf_all_attachment_files(){
		return do_shortcode('[pdf_all_attachments]');
	}
}

