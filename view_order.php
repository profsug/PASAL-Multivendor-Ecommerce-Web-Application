<div class="modal modal-xl" id="view_products" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:80% !important">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="examplemodalLabel">View Order Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th width='10'>#</th>
              <th width='15%'>Image</th>
              <th width='20'>Product Name</th>
              <th width='10'>Quantity</th>
              <th width='10'>Price</th>
              <th width='20'>Vendor Name</th>
              <th width='15'>Buyer Name</th>
              <th width='15'>Buyer Phone</th> 
              <th width='15'>Product Delivery Status</th> 
            </tr>
          </thead>
          <tbody id="view_order_list">           
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
	function view_order(id){
		$("#view_order_list").empty();
		$.ajax({
                url : './classes/Order.php',
                method : 'POST',
                data : {view_order:1, order_id: id},
                success : function(response){
                    console.log(response);

					var resp = $.parseJSON(response);
                    if (resp.status == 200) {
                        console.log(resp.data); 
                        var i = 0;
                        $.each(resp.data, function(index, value) {
                          i++;
                          $('#view_order_list').append('<tr>\
                          <td> ' + i +'</td>\
                          <td> ' + (!(value[6] ) ? " N/A " : '<img src="'+ value[6] +'" alt="phone" style="width:100% !important" >') + ' </td>\
                          <td> ' + (!(value[3] ) ? " N/A " : value[3]) + ' </td>\
                          <td> ' + (!(value[5] ) ? " N/A " : value[5]) + ' </td>\
                          <td> ' + (!(value[4] ) ? " N/A " : value[4]) + ' </td>\
                          <td> ' + (!(value[25] ) ? " N/A " : value[25]) + ' </td>\
                          <td> ' + (!(value[10] ) ? " N/A " : value[10]) + ' </td>\
                          <td> ' + (!(value[9] ) ? " N/A " : value[9]) + ' </td>\
                          <td> ' + (!(value[13] ) ? " Processing " : value[13]) + ' </td>\
                          </tr>');
                        });
                    } else {
                        alert(resp.message);
                    }
                }
            });
	}
</script>