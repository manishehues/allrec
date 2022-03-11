<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );

$wallet_balance = woo_wallet()->wallet->get_wallet_balance_in_number(get_current_user_id());
$money_img = get_bloginfo('stylesheet_directory')."/assets/images/piggy-bank.png";

?>
<nav class="woocommerce-MyAccount-navigation">
	<ul>
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
			<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label );  ?> 
                <?php if($endpoint == 'woo-wallet' && $wallet_balance >= 20){ ?>
                        <!-- <img class="money-bag" src="<?php echo $money_img;?>" > -->
                        🤑 
                <?php } ?></a>
			</li>
		<?php endforeach;  
?>
	</ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
