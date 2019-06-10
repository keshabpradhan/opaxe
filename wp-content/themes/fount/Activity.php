<?php
/**
 * Template Name: Activity
 *
 * Displays the Business Layout of the theme.
 *
 * @package Activity
 * @subpackage Attitude Pro
 * @since Attitude Pro 1.0
 */

get_header();
?>

<?php
include 'intel/Activity_Log.php';
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<!--    --><?php //the_title(); ?><!--</h1>-->
    <div class="entry">
        <?php the_content(); ?>
    </div><!-- entry -->
<?php endwhile; ?>
<?php endif; ?>



<?php // Gets footer.php
get_footer();
?>




