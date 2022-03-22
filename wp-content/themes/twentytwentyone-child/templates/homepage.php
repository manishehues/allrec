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
            <!-- <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/Videoimg.png"/> -->
            <script src="https://fast.wistia.com/embed/medias/oqq38tahjn.jsonp" async></script><script src="https://fast.wistia.com/assets/external/E-v1.js" async></script><div class="wistia_responsive_padding" style="padding:56.25% 0 0 0;position:relative;"><div class="wistia_responsive_wrapper" style="height:100%;left:0;position:absolute;top:0;width:100%;"><div class="wistia_embed wistia_async_oqq38tahjn videoFoam=true" style="height:100%;position:relative;width:100%"><div class="wistia_swatch" style="height:100%;left:0;opacity:0;overflow:hidden;position:absolute;top:0;transition:opacity 200ms;width:100%;"><img src="https://fast.wistia.com/embed/medias/oqq38tahjn/swatch" style="filter:blur(5px);height:100%;object-fit:contain;width:100%;" alt="" aria-hidden="true" onload="this.parentNode.style.opacity=1;" /></div></div></div></div>
        </div>
        <div class="heroContent">
            <div class="content">
                <h1>WELCOME <br>TO ALL <span>REC.CA</span></h1>
                <p>Enjoy exclusive events, give always & discounts<br> to everyday essentials!</p>
                <div class="space">
                    <a class="btn" href="#">Sign up today </a>
                </div>
            </div>
            <div class="heroIcons">
                <ul>
                    <li><a herf="#"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/instagram.png"/></a></li>
                    <li><a herf="#"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/youtube.png"/></a></li>
                    <li><a herf="#"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/twitter.png"/></a></li>
                </ul>
            </div>
        </div>
    </div>




    <div class="product">
        <div class="productTitle">
            <div class="setTitel">
                <h2>SHOP</h2>
                <p>Purchasing merch will enter you in our give away raffles<br>
                Every $20 dollars spent will generate you a numbered ticket for<br>
                a higher chance of winning.</p>
            </div>
            <div class="sildeSlider">
                <!-- <ul>
                    <li><a href="#">0</a></li>
                    <li><a href="#">0</a></li>
                    <li><a class="active" href="#">0</a></li>
                </ul> -->
            </div>
        </div>
        <div class="ProductShortcode">       
            <?php echo do_shortcode('[products class="proSlider"]'); ?>
        </div>
    </div>


    
</div>


<div class="fullBorder">
    <div class="product spacing container">
        <div class="productTitle">
            <div class="setTitel">
                <h2>MEMBERSHIP</h2>
                <p>Subscribe to our foundation and get membership to exclusive<br>
                perks such as: Event, Prizes, apparel, food, vacations, cannabis<br>
                and much more.</p>
            </div>
        </div>
        <div class="brands">
            <div class="singleBrand">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/first.svg"/>
                <a class="btn" href="#">20% OFF</a>
                <span><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/user-group-solid.svg"/>45 People Used Today</span>
            </div>
            <div class="singleBrand">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/second.svg"/>
                <a class="btn" href="#">20% OFF</a>
                <span><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/user-group-solid.svg"/>45 People Used Today</span>
            </div>
            <div class="singleBrand">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/third.svg"/>
                <a class="btn" href="#">20% OFF</a>
                <span><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/user-group-solid.svg"/>45 People Used Today</span>
            </div>
            <div class="singleBrand">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/forth.svg"/>
                <a class="btn" href="#">20% OFF</a>
                <span><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/user-group-solid.svg"/>45 People Used Today</span>
            </div>
        </div>
    </div>
</div>


<?php
get_footer();
