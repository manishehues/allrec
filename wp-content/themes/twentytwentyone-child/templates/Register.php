<?php
/**
 * Template Name: Register
 *
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();
?>

<div class="registerCustom">
    <div class="shortContainer">
        <div class="formlogo">
            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/allreclog.svg"/>
        </div>
        <?php echo do_shortcode( '[arm_setup id="1"]' ); ?>
    </div>
</div>



<?php
get_footer();
