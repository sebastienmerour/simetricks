<?php 
include('header.php');
include_once("db_connect.php");
?>
<title>phpzag.com : Demo Ajax Registration Script with PHP, MySQL and jQuery</title>
<script type="text/javascript" src="script/getData.js"></script>
<?php include('container.php');?>

<div class="container">
	<h2>Example: Ajax Drop Down Selection Data Load with PHP & MySQL</h2>		
	
	<div class="page-header">
        <h3>
        <select id="employee">
        <option value="" selected="selected">Select Employee Name</option>
		<?php
		$sql = "SELECT id, employee_name, employee_salary, employee_age FROM employee LIMIT 10";
		$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
		while( $rows = mysqli_fetch_assoc($resultset) ) { 
		?>
		<option value="<?php echo $rows["id"]; ?>"><?php echo $rows["employee_name"]; ?></option>
		<?php }	?>
		</select>
        </h3>	
        </div>		
		<div id="display">
			<div class="row" id="heading" style="display:none;"><h3><div class="col-sm-4"><strong>Employee Name</strong></div><div class="col-sm-4"><strong>Age</strong></div><div class="col-sm-4"><strong>Salary</strong></div></h3></div><br>			
			<div class="row" id="records"><div class="col-sm-4" id="emp_name"></div><div class="col-sm-4" id="emp_age"></div><div class="col-sm-4" id="emp_salary"></div></div>			
			<div class="row" id="no_records"><div class="col-sm-4">Plese select employee name to view details</div></div>
        </div>		
	<div style="margin:50px 0px 0px 0px;">
		<a class="btn btn-default read-more" style="background:#3399ff;color:white" href="http://www.phpzag.com/ajax-drop-down-selection-data-load-with-php-mysql" title="">Back to Tutorial</a>			
	</div>		
</div>
<?php include('footer.php');?>