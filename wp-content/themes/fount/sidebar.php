<?php
  	//ENSURE CORRECT SIDEBAR IS DISPLAYED
  	wp_reset_query();
  	$right_sidebar_id='sidebar-primary';
	if (get_field('right_sidebar_id')!="")
	    $right_sidebar_id=get_field('right_sidebar_id');
	if (function_exists('dynamic_sidebar') && dynamic_sidebar(apply_filters('ups_sidebar',$right_sidebar_id))) :
		else : 
		?>
		<!-- THIS CONTENT WILL BE DISPLAYED IF THERE ARE NO WIDGETS -->
		<div id="no-widgets">
            <p>
                <strong>NO WIDGETS YET</strong><br>
                Turn me off under Fount Options>General Tab
            </p>
		</div><!-- no-widgets -->
		<?php 
	endif; 
?>
