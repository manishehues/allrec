<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$allowed_html = array(
	'a' => array(
		'href' => array(),
	),
);
?>

<p>
	<?php
	printf(
		/* translators: 1: user display name 2: logout url */
		wp_kses( __( 'Hello %1$s (not %1$s? <a href="%2$s">Log out</a>)', 'woocommerce' ), $allowed_html ),
		'<strong>' . esc_html( $current_user->display_name ) . '</strong>',
		esc_url( wc_logout_url() )
	);
	?>

</p>
<div class="ticket_tittle">
		<div class="tittle">
			<div class="content">
				<h1>TICKETS</h1>
				<p>Purchasing merch will enter you in our give away raffles<br>
				Every $20 dollars spent will generate you a numbered ticket for higher chance of winning</p>
				<div class="savedTicket">
					<div class="ticketConten">Tickets you have seved</div>
					<div class="numberOff">6</div>
					<div class="QRcode">
						<h1>MEMBERSHIP</h1>
						<p>Scan your QR code at the store to get your<br> discount</p>
						<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/qr-code.svg"/>
					</div>
				</div>
				<h1>ENTERED</h1>
				<p>Automatically get notified and contacted if you win a prize.</p>
			</div>
		</div>
	</div>
	<div class="lotrySelection">
		<?php 
			$user_lotteries = get_users_participated_lotteries();
			if(!empty($user_lotteries)){
				foreach ($user_lotteries as $key => $user_lottery) { ?>
					<div class="Singlelotry Sap">
						<div class="tittleCart">
							<?php echo get_the_post_thumbnail($user_lottery->ID,'large');?>

							
							<div class="cart_tittle">
				              <h1><?php  echo $user_lottery->post_title; ?></h1>
								<!-- <a href="javascript:void(0)" class="btn btn-primary ">Already Participate</a> -->
	            			</div>
	            			<div class="lottryNumber">
          						Raffle Draw <br>
								  <?php echo check_total_participate_per_post($user_lottery->ID) ?>/
								  <?php echo get_post_meta($user_lottery->ID,'total_participants',true); ?>
      					 	</div>
						</div>
            			<div class="ticket">
            				 <?php $user_participated_tickets = get_users_participated_tikets_nos($user_lottery->ID);?>
            					<div class="ticketshowUs"><?php echo count($user_participated_tickets); ?></div>
							<ul>
							<?php //$user_participated_tickets = get_users_participated_tikets_nos($user_lottery->ID);
								//print_r($user_participated_tickets);
								if(!empty( $user_participated_tickets)){
								foreach ($user_participated_tickets as $key => $user_participated_ticket) { ?><li><?php echo $user_participated_ticket->ticket_number;?></li><?php }
							}


							?>

									
							</ul>	
						</div>
					</div>


				<?php }
			}

		?>
	</div>
<p>
	
	<?php
	/* translators: 1: Orders URL 2: Address URL 3: Account URL. */
	$dashboard_desc = __( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">billing address</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce' );
	if ( wc_shipping_enabled() ) {
		/* translators: 1: Orders URL 2: Addresses URL 3: Account URL. */
		$dashboard_desc = __( 'From your account dashboard you can view your <a href="%1$s">recent orders</a>, manage your <a href="%2$s">shipping and billing addresses</a>, and <a href="%3$s">edit your password and account details</a>.', 'woocommerce' );
	}
	printf(
		wp_kses( $dashboard_desc, $allowed_html ),
		esc_url( wc_get_endpoint_url( 'orders' ) ),
		esc_url( wc_get_endpoint_url( 'edit-address' ) ),
		esc_url( wc_get_endpoint_url( 'edit-account' ) )
	);
	?>
</p>

<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
