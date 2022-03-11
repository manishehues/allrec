<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>

<div class="shop_parallax">
	<div class="sp_text">
		<h1 class="secTitle"><?php woocommerce_page_title(); ?> Shop</h1>
	</div>

</div>


<div id="shopPage" class="shopPage full section pt-5">
	<div class="container">
		<div class="row reverse">
			<div id="sideBar" class="rightSide filltersCategories col-sm-3 proCategory">
				<div class="side_position">
					<?php dynamic_sidebar('sidebar-1'); ?>
				</div>
			</div>			
			<div id="rightSide" class="col-sm-9 leftSide wooProducts column column3 float-right">
				<div class="heading full text-center mb-3" style="margin-bottom: 0px;">
					<!-- <h1 class="secTitle"><?php //woocommerce_page_title(); ?></h1> -->
					<?php 
						$parent_id =  get_queried_object()->parent;
						$parent_cat = get_term( $parent_id );
					 ?>
					 <?php if ($parent_id && $parent_cat->slug == 'bulk'): ?>
						<!-- <h1 class="secTitle">Bulk <?php woocommerce_page_title(); ?></h1> -->
					 <?php endif ?>
				</div>
				<?php

					global $wp_query;

					if (!empty($wp_query->query_vars['product_cat']) && $wp_query->query_vars['product_cat'] == 'bulk'){ ?>
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/bulk_slide.jpg" class="img-responsive" style="margin-bottom: 15px;">			
					<?php 

					$woocommerce_category_id = get_queried_object_id();
					$args = array(
					      'parent' => $woocommerce_category_id
					);
					$terms = get_terms( 'product_cat', $args );
					/*echo "<pre>";
					print_r($terms);
					echo "</pre>";*/
					
					//on_sale="true"
					foreach ($terms as $key => $term) {
						//echo "<h2 class='text-center'>" . $term->name . "</h2>";
						echo do_shortcode('[products limit="5" columns="5" category="' . $term->slug . '" on_sale="true"]');
						echo "<div class='text-center shopbt'><a style='border-radius: 25px;' class='btn btn-success btn-sm' href=" . get_term_link($term->term_id) . ">View More " . $term->name . "</a></div>";
					}
				}else{


					if ( woocommerce_product_loop() ) {

						/**
						 * Hook: woocommerce_before_shop_loop.
						 *
						 * @hooked wc_print_notices - 10
						 * @hooked woocommerce_result_count - 20
						 * @hooked woocommerce_catalog_ordering - 30
						 */
						do_action( 'woocommerce_before_shop_loop' );
					
						woocommerce_product_loop_start();
					
						if ( wc_get_loop_prop( 'total' ) ) {
							while ( have_posts() ) {
								the_post();
					
								/**
								 * Hook: woocommerce_shop_loop.
								 *
								 * @hooked WC_Structured_Data::generate_product_data() - 10
								 */
								do_action( 'woocommerce_shop_loop' );
					
								wc_get_template_part( 'content', 'product' );
							}
						}
					
						woocommerce_product_loop_end();
					
						/**
						 * Hook: woocommerce_after_shop_loop.
						 *
						 * @hooked woocommerce_pagination - 10
						 */
						do_action( 'woocommerce_after_shop_loop' );
					} else {
						/**
						 * Hook: woocommerce_no_products_found.
						 *
						 * @hooked wc_no_products_found - 10
						 */
						do_action( 'woocommerce_no_products_found' );
					}
				}
					/**
					 * Hook: woocommerce_after_main_content.
					 *
					 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
					 */
					do_action( 'woocommerce_after_main_content' );				
				?>
			</div>	
		</div>
	</div>
</div>

<?php get_footer( 'shop' );?>
