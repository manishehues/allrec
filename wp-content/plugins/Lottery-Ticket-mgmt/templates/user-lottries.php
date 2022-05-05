<?php 
/* 
Template Name: UserLottries 
*/ 
get_header();

?>

<div class="accountTabs">
	<div class="tabBtn">
		<a href="http://localhost/allrec/account/" class="account">Account</a><a href="http://localhost/allrec/my-account/" class="dash">Dashboard</a>
	</div>
</div>
<div class="container">
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

							<?php $user_participated_tickets = get_users_participated_tikets_nos($user_lottery->ID);
								//print_r($user_participated_tickets);
								if(!empty( $user_participated_tickets)){
								foreach ($user_participated_tickets as $key => $user_participated_ticket) { ?>

								<?php }
							}


							?>
							<div class="cart_tittle">
				              <h1><?php  echo $user_lottery->post_title; ?></h1>
								<!-- <a href="javascript:void(0)" class="btn btn-primary ">Already Participate</a> -->
	            			</div>
	            			<div class="lottryNumber">
          						Raffle Draw <br>5/150 
      					 	</div>
						</div>
            			<div class="ticket">
							<ul>
								<li><?php echo $user_participated_ticket->ticket_number;?></li>
								<li>53654</li>
								<li>98567</li>
								<li>68726</li>
								<li>85334</li>
								<li>00597</li>	
							</ul>	
						</div>
					</div>


				<?php }
			}

		?>
	</div>


</div>
	
<?php get_footer(); ?>