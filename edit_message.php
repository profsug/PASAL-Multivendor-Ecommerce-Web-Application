<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Query and Reply</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="edit_chat" enctype="multipart/form-data" method="post">
          <input type="hidden" id="edit_id" name="id">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label>Query</label>
                <textarea name="query" id='edit_query' rows="2" cols="50"></textarea>                 
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
                <label>Reply</label>
                <textarea name="reply" id='edit_reply' rows="4" cols="50"></textarea> 
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
<script>
	function edit(id ,query , reply){ 
    $('#edit_query').val('');   		
    $('#edit_reply').val(''); 		
    $('#edit_id').val('');    		
    $('#edit_id').val(id);   
    $('#edit_query').val(query);   
    $('#edit_reply').val(reply);   		
    
	}

  $("#edit_chat").submit(function(event)
	{
    event.preventDefault(); 
    var id = $('#edit_id').val();   
    var query = $('#edit_query').val();   
    var reply = $('#edit_reply').val(); 
    $.ajax({
      url : './classes/Message.php',
      type:'POST',
      data:{edit:1, id : id  ,  query:query , reply:reply}, 
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