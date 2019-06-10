<?php 
	get_header();
	$inportfolio_layout=$prk_fount_options['archives_ptype'];
	//OVERRIDE OPTIONS - ONLY FOR PREVIEW MODE
	if (INJECT_STYLE)
	{
		include_once(ABSPATH . 'wp-content/plugins/color-manager-fount/style_header.php');	
	}
	global $prk_retina_device;
	$retina_flag = $prk_retina_device === "prk_retina" ? true : false;
	$show_title=true;
	$limited_width=false;

	if (get_field('multicolored_thumbs')=="1")
		$multicolored_thumbs="yes";
	else 
		$multicolored_thumbs="no";
	if (get_field('titled_portfolio')=="1")
		$titled_portfolio="yes";
	else 
		$titled_portfolio="no";
	if (get_field('show_filter')=="1")
		$fount_show_filter="yes";
	else
		$fount_show_filter="no";
	if (get_field('cols_number')!="" && get_field('cols_number')!="0")
		$cols_number=get_field('cols_number');
	else
		$cols_number="variable";
	$inside_filter="";
	$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
	$inside_filter=$term->slug;
	if (get_field('featured_header')=="1")
    {
        $featured_style='';
        $show_title=false;
    }
    else
        $featured_style=' forced_menu';
	//ADD PROTECTED GALLERIES FEATURE
	if ( !post_password_required() ) 
	{
		?>
		<div id="centered_block" class="<?php echo $featured_style; ?>">
			<div id="main_block" class="block_with_sections page-<?php echo get_the_ID(); ?>">
				<?php
		            if ($show_title==true)
		            {
		                echo '<div class="small-12 small-centered columns prk_inner_block">';
		                wp_reset_query();
		                prk_output_title("advanced");
		                echo '</div>';
		            }
		            else
		            {
		                wp_reset_query();
		                if (get_the_content()!=="") 
		                {
		                    while (have_posts()) : the_post();
		                    	echo '<div id="fount_super_sections">';
		                        the_content();
		                        echo '</div>';
		                    endwhile;
		                }
		            }
		        ?>
				<div id="content">
        			<div id="main" role="main" class="row">
        				<div id="portfolio_single_page" class="prk_inner_block small-12 small-centered columns unmargined">
							<?php
								echo do_shortcode('[pirenko_last_portfolios thumbs_type_folio="'.get_field('thumbs_type_folio').'" layout_type_folio="'.$inportfolio_layout.'" cols_number="'.$cols_number.'" items_number="'.get_field('items_number').'" cat_filter="" tag_filter="'.$inside_filter.'" thumbs_mg="'.get_field('thumbs_mg').'" multicolored_thumbs="'.$multicolored_thumbs.'" titled_portfolio="'.$titled_portfolio.'" fount_show_skills="'.get_field('fount_show_skills').'" icons_display="'.get_field('icons_display').'" show_filter="'.$fount_show_filter.'"]tricker[/pirenko_last_portfolios]');
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		}//PROTECTED GALLERY
		else
		{
			echo '<div id="centered_block"><div id="main_block"><div id="prk_protected" class="columns twelve centered">';
				while (have_posts()) : the_post();
			    	the_content();   
			    endwhile;
			if (INJECT_STYLE) {
				echo 'For testing use this password: pass';
			}
		    echo '</div></div></div>';
		}
	?>
<?php get_footer(); ?>