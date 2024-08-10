<!DOCTYPE html>
<html>
<link rel="stylesheet" href="css/khalti.css" type="text/css">
<?php
include("connection.php");
session_start();
error_reporting(0);

if(!isset($_SESSION['customer']))
{
	header("location:login.php");
}

$cust= $_SESSION['customer'];
$q2= "SELECT * FROM customers WHERE email= '$cust'";
$data2= mysqli_query($conn, $q2);
$customer_info = $data2->fetch_row();  

if(isset($_POST['pay_type']))
{
	// Get the customer name and total price from the form
	// Get the values from the form
    $cust_name = $_POST['cust_name'];
    $total_price = $_POST['total_price'];
    $pay_type = $_POST['pay_type'];
    $pre_order = 0;
    $delivery_status = 'Processing';
    if(isset($_POST['pre_order'])){
        $pre_order = 1; 
        $delivery_date = $_POST['delivery_date'];
        $delivery_time = $_POST['delivery_time'];
    }

    // Get the items array from session
    $items = json_decode($_SESSION['kela'], true); 
    
    // calcuating the total amount of an order
    $total_amount = 0;
    foreach($items as $item){
        $total_amount = $total_amount + ($item['price'] * $item['quantity']);
    }
    $payment_type = $pay_type;
    $payment_status = 'Pending'; // set payment status based on pay type
    $order_date = date('Y-m-d H:i:s'); 

    // insert in orders table 
    $insert_query = "INSERT INTO `orders` ( `customer_id`,`payment_type`, `payment_status`, `delivery_address`, `total_amount`,`order_date` ,`pre_order` , `delivery_date` , `delivery_time` ,`delivery_status`) 
    VALUES ('$customer_info[0]','$payment_type', '$payment_status', '$delivery_address', '$total_amount' ,'$order_date','$pre_order', '$delivery_date' ,'$delivery_time' , '$delivery_status')"; 
    $result = mysqli_query($conn, $insert_query);  
 


    // get the value of the row inserted in $insert_query query. 
    $order_id = mysqli_insert_id($conn); 
     
    
    // Loop through the items and insert into the orders table
    foreach ($items as $item) {
        $product_title = $item['name'];
        $product_price = $item['price'];
        $product_id = $item['id'];
        $product_qty = $item['quantity'];
        $product_image = $item['image'];
        $vendor_name = $item['vendor_name'];
        $buyer_email = $customer_info[2]; 
        $buyer_phone = $customer_info[7]; 
        $buyer_name = $customer_info[1]; 
        $order_date = date('Y-m-d H:i:s'); 
        $buyer_address = $customer_info[4];
        $delivery_status = 'Processing';  

        // Insert in order summary where the details of products are inserted along with the order_id
        $q3 = "INSERT INTO `order_summary` (`order_id`,`product_title`, `product_id`, `product_price`, `product_qty`, `product_image`, `vendor_name`, `buyer_email`, `buyer_phone`, `buyer_name`, `order_date`, `buyer_address`, `delivery_status`) 
            VALUES ('$order_id', '".$product_title."', '$product_id' ,'$product_price', '$product_qty', '$product_image', '$vendor_name','$buyer_email', '$buyer_phone', '$buyer_name', '$order_date', '$buyer_address' ,'$delivery_status')";
        $result = mysqli_query($conn, $q3);   
        
        // Update the product quantity in the products table
        $q4 = "UPDATE `products` SET `product_qty` = `product_qty` - $product_qty WHERE `product_id` = '$product_id'";
        $qt_change =  mysqli_query($conn, $q4);
    }
?>    
<?php
    // setting value of the order created in session
    $_SESSION["order_id"] = $order_id; 
    // Redirect to order success page
    if($pay_type == 1){    
    header("location: pay.php");
    }else{
        header("location: order_success.php");
    }

    exit;
}else
{
    // If there was an error inserting the order details, redirect to an error page
    echo "Order Failed";
    exit;
}


?>
<html>