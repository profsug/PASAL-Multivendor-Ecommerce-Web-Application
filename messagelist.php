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
      		<h2>Chat question and Replies</h2>
      	</div>
        <?php 
          include_once("./classes/Database.php");
          $uname= $_SESSION['user'];
          $db = new Database();
          $con = $db->connect(); 
          $query = $con->query("SELECT * FROM messages");
          
          if ($query->num_rows > 0) {                
            $result = $query->fetch_all(); 
          }  
        ?> 
      </div> 
      <a href="#" data-toggle="modal" data-target="#chat" class="btn btn-success btn-sm pull-right"  onclick="change_delivery_status()">Add Chat</a>

      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>#</th>
              <th>Question</th>
              <th>Reply</th>              
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="customer_order_list">
           <?php $i=0; foreach($result as $row){ $i++; ?> 
            <tr>
              <td><?= $i ?></td>
              <td><?= $row[1] ?></td>
              <td><?= $row[2] ?></td>              
              <td> 
              <a href="#" data-toggle="modal" data-target="#edit" class="btn btn-info btn-md"  onclick="edit(<?= $row[0] ?> , '<?= $row[1] ?>' , ' <?= $row[2] ?>')">Edit</a>
              <a href="#" class="btn btn-danger btn-md" onclick="delete_record(<?= $row[0] ?>)">Delete</a>
              </td>
            </tr>
           <?php }?>
          </tbody>
        </table>
        
      </div>
    </main>
  </div>
</div>

<?php
$q3= "SELECT * FROM vendors WHERE email='$uname'";
$data3= mysqli_query($con, $q3);
while($res3= mysqli_fetch_assoc($data3)){
  $sname= $res3['username'];
  $sphone= $res3['phone'];
}
if(isset($_POST['deliver'])){
  $q2= "SELECT * FROM delivery WHERE pincode= (SELECT pincode from vendors where email='$uname') ";
  $data2= mysqli_query($con, $q2);
  while($res2= mysqli_fetch_assoc($data2)){
    $del= $res2['email'];
    send_email($del, $uname, $sname, $sphone);
  }
}
?>
<div class="modal fade" id="chat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Query and Reply</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="add_chat" enctype="multipart/form-data" method="post">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label>Query</label>
                <textarea name="query" id='query' rows="2" cols="50"></textarea>                 
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Reply</label>
                <textarea name="reply" id='reply' rows="4" cols="50"></textarea> 
              </div>
            </div>
            <div class="col-12">
              <input name="deli" type="submit" class="btn btn-primary add-category" value="Add">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<?php 
if(isset($_POST['deli']))
{
  $order_id= $_POST['order_id'];
  $name= $_POST['del_guy'];

  $q2= $con->query("UPDATE orders SET delivery_status='$name' WHERE payment_id='$order_id' AND vendor_name='$uname'");
  echo "<script type='text/javascript'>alert('Delivery Updated');</script>";
}

?>

<script src="js/jquery-1.11.1.min.js"></script>
<script>
  $("#add_chat").submit(function(event)
	{
    event.preventDefault(); 
    var query = 	$('#query').val();
    var reply = 	$('#reply').val();
    $.ajax({
      url : './classes/Message.php',
      type:'POST',
      data:{add:1, query : query, reply:reply}, 
      error :function(xhr, ajaxOptions, thrownError)
      {
      console.log(xhr);
      console.log(ajaxOptions);
      console.log(thrownError);
      },
      success:function(msg)
      {
        console.log(msg);
        var resp = $.parseJSON(msg);
        if (resp.status == 202) { 
            location.reload();
        } else {
            alert(resp.message);
        }
      }
    }); 
	});

  function delete_record(id){ 	
    $.ajax({
      url : './classes/Message.php',
      type:'POST',
      data:{delete:1, id : id}, 
      error :function(xhr, ajaxOptions, thrownError)
      {
      console.log(xhr);
      console.log(ajaxOptions);
      console.log(thrownError);
      },
      success:function(msg)
      {
        console.log(msg);
        var resp = $.parseJSON(msg);
        if (resp.status == 200) { 
            location.reload();
        } else {
            alert(resp.message);
        }
      }
    }); 
	}
</script>
<?php include_once("edit_message.php"); ?>
<?php include_once("./templates/footer.php"); ?>

 