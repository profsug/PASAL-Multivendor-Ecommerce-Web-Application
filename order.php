<?php 
session_start();
/*ini_set('display_errors', 1);*/
include("connection.php");
error_reporting(0);


$cust= $_SESSION['customer'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Order Page</title>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom Theme files -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<!-- js -->
   <script src="js/jquery-1.11.1.min.js"></script>
<!-- //js -->
<!-- start-smoth-scrolling -->
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event){		
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
		});
	});
</script>
<!-- start-smoth-scrolling -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Noto+Sans:400,700' rel='stylesheet' type='text/css'>
<!--- start-rate---->
<script src="js/jstarbox.js"></script>
	<link rel="stylesheet" href="css/jstarbox.css" type="text/css" media="screen" charset="utf-8" />
		

</head>
<body>
<a href="offer.php"><img src="images/download.png" class="img-head" alt=""></a>
<div class="header">

		<div class="container">
			
			<div class="logo">
				<h1 ><a href="index.php"><b>T<br>H<br>E</b>PASAL<span>Best Store</span></a></h1>
			</div>
			
			<?php 
			if(isset($_SESSION['customer']))
			{
	
			?>
			<div class="header">
				<b>Welcome </b><b style="color: green;"><?php echo $cust; ?></b>
			</div>

			<div class="head-t">
				<ul class="card">
					<li><a href="order.php" ><i class="fa fa-arrow-right" aria-hidden="true"></i>Orders</a></li>
					
					<li><a href="about.php" ><i class="fa fa-file-text-o" aria-hidden="true"></i>About Us</a></li>
					<li><a href="FAQ.php" ><i class="fa fa-ship" aria-hidden="true"></i>FAQ</a></li>
					<li><a href="cust-logout.php" ><i class="fa fa-user" aria-hidden="true"></i>Logout</a></li>
				</ul>	
			</div>

			<?php
			}
			else{
				?>
			<div class="head-t">
				<ul class="card">
					<li><a href="login.php" ><i class="fa fa-user" aria-hidden="true"></i>Login</a></li>
					<li><a href="register.php" ><i class="fa fa-arrow-right" aria-hidden="true"></i>Register</a></li>
					
					<li><a href="about.php" ><i class="fa fa-file-text-o" aria-hidden="true"></i>About Us</a></li>
					<li><a href="FAQ.php" ><i class="fa fa-ship" aria-hidden="true"></i>FAQ</a></li>
				</ul>	
			</div>	 
			<?php
			}
			?>
			<div class="header-ri">
				<ul class="social-top">
					<li><a href="#" class="icon facebook"><i class="fa fa-facebook" aria-hidden="true"></i><span></span></a></li>
					<li><a href="#" class="icon twitter"><i class="fa fa-twitter" aria-hidden="true"></i><span></span></a></li>
					<li><a href="#" class="icon pinterest"><i class="fa fa-pinterest-p" aria-hidden="true"></i><span></span></a></li>
					<li><a href="#" class="icon dribbble"><i class="fa fa-dribbble" aria-hidden="true"></i><span></span></a></li>
				</ul>	
			</div>
				<?php include_once("top.php"); ?>
					
				</div>
				</div>			
</div>
  <!---->
    <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <a href="care.php"><img class="first-slide" src="images/caro2.jpg" alt="First slide"></a>
       
        </div>
        <div class="item">
          <a href="kitchen.php"><img class="second-slide " src="images/caro1.jpg" alt="Second slide"></a>
         
        </div>
        <div class="item">
          <a href="hold.php"><img class="third-slide " src="images/caro3.jpg" alt="Third slide"></a>
          
        </div>
      </div>
    
    </div>
    <!-- /.carousel -->

		<div class="product">
		<div class="container">
			<div class="spec ">
				<h3>Order Page</h3>
				<div class="ser-t">
					<b></b>
					<span><i></i></span>
					<b class="line"></b>
				</div>
			</div>
			<?php  
				include_once("./classes/Database.php");
				$db = new Database();
				$con = $db->connect(); 
				$query = $con->query("SELECT * FROM orders  join customers on orders.customer_id = customers.id WHERE customers.email = '$cust' order by orders.created_at DESC "); 
				if ($query->num_rows > 0) {                
					$result = $query->fetch_all(); 
				} 																
			?>
			<div class="table-responsive">
				<table class="table table-striped table-sm">
				<thead>
					<tr>
					<th>#</th>
					<th>Order Date</th>
					<th>Payment Type</th>
					<th>Total Amount</th>
					<th>Payment Status</th>
					
					<th>View Order Details</th>
					</tr>
				</thead>
				<tbody id="customer_order_list">
				<?php 
				if($query->num_rows > 0){
					$i=0; foreach($result as $row){ $i++; ?> 
						<tr>
						<td><?= $i ?></td>
						<td><?= $row[8] ?></td>
						<td><?php if($row[2] == 1){echo "Online Payment";}elseif($row[2] == 2){ echo "Cash On Delviery";} ?></td>
						<td><?= $row[7] ?></td>
						<td><?= $row[3] ?></td>
						<td> <a href="#" data-toggle="modal" data-target="#view_products" class="btn btn-success btn-md"  onclick="view_order(<?= $row[0] ?>)">View Products</a></td>
						</tr>
				<?php 
					}
				}?>
				</tbody>
				</table> 
			</div>  
		</div>
	</div> 

<!--footer-->
<?php include_once("footer.php"); ?>
<script src="js/jquery-1.11.1.min.js"></script>
<!-- contains code of pop-up and ajax of view order and changing delivery status -->
<?php include_once("view_order.php"); ?>
<!-- //footer-->
<!-- for bootstrap working -->
		<script src="js/bootstrap.js"></script>
<!-- //for bootstrap working -->
<script type='text/javascript' src="js/jquery.mycart.js"></script>
  <script type="text/javascript">
  $(function () {
    var goToCartIcon = function($addTocartBtn){
      var $cartIcon = $(".my-cart-icon");
      var $image = $('<img width="30px" height="30px" src="' + $addTocartBtn.data("image") + '"/>').css({"position": "fixed", "z-index": "999"});
      $addTocartBtn.prepend($image);
      var position = $cartIcon.position();
      $image.animate({
        top: position.top,
        left: position.left
      }, 500 , "linear", function() {
        $image.remove();
      });
    }
    $('.my-cart-btn').myCart({
      classCartIcon: 'my-cart-icon',
      classCartBadge: 'my-cart-badge',
      affixCartIcon: true,
      checkoutCart: function(products) {
        $.each(products, function(){
          console.log(this);
        });
      },
      clickOnAddToCart: function($addTocart){
        goToCartIcon($addTocart);
      },
      getDiscountPrice: function(products) {
        var total = 0;
        $.each(products, function(){
          total += this.quantity * this.price;
        });
        return total * 1;
      }
    });
  });
  </script>
</body>
</html>