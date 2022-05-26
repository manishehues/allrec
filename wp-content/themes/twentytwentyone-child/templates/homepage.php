<?php
/**
 * Template Name: New Home Page
 *
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();
?>

<div class="homePage container">
    <div class="heroBanner">
        <div class="videoSection">
            <?php the_field('video_code'); ?>
        </div>
        <div class="heroContent">
            <div class="content">
                <h1><?php the_field('tittle'); ?></h1>
                <p><?php the_field('description1'); ?></p>
                <div class="space">
                    <a class="btn" href="#"><?php the_field('Url'); ?>Sign up today </a>
                </div>
            </div>
            <div class="heroIcons">
                <ul>
                    <?php if( have_rows('icon') ): ?>
                        <?php while( have_rows('icon') ): the_row();
                            $icon_img = get_sub_field('icon_img');
                        ?>

                    <li><a herf="#"><?php echo $title; ?><img src="<?php echo $icon_img['url']; ?>" alt="<?php echo $title; ?>"></a></li>

                    <?php endwhile;
                        endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="product">
        <div class="productTitle">
            <div class="setTitel">
                <h2><?php the_field('heading_shop'); ?></h2>
                <p><?php the_field('description_shop'); ?></p>
            </div>
            <div class="sildeSlider">
            </div>
        </div>
        <div class="ProductShortcode">
           <?php the_field('shortcode'); ?>
        </div>
    </div>
    <div class="product">
        <div class="productTitle">
            <div class="setTitel">
                <h2><?php the_field('heading_give_away'); ?></h2>
                <p><?php the_field('description_give_away'); ?></p>
            </div>
            <div class="sildeSlider">
            </div>
        </div>
        <div class="ProductShortcode">
           <?php the_field('shortcode_give_away'); ?>
        </div>
    </div>
</div>

<div class="fullBorder">
    <div class="product spacing container">
        <div class="productTitle">
            <div class="setTitel">
                <h2><?php the_field('heading'); ?></h2>
                <p><?php the_field('description'); ?></p>
            </div>
        </div>
        <div class="brands">
            <!-- <div class="singleBrand">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/first.svg"/>
                <a class="btn" href="#">20% OFF</a>
                <span><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/user-group-solid.svg"/>45 People Used Today</span>
            </div>
            <div class="singleBrand">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/second.svg"/>
                <a class="btn" href="#">20% OFF</a>
                <span><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/user-group-solid.svg"/>45 People Used Today</span>
            </div> -->
            <div class="singleBrand">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/third.svg"/>
                <a class="btn" href="#">20% OFF</a>
                <span><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/user-group-solid.svg"/>45 People Used Today</span>
            </div>
            <!-- <div class="singleBrand">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/forth.svg"/>
                <a class="btn" href="#">20% OFF</a>
                <span><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/user-group-solid.svg"/>45 People Used Today</span>
            </div> -->
        </div>
    </div>
</div>


<?php
get_footer();
