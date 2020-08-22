$(document).ready(function(){
	// code to get all records from table via select box
	$("#category").change(function() {
		var id = $(this).find(":selected").val();
		var dataString = 'catid='+ id;
		$.ajax({
			url: 'admintricks/extendedcardsadmin',
			dataType: "json",
			data: dataString,
			cache: false,
			success: function(categoryData) {
			   if(categoryData) {
					$("#heading").show();
					$("#no_records").hide();
					$("#item_date").text(categoryData.date_creation_fr);
					$("item_author").text(categoryData.employee_age);
					$("item_image").text(categoryData.employee_salary);
					$("#item_title").text(categoryData.date_creation_fr);
					$("item_draft").text(categoryData.employee_age);
					$("item_modify").text(categoryData.employee_salary);
					$("#item_delete").text(categoryData.date_creation_fr);
					$("#records").show();
				} else {
					$("#heading").hide();
					$("#records").hide();
					$("#no_records").show();
				}
			}
		});
 	})
});
