<footer class="shadow container-fluid">
  <div class="row text-center">
    <div class="col-12 bg-danger p-3">
       <h6 class="lead font-weight-bold text-white"><?= WEBSITE_NAME. ' | &copy; '.COPYRIGHT_YEAR ;?></h6>
    </div>
  </div>
</footer>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>$("#loader").hide();
</script>
<script>

  //jQuery(function($) {
	$(document).ready(function(){

		$("#items-list").change(function(){

				$("#loader").show();

        var option = $(this).find('option:selected');
        window.location.href = option.data("url");

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

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<!-- Custom jquery for this theme -->
<script src="<?php echo BASE_URL; ?>public/jquery/add_links.js"></script>
<script src="<?= BASE_URL; ?>public/js/prism.js"></script>

<!-- Custom JavaScript for this theme -->
<script src="<?php echo BASE_URL; ?>public/js/scroll.js"></script>
<script src="<?php echo BASE_URL; ?>public/js/password_policy.js"></script>
<!-- Icons -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>feather.replace()</script>
<script>
    $('#uploadimage').on('change',function(){
        //get the file name
        var fileName = $(this).val();
        fileName = fileName.substring(fileName.lastIndexOf("\\") + 1, fileName.length);
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
    })
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
</body>
</html>
