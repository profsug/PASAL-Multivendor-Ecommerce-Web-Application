<?php session_start(); 
  if (!isset($_SESSION['user'])) {
  header("location:vendor.php");
}
?>
<?php include_once("./templates/top.php"); ?>
<?php include_once("./templates/navbar.php"); ?>
<div class="container-fluid">
  <div class="row">
    
    <?php include "./templates/sidebar.php"; 
    $admin = $_SESSION['user'];
    ?>
    <script type="text/javascript">
    var admin = '<?php echo $_SESSION["user"]; ?>';
        //console.log(admin);
       </script>

<?php 
        if($admin !='admin@test.com'){
      ?>


      <div class="row">
      	<div class="col-10">
      		<h2>Available grades</h2>
      	</div>

      </div>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
<!--               <th>Action</th>
 -->            </tr>
          </thead>
          <tbody id="grade_list">
           
          </tbody>
        </table>
      </div>

    <?php 
      }
    else{ 
      ?>

      <div class="row">
        <div class="col-10">
          <h2>Available grades</h2>
        </div>
        <div class="col-2">
          <a href="#" data-toggle="modal" data-target="#add_grade_modal" class="btn btn-primary btn-sm">Add grade</a>
        </div>
      </div>
      
            <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="grade_list">
          </tbody>
        </table>
      </div>

    <?php 
    }
    ?>
    </main>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="add_grade_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add grade</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="add-grade-form" enctype="multipart/form-data">
        	<div class="row">
        		<div class="col-12">
        			<div class="form-group">
		        		<label>grade Name</label>
		        		<input type="text" name="grade_title" class="form-control" placeholder="Enter grade Name">
		        	</div>
        		</div>
        		<input type="hidden" name="add_grade" value="1">
        		<div class="col-12">
        			<button type="button" class="btn btn-primary add-grade">Add grade</button>
        		</div>
        	</div>
        	
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->

<!-- Edit grade Modal -->
<div class="modal fade" id="edit_grade_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add grade</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="edit-grade-form" enctype="multipart/form-data">
          <div class="row">
            <div class="col-12">
              <input type="hidden" name="grade_id">
              <div class="form-group">
                <label>grade Name</label>
                <input type="text" name="e_grade_title" class="form-control" placeholder="Enter grade Name">
              </div>
            </div>
            <input type="hidden" name="edit_grade" value="1">
            <div class="col-12">
              <button type="button" class="btn btn-primary edit-grade-btn">Update grade</button>
            </div>
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->

<?php include_once("./templates/footer.php"); ?>



<script type="text/javascript" src="./js/grade.js"></script>