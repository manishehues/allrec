<?php
/**
 * Template Name: Features
 *
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();
?>


<div id="features" class="features container">
    <div class="mainVideo">
        <video width="100%" height="800px" autoplay loop muted playsinline> 
            <source src="<?php echo get_stylesheet_directory_uri() ?>/assets/video/video.mp4"/>   
        </video>
    </div>
    <div class="secOff">
        <div class="leftSide">
            <h2>ARCANNABIS STORE</h2>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
        </div>
        <div class="rightSide">
            <h4>20%</h4>
        </div>
    </div>
    <div class="videoList">
        <h2>OTHERS DISCOUNT YOU MAY LIKE</h2>
        <div class="videoSection">
            <div class="equalVideo">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/Group-143.jpg"/>
            </div>
            <div class="equalVideo">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/Group-199.jpg"/>
            </div>
            <div class="equalVideo">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/Group-144.jpg"/>
            </div>
        </div>
    </div>
</div>


<?php
get_footer();
