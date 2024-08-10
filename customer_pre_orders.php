<?php session_start();
ini_set('display_errors', 1);
  if (!isset($_SESSION['user'])) {
  header("location:vendor.php");
}
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
          $query = $con->query("SELECT * FROM orders  join customers on orders.customer_id = customers.id WHERE pre_order=1");
          $total= 0;
          if ($query->num_rows > 0) {                
            $result = $query->fetch_all();
            foreach($result as $row){
              $total = $total + $row[7];
            }
          } 
          // echo"<pre>";print_r($result);die;
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
              <th>Customer</th>
              <th>Total Amount</th>
              <th>Payment Type</th>
              <th>Payment Status</th>
              <th>Order Date</th>
              <th>View Order Details</th>
              <th>Delivery Status</th>
            </tr>
          </thead>
          <tbody id="customer_order_list">
           <?php $i=0; foreach($result as $row){ $i++; ?> 
            <tr>
              <td><?= $i ?></td>
              <td><?= $row[15] ?></td>
              <td><?= $row[7] ?></td>
              <td><?php if($row[2] = 1){echo "Online Payment";}elseif($row[2] == 2){ echo "Cash On Delviery";} ?></td>
              <td><?= $row[3] ?></td>
              <td><?= $row[8] ?></td>
              <td> <a href="#" data-toggle="modal" data-target="#view_products" class="btn btn-success btn-md"  onclick="view_order(<?= $row[0] ?>)">View Products</a></td>
              <td> <b><?= $row[12]?></b> <br>
              <a href="#" data-toggle="modal" data-target="#change_delivery" class="btn btn-info btn-md"  onclick="change_delivery_status('<?= $row[12] ?>' ,<?= $row[0] ?>)">Change Delivery Status</a></td>
            </tr>
           <?php }?>
          </tbody>
        </table>
         
      </div>
    </main>
  </div>
</div>



<script src="js/jquery-1.11.1.min.js"></script>

<!-- contains code of pop-up and ajax of view order and changing delivery status -->
<?php include_once("view_order.php"); ?>
<?php include_once("change_delivery.php"); ?>

<?php include_once("./templates/footer.php"); ?>

 