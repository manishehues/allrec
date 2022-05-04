<?php 
/* 
Template Name: UserLottries 
*/ 
get_header();

?>
<div class="container">
	<div class="ticket_tittle">
		<div class="tittle">
			<div class="content">
				<h1><span>EVENTS</span></h1>
				<p>Come join us at these events and have some fun!</p>

				<?php 
					$user_lotteries = get_users_participated_lotteries();
					if(!empty($user_lotteries)){
						foreach ($user_lotteries as $key => $user_lottery) { ?>
							<div class="ticket_tittle">
								<h1><?php echo $user_lottery->post_title; ?></h1>
								<?php echo get_the_post_thumbnail($user_lottery->ID,'large');?>
								<?php $user_participated_tickets = get_users_participated_tikets_nos($user_lottery->ID);
									//print_r($user_participated_tickets);
									if(!empty( $user_participated_tickets)){

									foreach ($user_participated_tickets as $key => $user_participated_ticket) { ?>

										<div class="ticket"><?php echo $user_participated_ticket->ticket_number;?></div>



									<?php }
								}


								?>
								
							</div>

						<?php }
					}

				?>



			</div>
		</div>
	</div>


</div>
	
<?php get_footer(); ?>