$(document).ready(function(){

	getgrade();
	
	function getgrade(){
		$.ajax({
			url : './classes/Products.php',
			method : 'POST',
			data : {GET_grade:1},
			success : function(response){
				console.log(response);
				var resp = $.parseJSON(response);

				var gradeHTML = '';

				if(admin != 'admin@test.com'){
				$.each(resp.message, function(index, value){
					gradeHTML += '<tr>'+
									'<td></td>'+
									'<td>'+ value.grade_title +'</td>'+
/*									'<td><a class="btn btn-sm btn-info edit-grade"><span style="display:none;">'+JSON.stringify(value)+'</span><i class="fas fa-pencil-alt"></i></a>&nbsp;<a gid="'+value.grade_id+'" class="btn btn-sm btn-danger delete-grade"><i class="fas fa-trash-alt"></i></a></td>'+
*/								'</tr>';
				});
			}
			else{
				$.each(resp.message, function(index, value){
					gradeHTML += '<tr>'+
									'<td></td>'+
									'<td>'+ value.grade_title +'</td>'+
									'<td><a class="btn btn-sm btn-info edit-grade"><span style="display:none;">'+JSON.stringify(value)+'</span><i class="fas fa-pencil-alt"></i></a>&nbsp;<a gid="'+value.grade_id+'" class="btn btn-sm btn-danger delete-grade"><i class="fas fa-trash-alt"></i></a></td>'+
								'</tr>';
				});
			}

				$("#grade_list").html(gradeHTML);

			}
		})
		
	}


	$(".add-grade").on("click", function(){

		$.ajax({
			url : './classes/Products.php',
			method : 'POST',
			data : $("#add-grade-form").serialize(),
			success : function(response){
				var resp = $.parseJSON(response);
				if (resp.status == 202) {
					getgrade();
					
					alert(resp.message);
				}else if(resp.status == 303){
					alert(resp.message);
				}
				$("#add_grade_modal").modal('hide');
			}
		})

	});

	$(document.body).on('click', '.delete-grade', function(){

		var gid = $(this).attr('gid');

		if (confirm("Are you sure to delete this grade")) {
			$.ajax({
				url : './classes/Products.php',
				method : 'POST',
				data : {DELETE_grade:1, gid:gid},
				success : function(response){
					var resp = $.parseJSON(response);
					if (resp.status == 202) {
						alert(resp.message);
						getgrade();
					}else if(resp.status == 303){
						alert(resp.message);
					}
				}
			});
		}else{
			alert('Cancelled');
		}

		

	});

	$(document.body).on("click", ".edit-grade", function(){

		var grade = $.parseJSON($.trim($(this).children("span").html()));
		console.log(grade);
		$("input[name='e_grade_title']").val(grade.grade_title);
		$("input[name='grade_id']").val(grade.grade_id);

		$("#edit_grade_modal").modal('show');

		

	});

	$(".edit-grade-btn").on("click", function(){
		$.ajax({
			url : './classes/Products.php',
			method : 'POST',
			data : $("#edit-grade-form").serialize(),
			success : function(response){
				var resp = $.parseJSON(response);
				if (resp.status == 202) {
					getgrade();
					$("#edit_grade_modal").modal('hide');
					alert(resp.message);
				}else if(resp.status == 303){
					alert(resp.message);
				}
				
			}
		});
	});

});