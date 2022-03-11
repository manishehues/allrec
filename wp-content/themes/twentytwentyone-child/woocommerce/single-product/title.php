<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @package    WooCommerce\Templates
 * @version    1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

the_title( '<h1 class="product_title entry-title">', '</h1>' );

?>
	<div class="single-page products-grades-types">
	   <?php $types_grades = ehuesDEV_jit_product_type_grades();

            if (!empty($types_grades)) {?>
                <ul id="single-page-types_grades">
                    <?php if(!empty($types_grades['prdct_type'])) : ?>
                        <li class="<?php echo $types_grades['color_class'];?>"><?php echo $types_grades['prdct_type']; ?></li>
                    <?php endif; ?>

                    <?php if(!empty($types_grades['grades'])) : ?>
                        <li class="prdct-grade"><?php echo $types_grades['grades']; ?></li>
                    <?php endif; ?>

                </ul>
            <?php } ?>

	</div>
<?php 

