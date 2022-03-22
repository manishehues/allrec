<?php 
/* Child theme generated with WPS Child Theme Generator */
            
if ( ! function_exists( 'b7ectg_theme_enqueue_styles' ) ) {            
    add_action( 'wp_enqueue_scripts', 'b7ectg_theme_enqueue_styles' );
    
    function b7ectg_theme_enqueue_styles() {
        wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
        wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'parent-style' ) );
     wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/assets/css/custom.css', array( 'parent-style' ) );
     wp_enqueue_style( 'slick-style', get_stylesheet_directory_uri() . '/assets/css/slick.css', array( 'parent-style' ) );
     wp_enqueue_style( 'responsive-style', get_stylesheet_directory_uri() . '/assets/css/responsive.css', array( 'parent-style' ) );

     wp_enqueue_script( 'slick-js', get_stylesheet_directory_uri() . '/assets/js/slick.js' );     
     wp_enqueue_script( 'global-js', get_stylesheet_directory_uri() . '/assets/js/global.js' );

    }
}


/*remove breadcrums*/    
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
/*remove breadcrums*/    
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );