<?php
	global $prk_fount_options;
	global $prk_translations;
?>
<form role="search" method="get" id="searchform" class="form-search" action="<?php echo home_url('/'); ?>" data-url="<?php echo prk_clean_url(); ?>">
	<div class="sform_wrapper">
  		<input type="text" value="" name="s" id="fount_search" class="search-query pirenko_highlighted prk_heavier_500" placeholder="<?php //echo($prk_translations['search_tip_text']); ?>" />
  		<i class="fount_fa-search prk_less_opacity"></i>
    </div>
</form>