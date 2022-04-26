<?php
/**
 * Template Name: Login
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
            <a href="http://localhost/allrec">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/allreclog.svg"/>
            </a>
            
        </div>
        <?php echo do_shortcode( '[arm_form id="102" logged_in_message="You are already logged in."]' ); ?>
    </div>
</div>

<?php
get_footer();