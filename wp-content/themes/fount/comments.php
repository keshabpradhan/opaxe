<?php
	global $prk_fount_options;
	global $prk_translations;
	//OVERRIDE OPTIONS - ONLY FOR PREVIEW MODE
	if (INJECT_STYLE)
	{
		include_once(ABSPATH . 'wp-content/plugins/color-manager-fount/style_header.php');	
	}
?>
<?php function fount_comment($comment, $args, $depth) {
	global $prk_fount_options;
	global $prk_translations;
  	$GLOBALS['comment'] = $comment; ?>
  <li <?php comment_class(); ?>>
    <article id="comment-<?php comment_ID(); ?>" class="clearfix single_comment">
      <header class="comment-author vcard">
        <?php echo get_avatar($comment, $size = '120'); ?>
      </header>
      <div class="comment_floated">
      	<div class="comments_meta_wrapper header_font">
        <?php printf(__('<div class="zero_color author_name small-12 prk_heavier_700">%s</div>', 'fount'), get_comment_author_link()); ?>
	        <time datetime="<?php echo comment_date('c'); ?>" class="comment_date left_floated small_headings_color prk_heavier_500">
					<?php 
						echo get_comment_date(); 
						echo " @ ";
						echo get_comment_time(); 
	                ?>
	       	</time>
	       	<div class="pir_divider_cmts left_floated small_headings_color">|</div>
	        <div class="left_floated not_zero_color prk_heavier_600">
	      		<?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => $prk_translations['reply_text']))); ?>
			</div>
        </div>
      <?php if ($comment->comment_approved == '0') { ?>
        <div class="alert alert-block fade in">
          <a class="close" data-dismiss="alert">&times;</a>
          <p><?php _e('Your comment is awaiting moderation.', 'fount'); ?></p>
        </div>
      <?php } ?>
      <section class="comment comment_text left_floated">
        <?php comment_text() ?>
      </section>
      <div class="clearfix"></div>
		</div>
    </article>
<?php } ?>

<?php if (post_password_required()) { ?>
  <div id="comments">
    <div class="alert alert-block fade in">
      <a class="close" data-dismiss="alert">&times;</a>
      <p><?php _e('This post is password protected. Enter the password to view comments.', 'fount'); ?></p>
    </div>
  </div>
<?php
  return;
} ?>

<?php if (have_comments() && comments_open()) { ?>
  <div id="comments">
    	<div class="prk_centerize header_font">
    		<h3 class="bd_headings_text_shadow zero_color prk_heavier_600">
                <?php printf(_n(($prk_translations['comments_one_response']), '%1$s '.($prk_translations['comments_oneplus_response']), get_comments_number()), number_format_i18n(get_comments_number())); ?>
        	</h3>
        	<div class="small_headings_color prk_heavier_500">
                <?php echo $prk_translations['on_text']." ".get_the_title()."."; ?>
        	</div>
        </div>
    <ol class="commentlist">
      <?php wp_list_comments(array('callback' => 'fount_comment')); ?>
    </ol>

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) { // are there comments to navigate through ?>
      <nav id="comments-nav" class="pager">
        <div class="previous"><?php previous_comments_link(__('&larr; Older comments', 'fount')); ?></div>
        <div class="next"><?php next_comments_link(__('Newer comments &rarr;', 'fount')); ?></div>
      </nav>

    <?php } // check for comment navigation ?>

  </div><!-- /#comments -->
  <div class="clearfix"></div>
<?php } ?>

