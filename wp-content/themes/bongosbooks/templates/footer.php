<?php
    use TMProd\Base\Assets;
?>
				<?php $has_sub1 = wcs_user_has_subscription( get_current_user_id(), 389, 'active' );  
					$has_sub2 = wcs_user_has_subscription( get_current_user_id(), 361, 'active' ); 	?>
<section class="subscribe-cta">
    <div class="container">
	
        <h2>Sign up to follow all of the adventures</h2>
        <p>Pick apples with Bella, play baseball with Billy, volunteer with Jayni, and have great fun with Jax. There's adventure around every corner!</p>
		<?php if (empty($has_sub1)&&empty($has_sub2)  ) { ?>
        <a href="#" class="button subscribe-footer">Subscribe now!</a>
			<?php }else{ ?>
			  <a href="#" class="button ">Thank You for Subscribe</a>
			<?php } ?>
    </div>
</section>
<footer class="site-footer">
    <div class="container">
        <?php if ( has_nav_menu( 'footer_menu' ) ) :
            wp_nav_menu( [
                'theme_location' => 'footer_menu',
                'menu_class'     => 'nav',
                'container'      => false
            ] );
        endif; ?>
    </div>
    <img src="<?php echo Assets\asset_path('images/boat-monkey.png'); ?>" class="overlay" alt="Monkey's at sea!">
</footer>
<?php if ( is_front_page() ) { ?>
    <p class="site-credit" itemscope itemtype="http://schema.org/Organization">
		© Copyright Bongo's Adventures <a target="_blank" href="http://www.webmobilez.com/">Designed by WebMobileZ</a>
        <!--Copyright <?php //echo date("Y"); ?> &copy; Bongo's Adventures. All right reserved.-->
    </p>
<?php } ?>


<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 111; /* Sit on top */
  padding-top: 100px; /* Location of the box */
	
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto auto 100px auto;
  padding: 20px;
  border: 1px solid #888;
  width: 70%;
	text-align: center;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
	
	.modal-content.p_price a{
		text-align: center;
		display:inline-block;
		margin-bottom: 20px;
	}
	.modal-content.p_price a img{
	width: 200px;	
	}
	.modal-content.p_price a h2{
		font-size: 22px;
margin-top: 15px;
	}
	.modal-content.p_price a span{ font-size: 13px;}
	.content{position: relative;}
</style>
<!--
<h2>Modal Example</h2>

 Trigger/Open The Modal
<button id="myBtn">Open Modal</button> -->
<div id="newmodal" class="modal">

  <!-- Modal1 content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <h3 align="center">
	Register here for more questions 
		
	  </h3>
	  <h4 align="center">
		  <a href="http://bongosbooks.com/my-account">Register/login</a>
	  </h4>
  </div>

</div>
<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content p_price">
    <span class="close">&times;</span>
     
		<?php 
		$product = new WC_Product(389); 
		$product1 = new WC_Product(361); 
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( 389 ), 'single-post-thumbnail' );?>
    <a href="<?php echo get_permalink(389);?> "><img src="<?php  echo $image[0]; ?>" data-id="389">
		<h2 class="woocommerce-loop-product__title"><?php echo $product->get_name(); ?></h2>
		
		<span class="price"> <span class="subscription-details"> <?php echo    wc_price($product->get_price_including_tax(1,$product->get_price())); ?></span></span>
		 
		<span>Subscribe Now</span></a>
	 
	  <a href="<?php echo get_permalink(361);?> "><img src="<?php  echo $image[0]; ?>" data-id="389">
		  <h2 class="woocommerce-loop-product__title"><?php echo $product1->get_name(); ?></h2>
		  <span class="price"><span class="woocommerce-Price-amount amount"><?php echo    wc_price($product1->get_price_including_tax(1,$product1->get_price())); ?></span></span>
		
		<span>Subscribe Now</span></a>
	  
  </div>

</div>


<script>
// Get the modal
var modal = document.getElementById('myModal');
var newmodal = document.getElementById('newmodal');

// Get the button that opens the modal
//var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[1];

// When the user clicks the button, open the modal 
/* btn.onclick = function() {
  modal.style.display = "block";
	document.body.style.overflow = "hidden";
} */

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
	document.body.style.overflow = "auto";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
window.onclick = function(event) {
 
      if (event.target == newmodal) {
	newmodal.style.display = "none";
  }
}	
	jQuery(".subscribe-footer").click(function(){

	 modal.style.display = "block";
	document.body.style.overflow = "hidden";
});

	jQuery(".restricted-content").click(function(){

	 modal.style.display = "block";
	document.body.style.overflow = "hidden";
});
</script>
