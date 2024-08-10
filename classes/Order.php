<?php
session_start();

/**
 * 
 */
class Order
{
	
	private $con;

	function __construct()
	{
		include_once("Database.php");
		$db = new Database();
		$this->con = $db->connect();
	} 

	// updates the payment for an online payment order
	public function updatePayment($order_id , $payment_token , $payment_status , $payment_user){ 

		if($payment_status == 'Completed'){
			$payment_status = 'Paid';
		}
		$sql = "UPDATE orders SET `payment_token`='$payment_token',`payment_status`='$payment_status',`payment_user`='$payment_user' WHERE order_id=$order_id";
		$query = $this->con->query($sql); 
		// return $sql;
		if ($query == TRUE) {
			return ['status'=> 202, 'message'=> 'Order updated successfully'];
		}else {
			return ['status'=> 303, 'message'=> 'Verfication Failed'];
		}	
	} 

	// get details of the products in the orders
	public function view_orderDetails($order_id){ 		
		$sql = "SELECT *  FROM order_summary join products on order_summary.product_id = products.product_id join vendors on products.vendor_name = vendors.email WHERE order_summary.order_id=$order_id";	
		$query = $this->con->query($sql);  
		// return $sql;
		if ($query->num_rows > 0) {   
			$result = $query->fetch_all();        
			return ['status'=> 200, 'data'=> $result];
		}else {
			return ['status'=> 303, 'message'=> 'Error Failed'];
		}	
	} 

	// update the delivery status of an order. 
	public function updateDelivery($order_id , $delivery_status){ 
		$sql = "UPDATE orders SET `delivery_status`='$delivery_status' WHERE order_id=$order_id";
		$query = $this->con->query($sql); 
		if ($query == TRUE) {
			return ['status'=> 200, 'message'=> 'Order updated successfully'];
		}else {
			return ['status'=> 303, 'message'=> 'The Delivery Status could not be changed'];
		}	
	} 

	// update the delivery status of a product in an order. 
	public function updateDelivery_product($order_summary_id , $delivery_status){ 
		$sql = "UPDATE order_summary SET `delivery_status`='$delivery_status' WHERE order_sumary_id=$order_summary_id";
		$query = $this->con->query($sql); 
		if ($query == TRUE) {
			return ['status'=> 200, 'message'=> 'Order updated successfully'];
		}else {
			return ['status'=> 303, 'message'=> 'The Delivery Status could not be changed'];
		}	
	} 
	
} 

// call updatepayment function upon ajax call.
if (isset($_POST["confirm_payment"])) {
	$order_id = $_POST['order_id'];
	$payment_token = $_POST['payment_token'];
	$payment_status = $_POST['payment_status'];
	$payment_user = $_POST['payment_user'];
	$a = new Order();
	echo json_encode($a->updatePayment($order_id , $payment_token , $payment_status , $payment_user));
	exit();	
}

// For view order record in ajax
if (isset($_POST["view_order"])) {
	$order_id = $_POST['order_id'];
	$a = new Order();
	echo json_encode($a->view_orderDetails($order_id));
	exit();	
}

// For changing delivery order record in ajax
if (isset($_POST["change_delivery"])) {
	$order_id = $_POST['order_id'];
	$delivery_status = $_POST['delivery_status'];
	$a = new Order();
	echo json_encode($a->updateDelivery($order_id , $delivery_status));
	exit();	
}


// For changing delivery of products in order record in ajax
if (isset($_POST["change_delivery_product"])) {
	$order_summary_id = $_POST['order_sumary_id'];
	$delivery_status = $_POST['delivery_status'];
	$a = new Order();
	echo json_encode($a->updateDelivery_product($order_summary_id , $delivery_status));
	exit();	
}
?>