$(document).ready(function(){

	getAdmins();
	
	function getAdmins(){
	  $.ajax({
		url : './classes/Admin.php',
		method : 'POST',
		data : {GET_ADMIN:1},
		success : function(response){
		  console.log(response);
		  var resp = $.parseJSON(response);
  
		  if (resp.status == 202) {
			var adminHTML = '';
  
			$.each(resp.message, function(index, value){
			  adminHTML += '<tr>'+
							  '<td>#</td>'+
							  '<td>'+ value.username +'</td>'+
							  '<td>'+ value.email +'</td>'+
							  '<td>'+ value.phone +'</td>'+
							  '<td>'+value.street+'<br>'+value.city+'<br>'+value.pincode+'</td>'+
							  '<td><a class="btn btn-sm btn-danger delete-admin" data-id="'+value.id+'"class="btn btn-sm btn-danger delete-admin"><i class="fas fa-trash-alt"></i></a>' + 
							  ((value.validity == 0) ? '<a class="btn btn-sm btn-primary validate-admin" value="'+value.id+'"class="btn btn-sm btn-danger validate-admin">Validate</a>' : '')
							   + '</td>'+
						  '</tr>';
			});
  
			$("#admin_list").html(adminHTML);
  
		  }else if(resp.status == 303){
			$("#admin_list").html(resp.message);
		  }
		}
	  }) 
	}
  
	// Show confirmation dialog when delete button is clicked
	$("#admin_list").on('click','.delete-admin', function(){
	  var admin_id = $(this).data("id");
	  var confirmation = confirm("Are you sure you want to delete this admin?");
	  if (confirmation) {
		$.ajax({
		  url : './classes/Admin.php',
		  method : 'POST',
		  data : {DELETE_ADMIN:1, id: admin_id},
		  success : function(response){
			console.log(response);
			var resp = $.parseJSON(response);
  
			if (resp.status == 202) {
			  alert(resp.message);
			  getAdmins();
			} else {
			  alert(resp.message);
			}
		  }
		});
	  }else{
		alert('Cancelled');
	  }
	});


	// Show confirmation dialog when delete button is clicked
	$("#admin_list").on('click','.validate-admin', function(){
		var admin_id = $(this).attr("value");
		var confirmation = confirm("Are you sure you want to validate this admin?");
		if (confirmation) {
			$.ajax({
			url : './classes/Admin.php',
			method : 'POST',
			data : {validate_admin:1, id: admin_id},
				success : function(response){
					console.log(response);
					var resp = $.parseJSON(response);  
					if(resp.status == 202){
						alert(resp.message);
						location.reload();
					}else{
						alert(resp.message);
					}
				}
			});
		}else{
			alert('Cancelled');
		}
		});
  
	
  
  });
  