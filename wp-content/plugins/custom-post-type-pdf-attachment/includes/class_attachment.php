<?php

class cpta_attachments_init {
	
	public function __construct(){
		add_action( 'add_meta_boxes', array( $this, 'add_custom_pdf_attachment_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_custom_pdf_attachment_meta_data' ) );
		add_action( 'post_edit_form_tag', array( $this, 'update_edit_form_for_custom_pdf_attachment' ) );
	}
	
	public function add_custom_pdf_attachment_meta_boxes() {
		$saved_types = get_option('saved_post_types_for_pdf_attachment');
		if(is_array($saved_types)){
			foreach ( $saved_types as $saved_type ) {
				add_meta_box(
					'cpt_pdf_attachment',
					'PDF Attachments',
					array( $this, 'cpt_pdf_attachment' ),
					$saved_type
				);
			}
		}
	}
	
	public function cpt_pdf_attachment( $post ){
		$saved_no_of_pdf_attachment = get_option('saved_no_of_pdf_attachment');
		for($i=1; $i<=$saved_no_of_pdf_attachment; $i++ ){
			$this->cpt_pdf_attachment_defined($post,$i);
		}
	}
	
	public function cpt_pdf_attachment_defined($post,$i) {
		wp_nonce_field('cpt_pdf_attachment_check', 'cpt_pdf_attachment_nonce');
		include( CPTA_PLUGIN_PATH . '/view/admin/attachment_form.php');
	} 
	
	public function save_custom_pdf_attachment_meta_data($id) {

		$saved_no_of_pdf_attachment = get_option('saved_no_of_pdf_attachment');
		
		/* --- security verification --- */
		if(!wp_verify_nonce($_POST['cpt_pdf_attachment_nonce'], 'cpt_pdf_attachment_check')) {
			return $id;
		} // end if
		
		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $id;
		} // end if
		
		if('page' == $_POST['post_type']) {
			if(!current_user_can('edit_page', $id)) {
				return $id;
				wp_die('this is a page');
			} // end if
		} else {
			if(!current_user_can('edit_page', $id)) {
				return $id;
			} // end if
		} // end if
		/* - end security verification - */
		
		// check for delete file //
		for($i=1; $i<=$saved_no_of_pdf_attachment; $i++ ){
			if(!empty($_POST['cpt_pdf_attachment_remove'.$i])) {
				delete_post_meta($id, 'cpt_pdf_attachment'.$i);
			}
		}
		// check for delete file //
	
		// Make sure the file array isn't empty
		for($i=1; $i<=$saved_no_of_pdf_attachment; $i++ ){
			if(!empty($_FILES['cpt_pdf_attachment'.$i]['name'])) {
			
			// Setup the array of supported file types. In this case, it's just PDF.
			$supported_types = array('application/pdf');
			
			// Get the file type of the upload
			$arr_file_type = wp_check_filetype(basename(sanitize_text_field($_FILES['cpt_pdf_attachment'.$i]['name'])));
			$uploaded_type = $arr_file_type['type'];
			
			// Check if the type is supported. If not, throw an error.
			if(in_array($uploaded_type, $supported_types)) {
			
			// Use the WordPress API to upload the file
			$upload = wp_upload_bits($_FILES['cpt_pdf_attachment'.$i]['name'], NULL, file_get_contents($_FILES['cpt_pdf_attachment'.$i]['tmp_name']));
			
			if(isset($upload['error']) && $upload['error'] != 0) {
				wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
			} else {
				add_post_meta($id, 'cpt_pdf_attachment'.$i, $upload['url']);
				update_post_meta($id, 'cpt_pdf_attachment'.$i, $upload['url']);
			} // end if/else
			
			} else {
				wp_die("The file type that you've uploaded is not a PDF.");
			} // end if/else
			
			} // end if
		}
	}

	public function update_edit_form_for_custom_pdf_attachment() {
		echo ' enctype="multipart/form-data"';
	} 

}