<?php 
	if (0) 
	{
		comment_form();
	}
	if (comments_open()) { 
	?>
  		<section id="respond">
  			<div id="prk_respond_header" class="prk_centerize header_font">
	    		<h3 class="bd_headings_text_shadow zero_color prk_heavier_600">
	                <?php comment_form_title(($prk_translations['comments_leave_reply']), ($prk_translations['comments_leave_reply'].' to %s')); ?>
	        	</h3>
	        	<?php
	        		if ($prk_translations['comments_under_reply']!="") {
	        			?>
	        				<div class="small_headings_color prk_heavier_500">
				                <?php echo $prk_translations['comments_under_reply']; ?>
				        	</div>
	        			<?php
	        		}
	        	?>
	        </div>
            <p class="cancel-comment-reply not_zero_color"><?php cancel_comment_reply_link(('Click here to cancel reply')); ?></p>
            <?php 
				if (get_option('comment_registration') && !is_user_logged_in()) 
				{ 
					?>
              		<p><?php printf(('You must be <a href="%s">logged in</a> to post a comment.'), wp_login_url(get_permalink())); ?></p>
            		<?php 
				} 
				else 
				{ 
					?>
              		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform" name="comment_form">
						<?php 
							if (is_user_logged_in()) 
							{ 
								?>
								<p><?php printf(('Logged in as <a href="%s/wp-admin/profile.php" class="not_zero_color">%s</a>.'), get_option('siteurl'), $user_identity); ?> 
									<a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php ('Log out of this account'); ?>" class="not_zero_color">
										<?php _e('Log out &raquo;', 'fount'); ?>
									</a>
								</p>
								<?php 
							} 
							else 
							{ 
								?>
                                <div class="row">
                                <div class="small-4 columns">
                                    <input type="text" class="text pirenko_highlighted" name="author" id="author" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> 
                                    placeholder="<?php echo esc_attr($prk_translations['comments_author_text']); if ($req) echo($prk_translations['required_text']); ?>" data-original="<?php echo esc_attr($prk_translations['comments_author_text']);echo esc_attr($prk_translations['required_text']); ?>" />
							  	</div>
                                <div class="small-4 columns">
                                    <input type="email" class="text pirenko_highlighted" name="email" id="email" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> 
                                    placeholder="<?php echo esc_attr($prk_translations['comments_email_text']); if ($req) echo($prk_translations['required_text']); ?>" data-original="<?php echo esc_attr($prk_translations['comments_email_text']);echo esc_attr($prk_translations['required_text']); ?>" />		
                                </div>
                                <div class="small-4 columns">
                                    <input type="url" class="text pirenko_highlighted" name="url" id="url" size="22" tabindex="3" 
                                    placeholder="<?php echo esc_attr($prk_translations['comments_url_text']); ?>" />
                                </div>
                                </div>
								<?php 
							} 
						?>
                        <textarea name="comment" id="comment" class="pirenko_highlighted small-12" tabindex="4"
                        placeholder="<?php echo esc_attr($prk_translations['comments_comment_text']); ?>" data-original="<?php echo esc_attr($prk_translations['comments_comment_text']); ?>" rows="8"></textarea>
                        <div id="contact_ok" class="clearfix prk_heavier_600 zero_color header_font bd_headings_text_shadow"><?php echo esc_attr($prk_translations['contact_wait_text']); ?></div>
                        <div class="clearfix"> </div>
                        <div id="submit_comment_div" class="theme_button small">
                        	<a href="#" class="with_icon">
                        		<?php 
                        			echo '<div class="text_shifter">'.$prk_translations['comments_submit'].'</div>';
                        			echo '<div class="icon_cell"><i class="fount_fa-chevron-right"></i></div>'; 
                        		?>
                        	</a>
                      	</div>
                        <div class="clearfix"></div>
                        <?php comment_id_fields(); ?>
                        <?php do_action('comment_form', $post->ID); ?>
              		</form>
            		<?php 
				} 
			?>
  		</section>
        <div class="clearfix"></div>
		<?php 
	} 
?>
<script type="text/javascript">
jQuery(document).ready(function() {
	var wordpress_directory = '<?php echo get_option('siteurl'); ?>';
	var empty_text_error = '<?php echo esc_attr($prk_translations['empty_text_error']); ?>';
	var invalid_email_error = '<?php echo esc_attr($prk_translations['invalid_email_error']); ?>';
	var comment_ok_message = '<?php echo esc_attr($prk_translations['comment_ok_message']); ?>';
	var already_submitted_comment=false;
	jQuery('#submit_comment_div a').click(function(e) {
		e.preventDefault();
		//REMOVE PREVIOUS ERROR MESSAGES IF THEY EXIST
		jQuery("#respond .contact_error").remove();
		error = false;
        emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;	
		if (already_submitted_comment===false) {
			//DATA VALIDATION
			jQuery('#commentform textarea, #author, #email').each(function() {
				value = jQuery(this).val();
				theID = jQuery(this).attr('id');
				if(value == '' || value===jQuery(this).attr('data-original')) {
					jQuery(this).after('<p class="contact_error fount_italic prk_heavier_600 header_font">'+empty_text_error+'</p>');
					error = true;
				}
				if(theID === 'email' && value !=='' && value!==jQuery(this).attr('data-original') && !emailReg.test(value)) {
					jQuery(this).after('<p class="contact_error fount_italic prk_heavier_600 header_font">'+invalid_email_error+'</p>');
					error = true;
				}
				jQuery('.contact_error').addClass('fount_animated shake');
			});
			//SEND COMMENT IF THERE ARE NO ERRORS
			if(error === false) {
				jQuery("#submit_comment_div").addClass("fount_animated bounceOut");	
				setTimeout(function() {
					jQuery('#contact_ok').addClass('fount_animated flash');
					//POST COMMENT
					jQuery.ajax({  
						type: "POST",  
						url: wordpress_directory+"/wp-comments-post.php",  
						data: jQuery("#commentform").serialize(),  
						success: function(resp) {
							jQuery('#contact_ok').html('');
							jQuery('#contact_ok').append(comment_ok_message);
							jQuery("#contact_ok").css({'display':'inline-block'});
							already_submitted_comment=true;
						},  
						error: function(e) {  
							jQuery('#contact_ok').html('');
							jQuery('#contact_ok').append('<p class="comment_error">Comment error. Please try again!</p>');
							jQuery("#contact_ok").css({'display':'inline-block'});
						}
				});
				},1200);				
			}
		}
	});
});
</script>