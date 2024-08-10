<?php
session_start();
/**
 * 
 */
class Message
{
	private $con;

	function __construct()
	{
		include_once("Database.php");
		$db = new Database();
		$this->con = $db->connect();
	} 

	// Get the response of a query by using like query. 
	public function get_message($text){ 
		$sql = "SELECT reply FROM messages WHERE question LIKE '%$text%'";
		$query = $this->con->query($sql); 

		if ($query->num_rows > 0) {   
			$result = $query->fetch_assoc(); 
			$reply = $result['reply'];
			return $reply;
		}else {
			return "We are currently away We will contact you as  soon as possible";
		}	
	} 

	// insert into messages
	public function add($query , $reply){  
		$sql = "INSERT INTO `messages` (`question` , `reply`) VALUES ('$query' ,'$reply')";
		$query = $this->con->query($sql); 		
		if ($query == TRUE) {
			return ['status'=> 202, 'message'=> 'Inserted successfully'];
		}else {
			return ['status'=> 303, 'message'=> 'Insertion Failed'];
		}	
	} 

	// edit  a query and the reply
	public function edit($id , $query , $reply){ 
		$sql = "UPDATE messages SET `question`='$query', `reply`='$reply' WHERE id=$id";
		$query = $this->con->query($sql); 
		if ($query == TRUE) {
			return ['status'=> 200, 'message'=> 'Chat updated successfully'];
		}else {
			return ['status'=> 303, 'message'=> 'Edit Failed'];
		}	
	} 
	
	// delete a record
	public function delete($id){ 
		$sql = "DELETE FROM messages WHERE id=$id";
		$query = $this->con->query($sql); 
		if ($query == TRUE) {
			return ['status'=> 200, 'message'=> 'Chat deleted successfully'];
		}else {
			return ['status'=> 303, 'message'=> 'Delete Failed'];
		}	
	} 	
} 

// redirect to get_message function on ajax call
if (isset($_POST["get_message"])) {
	$text = $_POST['text'];
	$a = new Message(); 
	echo json_encode($a->get_message($text));
	exit();	
}

// redirect to add function on ajax call
if (isset($_POST["add"])) {
	$query = $_POST['query'];
	$reply = $_POST['reply'];
	$a = new Message(); 
	echo json_encode($a->add($query , $reply));
	exit();	
}

// redirect to edit function on ajax call
if (isset($_POST["edit"])) {
	$id = $_POST['id'];
	$query = $_POST['query'];
	$reply = $_POST['reply'];
	$a = new Message(); 
	echo json_encode($a->edit($id, $query , $reply));
	exit();	
}

// redirect to delete function on ajax call
if (isset($_POST["delete"])) {
	$id = $_POST['id'];
	$a = new Message(); 
	echo json_encode($a->delete($id));
	exit();	
} 
?>