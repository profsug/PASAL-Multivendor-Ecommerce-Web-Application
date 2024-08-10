<?php 
session_start();

include("connection.php");
error_reporting(0);

if(!isset($_SESSION['customer']))
{
	header("location:index.php");
}

$cust= $_SESSION['customer'];

?>

<!DOCTYPE html>
<html>
<head>
<title>Order Placed</title>
 <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>

<body>
    <?php 
    $q2= "SELECT * FROM customers WHERE email= '$cust'";
    $data2= mysqli_query($conn, $q2);
    while($res2= mysqli_fetch_assoc($data2)){
        $address= $res2['street'].", ".$res2['city'].", ".$res2['pincode'];
    }

    $order_id = $_SESSION['order_id'];
    $query= "SELECT * from orders where order_id='".$order_id."'";
    $data= mysqli_query($conn, $query);
    $result = $data->fetch_row();   
    
    unset($_SESSION['order_id']);
    $payment_type = $result[2];
    $payment_status = $result[3];
    $payment_token = $result[4];
    $total_amount = $result[7];
    $order_date = $result[8];
    $pre_order = $result[9];
    $delivery_date = $result[10];
    $delivery_time = $result[1];
    ?>
     

    <div class="container">
        <div class="row justify-content-center">
            <div class="table-responsive">
                <?php
                $somerand= "COD".mt_rand(100000000,999999999);
                $q2= "SELECT * FROM customers WHERE email='$cust'";
                $data2= mysqli_query($conn, $q2);
                $res2= mysqli_fetch_assoc($data2);
                ?>
                <h2 class="text-center text-black mb-5" style="margin-top: 20px;">Order Placed</h2>
                <table class="table table-bordered" style="margin-top: 40px;">
                    <tr>
                        <th>Purchased from</th>
                        <td>PASAL</td>
                    </tr>
                    <?php if($pre_order == 1){ ?> 
                    <tr>
                        <th>Order Type</th>
                        <td>Pre Order</td>
                    </tr>
                    <tr>
                        <th>Delivery Date and Time</th>
                        <td><?php echo $delivery_date . " " .$delivery_time ; ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <th>Payment Type</th>
                        <td><?php if($payment_type == 1){echo "Online Payment";}elseif($payment_type == 2 ){echo"Cash On Delivery";} ?></td>
                    </tr>
                    <tr>
                        <th>Payment Token</th>
                        <td><?php echo $payment_token; ?></td>
                    </tr>
                    <tr>
                        <th>Buyer Name</th>
                        <td><?= $res2['username']; ?></td>
                    </tr>
                    <tr>
                        <th>Buyer Phone No.</th>
                        <td><?= $res2['phone']; ?></td>
                    </tr>
                    <tr>
                        <th>Buyer Email</th>
                        <td><?= $res2['email']; ?></td>
                    </tr>
                    <tr>
                        <th>Buyer Address</th>
                        <td><?= $address; ?></td>
                    </tr>
                    <tr>
                        <th>Payment Status</th>
                        <td><?= $payment_status ?></td>
                    </tr>
                    <tr>
                        <th>Order Date</th>
                        <td><?php echo $order_date;?></td>
                    </tr>
                </table>
                <div class="text-center text-danger mb-2">
                    <button name="order" class="btn btn-danger" onclick='window.location.href = "http://localhost/pasal/order.php"'>Track your Order</button>
                    <button name="shopping" class="btn btn-success" onclick='window.location.href = "http://localhost/pasal/cust-index.php"'>Continue Shopping</button>
                </div>

			</div>
		</div>
	</div>
    <script src="js/jquery-2.2.3.min.js"></script>
    <script type='text/javascript' src="js/jquery.mycart.js"></script>
    <script type="text/javascript">
        var products = JSON.parse(localStorage.clear());   
  </script>
<script>
var myVar;


function myFunction() {
  myVar = setTimeout(showPage, 3000);
}

function showPage() {
  document.getElementById("loader").style.display = "none";
  document.getElementById("myDiv").style.display = "block";
}
</script>
</body>
</html>