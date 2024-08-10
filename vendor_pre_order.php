<?php session_start();
ini_set('display_errors', 1);
  if (!isset($_SESSION['user'])) {
  header("location:vendor.php");
}
// print_R($_SESSION);die;
 ?>
<?php include_once("./templates/top.php"); ?>
<?php include_once("./templates/navbar.php"); ?>
<div class="container-fluid">
  <div class="row">
    
    <?php include "./templates/sidebar.php"; ?>

      <div class="row">
      	<div class="col-10">
      		<h2>Pre - Orders</h2>
      	</div>
        <?php 
          include_once("./classes/Database.php");
          $uname= $_SESSION['user'];
          $db = new Database();
          $con = $db->connect(); 
          $query = $con->query("SELECT *,order_summary.delivery_status as product_delivery_status, order_summary.product_qty as ordered_qty FROM order_summary join orders on 
          order_summary.order_id = orders.order_id join products on order_summary.product_id = products.product_id join customers on orders.customer_id = customers.id WHERE orders.pre_order=1 and
           products.vendor_name = '$uname' order by orders.created_at DESC");
          $total= 0;
          if ($query->num_rows > 0) {                
            $result = $query->fetch_all();
            // echo"<pre>";print_r($result);die;
            foreach($result as $row){
              $total = $total + ($row[4] * $row[47]);
            }
          } 
        ?>
       <div class="col-1">
          <h2>Total <?php echo $total; ?></h2>
        </div>
      </div> 

      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>#</th>
              <th width='15%'>Product Image</th>
              <th>Product Name</th>
              <th>Product Price</th>
              <th>Quantity</th>
              <th>Customer</th>
              <th>Total Amount</th>
              <th>Payment Status</th>
              <th>Order Date</th>
              <th>Delivery Status</th>
            </tr>
          </thead>
          <tbody id="customer_order_list">
          <?php 
            if ($query->num_rows > 0) { 
              $i=0; foreach($result as $row){ $i++; ?> 
              <tr>
                <td><?= $i ?></td>
                <td><img src="<?php echo $row[6]; ?>" alt="phone" class="img-fluid mb-2"  ></td>
                <td><?= $row[3] ?></td>
                <td><?= $row[4] ?></td>
                <td><?= $row[47] ?></td>
                <td><?= ucwords($row[39]) ?><br>Address:<?= $row[12] ?> </td>
                <td><?= ($row[4] * $row[47]) ?></td>
                <td><?= $row[18] ?></td>
                <td><?= date('Y-m-d' ,strtotime($row[11])) ?></td>
                <td> <b><?php if($row[46] == ''){echo 'Processing'; $row[46] = 'Processing';  }else{echo $row[46];} ?></b> <br>
                <a href="#" data-toggle="modal" data-target="#change_delivery" class="btn btn-info btn-md"  onclick="change_delivery_status('<?= $row[46] ?>' ,<?= $row[0] ?>)">Change Delivery Status</a></td>
              </tr>
          <?php }
            }?>
          </tbody>
        </table>
         
      </div>
    </main>
  </div>
</div>
  

<script src="js/jquery-1.11.1.min.js"></script>

<!-- contains code of ajax for changing delivery status --> 
<?php include_once("change_delivery_vendor.php"); ?>

<?php include_once("./templates/footer.php"); ?>

 