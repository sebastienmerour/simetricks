<!-- Page Content -->
<div class="container-fluid">
  <div class="row">
<?= $content; ?>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>$("#loader").hide();
</script>
<script>
  //jQuery(function($) {
	$(document).ready(function(){

		$("#items-list").change(function(){

				$("#loader").show();

				var getCatID = $(this).val();

				if(getCatID != '0')
				{
					$.ajax({
						type: 'POST',
						url: 'extendedcardsadmin/ajax',
						data: {catid:getCatID},
						success: function(data){
							$("#loader").hide();
							$("#items-default").hide();
							$("#items-data").html(data);
						}
					});
				}

				else
				{
									$("#items-default").html();
									$("#items-data").hide();
									$("#loader").hide();
								}
		});

	});

</script>
