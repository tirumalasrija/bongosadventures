	<?php
/**
 * Template Name: Event Page
 */

use TMProd\Base\Extras as Extras;
use TMProd\Base\Assets as Assets;
$args = array(
    'post_type'    => 'events',
    'type'         => 'monthly',
    'echo'         => 0
);

?>

<style>
	.lock_div_over {
		position: absolute; width: 100%;
		height: 100%; background-color: rgba(0,0,0,0); z-index:5;
	}
	.lock {
		position: absolute;
		left: 50%;
		transform: translateX(-50%);
		}
	.page-wrap .container{
		filter: blur(5px);
		}
	.page-wrap{
		filter: blur(0px) !important;
		}
	.page-wrap .container {
		filter: blur(0px);
		}
	.p_left_menu {
		display:inline-block; width: 30%;
		}
	.p_result_div {
		display: inline-block;
		position: absolute; 
		top: 30px; width: 70%;
		}
</style>
  <?php 
			/* Get Active subcriptions */
			$has_sub1 = wcs_user_has_subscription( get_current_user_id(), 389, 'active' );  
			$has_sub2 = wcs_user_has_subscription( get_current_user_id(), 361, 'active' );  
			//$startdate = wcs_get_subscriptions(get_current_user_id());
			/*echo "<pre>"; 
		$cust= get_posts( 
		array(   "numberposts" => -1,
				"meta_key"  => "_customer_user",
				"meta_value" => get_current_user_id(),
				"post_type" => 'shop_subscription',
				"post_status"=>'wc-active' ));
				foreach($cust as $subs)
				{
					$subs=new WC_Subscription($subs->ID);
					foreach($subs->date_created as $value){
						print_r($value);
					}
					
				}
		*/
	?>
 
<div class="w3-sidebar w3-bar-block w3-light-grey w3-card p_left_menu">
  <h5 class="w3-bar-item">Events</h5>
	<?php for ($i = 0; $i < 6; $i++) { ?>
	 <?php if (empty($has_sub1)&&empty($has_sub2)) { ?>
	<button class="w3-bar-item w3-button tablink" onclick="redirect();"><?php echo date(' F Y', strtotime("-$i month")); ?></button>
	<?php } else { ?>
	<button class="w3-bar-item w3-button tablink" onclick="openCity(event, <?php echo strtotime("-$i month"); ?>)"><?php echo date(' F Y', strtotime("-$i month")); ?></button> 
	<?php } } ?>  
</div>
	 <?php if (empty($has_sub1)&&empty($has_sub2)  ) {	} else{ ?>
	<div class="p_result_div">
		<div class="w3-padding"></div>
		<?php for ($i = 0; $i < 6; $i++) { ?>
				<div id='<?php echo strtotime("-$i month"); ?>' class="w3-container city" style="display:none">
					<h2><?php echo date(' F Y', strtotime("-$i month")); ?></h2>
					
					<?php $month =date('m', strtotime("-$i month"));
						$args = array(
							  'post_type'    => 'events',
						'date_query' => array(
							array(
								'month' => $month
							)
						)
					);
					$query = new WP_Query( $args ); 	
					while($query->have_posts())
						{
								$query->the_post(); ?>
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<p><?php the_content(); ?></p>
					<?php  } ?>
				</div>
		<?php } ?>
	</div>
	 <?php } ?>
<div class="lesson" style="background-image: url('http://bongosbooks.com/wp-content/uploads/2019/03/WhatsApp-Image-2019-03-03-at-1.05.37-AM.jpeg'); ?>');">
<script>
	function redirect()
	{
		//window.location = "http://universitiesconnect.com/shop";
	}
	function openCity(evt, cityName) {
	  var i, x, tablinks;
	  x = document.getElementsByClassName("city");
	  for (i = 0; i < x.length; i++) {
		x[i].style.display = "none";
	  }
	  tablinks = document.getElementsByClassName("tablink");
	  for (i = 0; i < x.length; i++) {
		tablinks[i].className = tablinks[i].className.replace(" w3-red", ""); 
	  }
	  document.getElementById(cityName).style.display = "block";
	  evt.currentTarget.className += " w3-red";
	}
</script>
	
	 <?php if (empty($has_sub1)&&empty($has_sub2)  ) { ?>
		<style>
				.page-wrap {
					 filter: blur(5px); 
					
				}
								.page-wrap .container {
					filter: blur(5px);
				}

		</style>
	
		<script type="text/javascript">
			jQuery( ".page-wrap" ).prepend(function() {
				  return '<div class="lock_div_over"></div><div class="lock"><img src="http://bongosbooks.com/wp-content/themes/bongosbooks/dist/images/utility-icons/lock.png"></div>';
				});
			 jQuery(".page-wrap").click(function(){
					 modal.style.display = "block";
				document.body.style.overflow = "hidden"; 
				 });

		</script>

	<?php } ?>
 <?php  // '<ul>'.wp_get_archives($args).'</ul>'; ?>
	
    </section>

