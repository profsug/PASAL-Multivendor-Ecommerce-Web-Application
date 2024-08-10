<?php 
session_start();

include("connection.php");
error_reporting(0);

$cust= $_SESSION['customer'];
?>

<div class="footer">
	<div class="container">
		<div class="col-md-3 footer-grid">
			<h3>About Us</h3>
			<p> We Believe in providing you with the Best, Fresh and A-grade fruits and vegetables for your daily kitchen, household. </p>
		</div>
		<div class="col-md-3 footer-grid ">
			<h3>Menu</h3>
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="Fruits.php">Fruits</a></li>
				<li><a href="care.php">Vegetables</a></li>
				<li><a href="contact.php">Contact</a></li>
			</ul>
		</div>
		<div class="col-md-3 footer-grid ">
			<h3>Customer Services</h3>
			<ul>
				
				<li><a href="terms.php">Terms & Conditions</a></li>
				<li><a href="FAQ.php">FAQs</a></li>
				<li><a href="contact.php">Contact</a></li>
				<li><a href="offer.php">Online Shopping</a></li>						 
				 
			</ul>
		</div>
		<?php 
			if(isset($_SESSION['customer']))
			{
				
			?>
		<div class="col-md-3 footer-grid">
			<h3>My Account</h3>
			<ul>
				<li><a href="order.php">My Orders</a></li>
				<li><a href="cust-logout.php">Logout</a></li>
				
			</ul>
		</div>
		<?php
			}

			

			?>		
		<div class="clearfix"></div>
			<div class="footer-bottom">
				<h2 ><a href="index.php"><b>T<br>H<br>E</b>PASAL<span>Best Store</span></a></h2>
				<p class="fo-para"> We Believe in providing you with the Best, Fresh and A-grade fruits and vegetables for your daily kitchen, household.</p>
				<ul class="social-fo">
					<li><a href="#" class=" face"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
					<li><a href="#" class=" twi"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
					<li><a href="#" class=" pin"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
					<li><a href="#" class=" dri"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
				</ul>
				<div class=" address">
					<div class="col-md-4 fo-grid1">
							<p><i class="fa fa-home" aria-hidden="true"></i> kalimati-14 , Kathmandu </p>
					</div>
					<div class="col-md-4 fo-grid1">
							<p><i class="fa fa-phone" aria-hidden="true"></i> +977 9841293436 </p>	
					</div>
					<div class="col-md-4 fo-grid1">
						<p><a href="mailto:info@example.com"><i class="fa fa-envelope-o" aria-hidden="true"></i> gaurishankhar@gmail.com </a></p>
					</div>
					<div class="clearfix"></div>
					
					</div>
			</div>
		<div class="copy-right">
			<p> &copy; 2023 Gaurishankhar Pvt Ltd. All Rights Reserved  </a></p>
		</div>
	</div>
</div>