
<div class="modal" id="change_delivery" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change Delviery Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="update_delivery_product" enctype="multipart/form-data" method="post">
          <input type="hidden" id="order_sumary_id" name="order_sumary_id">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label>Delivery Status</label> <br>
                <input type="radio" id="Processing" name="delivery_status" value="Processing">
                <label for="vehicle1"> Processing</label><br>
                <input type="radio" id="Processed" name="delivery_status" value="Processed">
                <label for="vehicle1"> Processed</label><br>
                <input type="radio" id="Shipping" name="delivery_status" value="Shipping">
                <label for="vehicle1"> Shipping</label><br>
                <input type="radio" id="Delivered" name="delivery_status" value="Delivered">
                <label for="vehicle1"> Delivered</label><br>
                <input type="submit" value="Submit">
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
	function change_delivery_status(status, order_sumary_id){    		
    $('#order_sumary_id').val(order_sumary_id);
    var id = '#' + status;
    $(id).prop('checked', true);
	}

  $("#update_delivery_product").submit(function(event)
	{
    event.preventDefault(); 
    var order_sumary_id = 	$('#order_sumary_id').val();
    var delivery_status = $('input[name="delivery_status"]:checked').val();
    $.ajax({
      url : './classes/Order.php',
      type:'POST',
      data:{change_delivery_product:1, order_sumary_id : order_sumary_id  ,  delivery_status:delivery_status}, 
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
	});
</script>