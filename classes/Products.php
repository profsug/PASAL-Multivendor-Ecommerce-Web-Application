<?php 
session_start();

class Products
{
	
	private $con;

	function __construct()
	{
		include_once("Database.php");
		$db = new Database();
		$this->con = $db->connect();
	}

	public function getProducts(){
		
		$uname= $_SESSION['user'];
		if($uname != 'admin@test.com'){

			$q = $this->con->query("SELECT p.product_id, p.product_title, p.product_price,p.product_qty, p.product_desc, p.product_image, c.cat_title, c.cat_id, b.grade_id, b.grade_title FROM products p 
			JOIN categories c ON c.cat_id = p.product_cat JOIN grade b ON b.grade_id = p.product_grade WHERE p.vendor_name= '$uname'");
			
			$products = [];
			if ($q->num_rows > 0) {
				while($row = $q->fetch_assoc()){
					$products[] = $row;
				}
				//return ['status'=> 202, 'message'=> $ar];
				$_DATA['products'] = $products;
			}

			$categories = [];
			$q = $this->con->query("SELECT * FROM categories ");
			if ($q->num_rows > 0) {
				while($row = $q->fetch_assoc()){
					$categories[] = $row;
				}
				//return ['status'=> 202, 'message'=> $ar];
				$_DATA['categories'] = $categories;
			}

			$grade = [];
			$q = $this->con->query("SELECT * FROM grade ");
			if ($q->num_rows > 0) {
				while($row = $q->fetch_assoc()){
					$grade[] = $row;
				}
				//return ['status'=> 202, 'message'=> $ar];
				$_DATA['grade'] = $grade;
			}


			return ['status'=> 202, 'message'=> $_DATA];
	}
	else{
			$q = $this->con->query("SELECT p.product_id, p.product_title, p.product_price,p.product_qty, p.product_desc, p.product_image, c.cat_title, c.cat_id, b.grade_id, b.grade_title 
			FROM products p JOIN categories c ON c.cat_id = p.product_cat JOIN grade b ON b.grade_id = p.product_grade ");
			
			$products = [];
			if ($q->num_rows > 0) {
				while($row = $q->fetch_assoc()){
					$products[] = $row;
				}
				//return ['status'=> 202, 'message'=> $ar];
				$_DATA['products'] = $products;
			}

			$categories = [];
			$q = $this->con->query("SELECT * FROM categories ");
			if ($q->num_rows > 0) {
				while($row = $q->fetch_assoc()){
					$categories[] = $row;
				}
				//return ['status'=> 202, 'message'=> $ar];
				$_DATA['categories'] = $categories;
			}

			$grade = [];
			$q = $this->con->query("SELECT * FROM grade ");
			if ($q->num_rows > 0) {
				while($row = $q->fetch_assoc()){
					$grade[] = $row;
				}
				//return ['status'=> 202, 'message'=> $ar];
				$_DATA['grade'] = $grade;
			}


			return ['status'=> 202, 'message'=> $_DATA];
		
	}
}

	public function addProduct($product_name,
								$grade_id,
								$category_id,
								$product_desc,
								$product_qty,
								$product_price,
								$file){

		$fileName = $file['name'];
		$fileNameAr= explode(".", $fileName);
		$extension = end($fileNameAr);
		$ext = strtolower($extension);

		if ($ext == "jpg" || $ext == "jpeg" || $ext == "png") {
			
			//print_r($file['size']);

			if ($file['size'] > (1024 * 2)) {
				
				$uniqueImageName = time()."_".$file['name'];
				if (move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT']."/pasal/images/".$uniqueImageName)) {

					$uname= $_SESSION['user'];
					
					
					$q = $this->con->query("INSERT INTO `products`(`product_cat`, `product_grade`, `product_title`,`product_price`, `product_qty`, `product_desc`, `product_image`, `vendor_name`) 
					VALUES ('$category_id', '$grade_id', '$product_name','$product_price', '$product_qty', '$product_desc', '$uniqueImageName', '$uname')");

					if ($q) {
						return ['status'=> 202, 'message'=> 'Product Added Successfully..!'];
					}else{
						return ['status'=> 303, 'message'=> 'Failed to run query'];
					}

				}else{
					return ['status'=> 303, 'message'=> 'Failed to upload image'];
				}

			}else{
				return ['status'=> 303, 'message'=> 'Large Image ,Max Size allowed 2MB'];
			}

		}else{
			return ['status'=> 303, 'message'=> 'Invalid Image Format [Valid Formats : jpg, jpeg, png]'];
		}

	}


	public function editProductWithImage($pid,
										$product_name,
										$grade_id,
										$category_id,
										$product_desc,
										$product_qty,
										$product_price,
										$file){
		$fileName = $file['name'];
		$fileNameAr= explode(".", $fileName);
		$extension = end($fileNameAr);
		$ext = strtolower($extension);


		if ($ext == "jpg" || $ext == "jpeg" || $ext == "png") {
			
			//print_r($file['size']);

			if ($file['size'] > (1024 * 2)) {
				
				$uniqueImageName = time()."_".$file['name'];
				if (move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT']."/pasal/images/".$uniqueImageName)) {

					$uname= $_SESSION['user'];
					$q = $this->con->query("UPDATE products SET 
										product_cat = '$category_id', 
										product_grade= '$grade_id', 
										product_title = '$product_name', 
										product_qty = '$product_qty', 
										product_price = '$product_price', 
										product_desc = '$product_desc', 
										product_image = '$uniqueImageName'
										WHERE product_id = '$pid'");
					if ($q) {
						return ['status'=> 202, 'message'=> 'Product Modified Successfully..!'];
					}else{
						return ['status'=> 303, 'message'=> 'Failed to run query'];
					}

				}else{
					return ['status'=> 303, 'message'=> 'Failed to upload image'];
				}

			}else{
				return ['status'=> 303, 'message'=> 'Large Image ,Max Size allowed 2MB'];
			}

		}else{
			return ['status'=> 303, 'message'=> 'Invalid Image Format [Valid Formats : jpg, jpeg, png]'];
		}

	}

	public function editProductWithoutImage($pid,
										$product_name,
										$grade_id,
										$category_id,
										$product_desc,
										$product_qty,
										$product_price){

		if ($pid != null) {
			$uname= $_SESSION['user'];
			$q = $this->con->query("UPDATE `products` SET 
										`product_cat` = '$category_id', 
										`product_grade` = '$grade_id', 
										`product_title` = '$product_name', 
										`product_qty` = '$product_qty', 
										`product_price` = '$product_price', 
										`product_desc` = '$product_desc'
										WHERE product_id = '$pid'");

			if ($q) {
				return ['status'=> 202, 'message'=> 'Product updated Successfully'];
			}else{
				return ['status'=> 303, 'message'=> 'Failed to run query'];
			}
			
		}else{
			return ['status'=> 303, 'message'=> 'Invalid product id'];
		}
		
	}


	public function getgrade(){
		$q = $this->con->query("SELECT * FROM grade");
		$ar = [];
		if ($q->num_rows > 0) {
			while ($row = $q->fetch_assoc()) {
				$ar[] = $row;
			}
		}
		return ['status'=> 202, 'message'=> $ar];
	}

	public function addCategory($name){
		$uname= $_SESSION['user'];
		$q = $this->con->query("SELECT * FROM categories WHERE cat_title = '$name' LIMIT 1");
		if ($q->num_rows > 0) {
			return ['status'=> 303, 'message'=> 'Category already exists'];
		}else{
			$cn= explode(" ",$name);
			$c_name= implode("_", $cn);
			$q = $this->con->query("INSERT INTO categories (cat_title,vendor_name,cat_name) VALUES ('$name','$uname','$c_name')");
			if ($q) {
				return ['status'=> 202, 'message'=> 'New Category added Successfully'];
			}else{
				return ['status'=> 303, 'message'=> 'Failed to run query'];
			}
		}
	}

	public function getCategories(){
		$q = $this->con->query("SELECT * FROM categories");
		$ar = [];
		if ($q->num_rows > 0) {
			while ($row = $q->fetch_assoc()) {
				$ar[] = $row;
			}
		}
		return ['status'=> 202, 'message'=> $ar];
	}

	public function deleteProduct($pid = null){
		if ($pid != null) {
			$q = $this->con->query("DELETE FROM products WHERE product_id = '$pid'");
			if ($q) {
				return ['status'=> 202, 'message'=> 'Product removed from stocks'];
			}else{
				return ['status'=> 202, 'message'=> 'Failed to run query'];
			}
			
		}else{
			return ['status'=> 303, 'message'=>'Invalid product id'];
		}

	}

	public function deleteCategory($cid = null){
		if ($cid != null) {
			$q = $this->con->query("DELETE FROM categories WHERE cat_id = '$cid'");
			if ($q) {
				return ['status'=> 202, 'message'=> 'Category removed'];
			}else{
				return ['status'=> 202, 'message'=> 'Failed to run query'];
			}
			
		}else{
			return ['status'=> 303, 'message'=>'Invalid cattegory id'];
		}

	}
	
	

	public function updateCategory($post = null){
		extract($post);
		if (!empty($cat_id) && !empty($e_cat_title)) {
			$q = $this->con->query("UPDATE categories SET cat_title = '$e_cat_title' WHERE cat_id = '$cat_id'");
			if ($q) {
				return ['status'=> 202, 'message'=> 'Category updated'];
			}else{
				return ['status'=> 202, 'message'=> 'Failed to run query'];
			}
			
		}else{
			return ['status'=> 303, 'message'=>'Invalid category id'];
		}

	}

	public function addgrade($name){
		$uname= $_SESSION['user'];
		$q = $this->con->query("SELECT * FROM grade WHERE grade_title = '$name' LIMIT 1");
		if ($q->num_rows > 0) {
			return ['status'=> 303, 'message'=> 'grade already exists'];
		}else{
			
			$q = $this->con->query("INSERT INTO grade (grade_title,vendor_name) VALUES ('$name', '$uname')");
			if ($q) {
				return ['status'=> 202, 'message'=> 'New grade added Successfully'];
			}else{
				return ['status'=> 303, 'message'=> 'Failed to run query'];
			}
		}
	}

	public function deletegrade($gid = null){
		if ($gid != null) {
			$q = $this->con->query("DELETE FROM grade WHERE grade_id = '$gid'");
			if ($q) {
				return ['status'=> 202, 'message'=> 'grade removed'];
			}else{
				return ['status'=> 202, 'message'=> 'Failed to run query'];
			}
			
		}else{
			return ['status'=> 303, 'message'=>'Invalid grade id'];
		}

	}
	
	

	public function updategrade($post = null){
		extract($post);
		if (!empty($grade_id) && !empty($e_grade_title)) {
			$q = $this->con->query("UPDATE grade SET grade_title = '$e_grade_title' WHERE grade_id = '$grade_id'");
			if ($q) {
				return ['status'=> 202, 'message'=> 'grade updated'];
			}else{
				return ['status'=> 202, 'message'=> 'Failed to run query'];
			}
			
		}else{
			return ['status'=> 303, 'message'=>'Invalid grade id'];
		}

	}

	

}


if (isset($_POST['GET_PRODUCT'])) {
	if (isset($_SESSION['user'])) {
		$p = new Products();
		echo json_encode($p->getProducts());
		exit();
	}
}


if (isset($_POST['add_product'])) {

	extract($_POST);
	if (!empty($product_name) 
	&& !empty($grade_id) 
	&& !empty($category_id)
	&& !empty($product_desc)
	&& !empty($product_qty)
	&& !empty($product_price)
	&& !empty($_FILES['product_image']['name'])) {
		

		$p = new Products();
		$result = $p->addProduct($product_name,
								$grade_id,
								$category_id,
								$product_desc,
								$product_qty,
								$product_price,
								$_FILES['product_image']);
		
		header("Content-type: application/json");
		echo json_encode($result);
		http_response_code($result['status']);
		exit();


	}else{
		echo json_encode(['status'=> 303, 'message'=> 'Empty fields']);
		exit();
	}



	
}


if (isset($_POST['edit_product'])) {

	extract($_POST);
	if (!empty($pid)
	&& !empty($e_product_name) 
	&& !empty($e_grade_id) 
	&& !empty($e_category_id)
	&& !empty($e_product_desc)
	&& !empty($e_product_qty)
	&& !empty($e_product_price)) {
		
		$p = new Products();

		if (isset($_FILES['e_product_image']['name']) 
			&& !empty($_FILES['e_product_image']['name'])) {
			$result = $p->editProductWithImage($pid,
								$e_product_name,
								$e_grade_id,
								$e_category_id,
								$e_product_desc,
								$e_product_qty,
								$e_product_price,
								$_FILES['e_product_image']);
		}else{
			$result = $p->editProductWithoutImage($pid,
								$e_product_name,
								$e_grade_id,
								$e_category_id,
								$e_product_desc,
								$e_product_qty,
								$e_product_price);
		}

		echo json_encode($result);
		exit();


	}else{
		echo json_encode(['status'=> 303, 'message'=> 'Empty fields']);
		exit();
	}



	
}

if (isset($_POST['GET_grade'])) {
	$p = new Products();
	echo json_encode($p->getgrade());
	exit();
	
}

if (isset($_POST['add_category'])) {
	if (isset($_SESSION['user'])) {
		$cat_title = $_POST['cat_title'];
		if (!empty($cat_title)) {
			$p = new Products();
			echo json_encode($p->addCategory($cat_title));
		}else{
			echo json_encode(['status'=> 303, 'message'=> 'Empty fields']);
		}
	}else{
		echo json_encode(['status'=> 303, 'message'=> 'Session Error']);
	}
}

if (isset($_POST['GET_CATEGORIES'])) {
	$p = new Products();
	echo json_encode($p->getCategories());
	exit();
	
}

if (isset($_POST['DELETE_PRODUCT'])) {
	$p = new Products();
	if (isset($_SESSION['user'])) {
		if(!empty($_POST['pid'])){
			$pid = $_POST['pid'];
			echo json_encode($p->deleteProduct($pid));
			exit();
		}else{
			echo json_encode(['status'=> 303, 'message'=> 'Invalid product id']);
			exit();
		}
	}else{
		echo json_encode(['status'=> 303, 'message'=> 'Invalid Session']);
	}


}


if (isset($_POST['DELETE_CATEGORY'])) {
	if (!empty($_POST['cid'])) {
		$p = new Products();
		echo json_encode($p->deleteCategory($_POST['cid']));
		exit();
	}else{
		echo json_encode(['status'=> 303, 'message'=> 'Invalid details']);
		exit();
	}
}

if (isset($_POST['edit_category'])) {
	if (!empty($_POST['cat_id'])) {
		$p = new Products();
		echo json_encode($p->updateCategory($_POST));
		exit();
	}else{
		echo json_encode(['status'=> 303, 'message'=> 'Invalid details']);
		exit();
	}
}

if (isset($_POST['add_grade'])) {
	if (isset($_SESSION['user'])) {
		$grade_title = $_POST['grade_title'];
		if (!empty($grade_title)) {
			$p = new Products();
			echo json_encode($p->addgrade($grade_title));
		}else{
			echo json_encode(['status'=> 303, 'message'=> 'Empty fields']);
		}
	}else{
		echo json_encode(['status'=> 303, 'message'=> 'Session Error']);
	}
}

if (isset($_POST['DELETE_grade'])) {
	if (!empty($_POST['gid'])) {
		$p = new Products();
		echo json_encode($p->deletegrade($_POST['gid']));
		exit();
	}else{
		echo json_encode(['status'=> 303, 'message'=> 'Invalid details']);
		exit();
	}
}

if (isset($_POST['edit_grade'])) {
	if (!empty($_POST['grade_id'])) {
		$p = new Products();
		echo json_encode($p->updategrade($_POST));
		exit();
	}else{
		echo json_encode(['status'=> 303, 'message'=> 'Invalid details']);
		exit();
	}
}

?>