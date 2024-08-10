<?php
session_start();
class Admin
{
	private $con;

	function __construct()
	{
		include_once("Database.php");
		$db = new Database();
		$this->con = $db->connect();
	}
	public function getAdminList(){
		$query = $this->con->query("SELECT `id` ,`username`, `email`, `phone`, `street`, `city`, `pincode`, `pan_card`,`validity`  FROM `vendors` WHERE `email` != 'admin@test.com'");
		$ar = [];
		if ($query->num_rows > 0) {
			while ($row = $query->fetch_assoc()) {
				$ar[] = $row;
			}
			return ['status'=> 202, 'message'=> $ar];
		}
		return ['status'=> 303, 'message'=> 'No Admin'];
	}
	public function validateadmin($id){ 
		$sql = "UPDATE vendors SET validity=1 WHERE id=$id";
		$query = $this->con->query($sql); 
		if ($query == TRUE) {
			return ['status'=> 202, 'message'=> 'Vendor verified successfully'];
		}else {
			return ['status'=> 303, 'message'=> 'Verfication Failed'];
		}	
	} 
}
if (isset($_POST["GET_ADMIN"])) {
	if ($_SESSION['user'] == 'admin@test.com') {
		$a = new Admin();
		echo json_encode($a->getAdminList());
		exit();
	}
}
if (isset($_POST["validate_admin"])) {
	if ($_SESSION['user'] == 'admin@test.com') {
		$id = $_POST['id'];
		$a = new Admin();
		echo json_encode($a->validateadmin($id));
		exit();
	}
}
?>