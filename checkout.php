<?php 
session_start();

include("connection.php");
error_reporting(0);

if(!isset($_SESSION['customer']))
{
	header("location:login.php");
}

$cust= $_SESSION['customer'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Customer Cart</title>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	  <link href="https://fonts.googleapis.com/css?family=Abril+Fatface|Dancing+Script" rel="stylesheet">
	  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">

 
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/i18n/defaults-*.min.js"></script>
</head>
<body class="container">


	<h1 class="text-center text-black mb-5" 
	style="font-family: 'Abril Fatface'; margin-top: 20px;">
	<span class="fa fa-shopping-cart my-cart-icon"></span>
	Your Cart</h1>

<form action="order_confimation.php" method="post">	
	<div class="row">
		<?php
		
		if(isset($_GET['array']) && isset($_GET['total']))
		{
			$some= json_decode($_GET['array']);
			$_SESSION['kela']= $_GET['array'];
			$tot= $_GET['total'];
		}
		else{
			header("location:index.php"); // Redirect to index.php if $_GET['array'] or $_GET['total'] is not set
		}
		
		$items = array();
		foreach($some as $arr) {
		    foreach($arr as $key => $value) {
		        $items[$key] = $value;
		    }
		    ?>

		    <input type="hidden" name="cust_name" value="<?php echo $cust; ?>">
		    <input type="hidden" name="total_price" value="<?php echo $tot; ?>">

			<div class="col-lg-3 col-md-3 col-sm-12">
				<div class="card">
					<h6 class="card-title bg-info text-white p-2 text-uppercase"><?php echo $items['name'];?></h6>

					<div class="card-body">
						<img src="<?php echo $items['image']; ?>" alt="phone" class="img-fluid mb-2" >

						<h6 class="card-title bg-danger text-white p-2"> Rs <?php echo $items['price']; ?></h6> 

						<h6 class="card-title bg-info text-white p-2"> Quantity <?php echo $items['quantity'];?></h6>
					</div>
				</div>
			</div>
		    <?php 
		}
		?>
	</div>
	<hr>
	<div class="mb-5" >
		<div class="row">
			<div class="col-md-4 pre_order_check form-group">
				<label>Pre-Order  </label>
				<input type="checkbox" id="pre_order" name="pre_order" value="1">                         
			</div>
		</div>
		<div class="row" id='pre_order_div'>
			<div class="col-md-4 form-group">
				<label>Delivery Date </label>
				<input type="date" class="form-control" id='delivery_date' name="delivery_date">                           
			</div>
			<div class="col-md-4 form-group">
				<label>Delivery Time </label>
				<input type="time" class="form-control" id='delivery_time' name="delivery_time">                           
			</div>
		</div>
	</div>

	<div class="text-center text-danger mb-3" style="padding-top: 10px;">
		<h4>
			<img src="./images/delivery-truck.png" alt="" style="height:50px; width: 50px;">
			Choose order method</h4>
	</div>

	<div class="text-center text-danger mb-5">
		<button name="pay_type" value="1" class="btn btn-danger" id='online_payment'>Online Payment</button>
		<button name="pay_type" value="2" class="btn btn-danger" >Cash on Delivery: <?php echo $tot;?> + Shipping</button> 
	</div>

	

</form> 
 
<script src="js/jquery-1.11.1.min.js"></script>
<script>
// hides the input feilds required for pre-order feature
$("#pre_order_div").hide();
// is triggered when checkbox in clicked
$(".pre_order_check :checkbox").click(function () {	

	// if checbox in clickedshows pre - order input feilds and hides online payment.  
    if (this.checked){
	$("#pre_order_div").show();  
	$("#online_payment").hide();
	}else{ 
	$("#pre_order_div").hide(); 
	$("#online_payment").show();
	}
});

</script>
</body>
</html>